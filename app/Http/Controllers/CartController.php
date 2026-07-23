<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KatalogBuku;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCartData()
    {
        return Auth::check() ? (Auth::user()->cart_data ?? []) : session()->get('cart_data', []);
    }

    private function saveCartData($cart)
    {
        if (Auth::check()) {
            \Illuminate\Support\Facades\DB::table('users')
                ->where('id', Auth::id())
                ->update(['cart_data' => json_encode($cart)]);
        } else {
            session()->put('cart_data', $cart);
        }
    }

    private function getCartIdentifier()
    {
        return Auth::check() ? Auth::id() : session()->getId();
    }

    public function index()
    {
        $cart = $this->getCartData();
        \Illuminate\Support\Facades\Log::info('Cart Check: ', ['db_cart' => $cart, 'count' => count($cart)]);
        
        // Cek stok real-time (Optimasi N+1 Query)
        $bukuIds = array_keys($cart);
        $bukus = KatalogBuku::whereIn('id', $bukuIds)->get()->keyBy('id');
        
        foreach ($cart as $id => &$item) {
            $buku = $bukus->get($id);
            if ($buku) {
                $item['judul_buku'] = $buku->judul_buku;
                $item['pengarang'] = $buku->pengarang;
                $item['kategori'] = $buku->kategori;
                $item['cover_image'] = $buku->cover_image;
                $item['harga_estimasi'] = $buku->harga_estimasi;
                $item['stok_dibutuhkan'] = $buku->stok_dibutuhkan;
                // Pastikan qty tidak melebihi stok yang ada
                $item['qty'] = min($item['qty'], $buku->stok_dibutuhkan);
            } else {
                $item['stok_dibutuhkan'] = 0;
                $item['qty'] = 0;
            }
        }
        unset($item); // Mencegah bug referensi PHP di perulangan selanjutnya
        
        return view('cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $buku = KatalogBuku::findOrFail($id);
        $qty = (int) $request->input('qty', 1);
        
        \Illuminate\Support\Facades\Log::info('Add Cart Request Called', [
            'identifier' => $this->getCartIdentifier(),
            'book_id' => $id,
            'qty' => $qty,
            'is_ajax' => $request->ajax(),
            'wants_json' => $request->wantsJson()
        ]);

        $item = [
            'id' => $buku->id,
            'judul_buku' => $buku->judul_buku,
            'pengarang' => $buku->pengarang,
            'kategori' => $buku->kategori,
            'cover_image' => $buku->cover_image,
            'harga_estimasi' => $buku->harga_estimasi,
            'qty' => min($qty, $buku->stok_dibutuhkan),
            'stok_dibutuhkan' => $buku->stok_dibutuhkan,
            'pesan_dukungan' => '',
        ];

        if ($request->input('action') === 'checkout') {
            session()->put('buy_now_cart', [$id => $item]);
            return redirect()->route('checkout', ['type' => 'buy_now']);
        }

        $cart = $this->getCartData();
        
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] + $qty > $buku->stok_dibutuhkan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').',
                ]);
            }
            $cart[$id]['qty'] = $cart[$id]['qty'] + $qty;
        } else {
            if ($qty > $buku->stok_dibutuhkan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').',
                ]);
            }
            $cart[$id] = $item;
        }

        $this->saveCartData($cart);
        
        $cartQty = 0;
        foreach ($cart as $c) {
            $cartQty += $c['qty'];
        }
        
        try {
            event(new \App\Events\CartUpdated($this->getCartIdentifier(), $cartQty, Auth::check()));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Broadcast error: ' . $e->getMessage());
        }
        
        return response()->json([
            'success' => true, 
            'message' => 'Buku ditambahkan ke keranjang!',
            'cart_count' => $cartQty,
            'item_qty' => $cart[$id]['qty'],
            'stok_dibutuhkan' => $buku->stok_dibutuhkan
        ]);
    }

    public function update(Request $request)
    {
        if ($request->id && $request->qty) {
            $cart = $this->getCartData();
            $buku = KatalogBuku::find($request->id);
            if ($buku) {
                $qty = max(1, min($request->qty, $buku->stok_dibutuhkan));
                $cart[$request->id]["qty"] = $qty;
                $cart[$request->id]["stok_dibutuhkan"] = $buku->stok_dibutuhkan;
            } else {
                $cart[$request->id]["qty"] = max(1, $request->qty);
            }
            if ($request->has('pesan_dukungan')) {
                $cart[$request->id]["pesan_dukungan"] = $request->pesan_dukungan;
            }
            
            $this->saveCartData($cart);

            $total = 0;
            $count = 0;
            foreach ($cart as $item) {
                $total += $item['harga_estimasi'] * $item['qty'];
                $count += $item['qty'];
            }
            
            try {
                event(new \App\Events\CartUpdated($this->getCartIdentifier(), $count, Auth::check()));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Broadcast error: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'item_subtotal' => $cart[$request->id]['harga_estimasi'] * $cart[$request->id]['qty'],
                'cart_total' => $total,
                'cart_count' => $count
            ]);
        }
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = $this->getCartData();
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                $this->saveCartData($cart);
                
                $count = 0;
                $total = 0;
                foreach ($cart as $item) {
                    $count += $item['qty'];
                    $total += $item['qty'] * $item['harga_estimasi'];
                }
                
                try {
                    event(new \App\Events\CartUpdated($this->getCartIdentifier(), $count, Auth::check()));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Broadcast error: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'cart_count' => $count,
                    'cart_total' => $total
                ]);
            }
        }
        return redirect()->back();
    }

    public function getCount()
    {
        $cart = $this->getCartData();
        $cartQty = 0;
        foreach ($cart as $item) {
            $cartQty += $item['qty'];
        }
        return response()->json([
            'cart_count' => $cartQty
        ]);
    }
}
