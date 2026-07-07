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
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id' => $buku->id,
                'judul_buku' => $buku->judul_buku,
                'pengarang' => $buku->pengarang,
                'kategori' => $buku->kategori,
                'cover_image' => $buku->cover_image,
                'harga_estimasi' => $buku->harga_estimasi,
                'qty' => 1,
                'pesan_dukungan' => '',
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Buku ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->qty) {
            $cart = session()->get('cart');
            $cart[$request->id]["qty"] = $request->qty;
            if ($request->has('pesan_dukungan')) {
                $cart[$request->id]["pesan_dukungan"] = $request->pesan_dukungan;
            }
            session()->put('cart', $cart);
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
