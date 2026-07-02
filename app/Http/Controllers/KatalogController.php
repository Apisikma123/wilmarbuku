<?php

namespace App\Http\Controllers;

use App\Models\KatalogBuku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $buku = KatalogBuku::all();
        if ($request->is('donasi')) {
            return view('donasi', compact('buku'));
        }
        return view('welcome', compact('buku'));
    }

    public function dashboard()
    {
        session(['is_user' => true]);
        $buku = KatalogBuku::all();
        $riwayat = \App\Models\TransaksiDetail::with('buku')
            ->whereHas('transaksi', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->take(4)
            ->get();
        return view('dashboard', compact('buku', 'riwayat'));
    }
    public function kategori(Request $request)
    {
        session(['is_user' => true]);
        $query = KatalogBuku::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
        }

        if ($request->has('filter') && !empty($request->filter)) {
            $filter = $request->filter;
            if ($filter == 'terbaru') {
                $query->latest();
            } else {
                $query->where('kategori', 'like', "%{$filter}%");
            }
        }

        $buku = $query->paginate(12);
        
        return view('kategori', compact('buku'));
    }

    public function show($id)
    {
        $buku = KatalogBuku::findOrFail($id);
        return view('buku', compact('buku'));
    }
}
