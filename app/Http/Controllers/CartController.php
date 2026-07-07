<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KatalogBuku;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return response()->view('cart', compact('cart'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
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

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] >= $buku->stok_dibutuhkan) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda sudah memasukkan jumlah maksimal buku ini di keranjang.',
                    ]);
                }
                return redirect()->back()->with('error', 'Anda sudah memasukkan jumlah maksimal buku ini di keranjang.');
            }
            $cart[$id]['qty'] = min($cart[$id]['qty'] + $qty, $buku->stok_dibutuhkan);
        } else {
            $cart[$id] = $item;
        }

        session()->put('cart', $cart);
        
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
            $cart = session()->get('cart');
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
            session()->put('cart', $cart);

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
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back();
    }
}
