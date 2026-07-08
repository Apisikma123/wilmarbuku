<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KatalogBuku;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart_data ?? [];
        \Illuminate\Support\Facades\Log::info('Cart Check: ', ['db_cart' => $cart, 'count' => count($cart)]);
        
        // Cek stok real-time
        foreach ($cart as $id => &$item) {
            $buku = KatalogBuku::find($id);
            if ($buku) {
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

        $cart = Auth::user()->cart_data ?? [];
        
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] + $qty > $buku->stok_dibutuhkan) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').',
                    ]);
                }
                return redirect()->back()->with('error', 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').');
            }
            $cart[$id]['qty'] = $cart[$id]['qty'] + $qty;
        } else {
            if ($qty > $buku->stok_dibutuhkan) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').',
                    ]);
                }
                return redirect()->back()->with('error', 'Stok buku ini tidak mencukupi untuk jumlah yang Anda minta (Maks: '.$buku->stok_dibutuhkan.').');
            }
            $cart[$id] = $item;
        }

        Auth::user()->update(['cart_data' => $cart]);
        
        if ($request->ajax() || $request->wantsJson()) {
            $cartQty = 0;
            foreach ($cart as $c) {
                $cartQty += $c['qty'];
            }
            return response()->json([
                'success' => true, 
                'message' => 'Buku ditambahkan ke keranjang!',
                'cart_count' => $cartQty
            ]);
        }
        
        return redirect()->back()->with('success', 'Buku ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->qty) {
            $cart = Auth::user()->cart_data ?? [];
            $buku = KatalogBuku::find($request->id);
            if ($buku) {
                $qty = min($request->qty, $buku->stok_dibutuhkan);
                $cart[$request->id]["qty"] = $qty;
                $cart[$request->id]["stok_dibutuhkan"] = $buku->stok_dibutuhkan;
            } else {
                $cart[$request->id]["qty"] = $request->qty;
            }
            if ($request->has('pesan_dukungan')) {
                $cart[$request->id]["pesan_dukungan"] = $request->pesan_dukungan;
            }
            Auth::user()->update(['cart_data' => $cart]);

            if ($request->ajax() || $request->wantsJson()) {
                $total = 0;
                $count = 0;
                foreach ($cart as $item) {
                    $total += $item['harga_estimasi'] * $item['qty'];
                    $count += $item['qty'];
                }
                return response()->json([
                    'success' => true,
                    'item_subtotal' => $cart[$request->id]['harga_estimasi'] * $cart[$request->id]['qty'],
                    'cart_total' => $total,
                    'cart_count' => $count
                ]);
            }
        }
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = Auth::user()->cart_data ?? [];
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Auth::user()->update(['cart_data' => $cart]);
            }
        }
        return redirect()->back();
    }
}
