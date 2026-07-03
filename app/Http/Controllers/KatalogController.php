<?php

namespace App\Http\Controllers;

use App\Models\KatalogBuku;
use App\Models\Kategori;
use App\Models\Penerbit;
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
        
        $categories = Kategori::orderBy('nama_kategori')->get();
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();
        
        return view('dashboard', compact('buku', 'riwayat', 'categories', 'penerbits'));
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

        if ($request->has('kategori') && is_array($request->kategori)) {
            $query->where(function($q) use ($request) {
                foreach ($request->kategori as $cat) {
                    $q->orWhere('kategori', 'like', '%' . $cat . '%');
                }
            });
        }

        if ($request->has('filter') && !empty($request->filter)) {
            if ($request->filter == 'bulan_ini') {
                $query->where('created_at', '>=', now()->subMonth());
            } elseif ($request->filter == 'bestseller') {
                // Dummy logic for bestseller: assume books with high stok_dibutuhkan or specific badge
                $query->where('stok_dibutuhkan', '>', 10)->orWhere('badge', 'like', '%Bestseller%');
            }
        }

        if ($request->has('penerbit') && is_array($request->penerbit)) {
            $query->whereIn('penerbit', $request->penerbit);
        }

        if ($request->has('pengarang') && is_array($request->pengarang)) {
            $query->whereIn('pengarang', $request->pengarang);
        }

        if ($request->has('sort') && !empty($request->sort)) {
            if ($request->sort == 'Terbaru') {
                $query->latest();
            } elseif ($request->sort == 'Terpopuler') {
                // Dummy sort for popular (we can just use id for now)
                $query->orderBy('id', 'desc');
            } elseif ($request->sort == 'Harga: Rendah ke Tinggi') {
                $query->orderBy('harga_estimasi', 'asc');
            } elseif ($request->sort == 'Harga: Tinggi ke Rendah') {
                $query->orderBy('harga_estimasi', 'desc');
            }
        } else {
            $query->latest();
        }

        $buku = $query->paginate(12);
        
        $categories = Kategori::orderBy('nama_kategori')->get();
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();

        return view('kategori', compact('buku', 'categories', 'penerbits'));
    }

    public function show($id)
    {
        $buku = KatalogBuku::findOrFail($id);
        return view('buku', compact('buku'));
    }
}
