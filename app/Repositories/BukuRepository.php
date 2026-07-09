<?php

namespace App\Repositories;

use App\Models\KatalogBuku;
use App\Repositories\Interfaces\BukuRepositoryInterface;
use Illuminate\Http\Request;

class BukuRepository implements BukuRepositoryInterface
{
    public function getBukuWelcome()
    {
        return KatalogBuku::where('status_buku', 'Dibutuhkan')
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getBukuDashboard()
    {
        return KatalogBuku::where('status_buku', 'Dibutuhkan')
            ->orderByRaw("CASE WHEN badge = 'Prioritas' THEN 1 ELSE 2 END")
            ->latest()
            ->get();
    }

    public function getBukuBerdasarkanFilter(Request $request)
    {
        $query = KatalogBuku::where('status_buku', 'Dibutuhkan');

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
                $query->where('stok_dibutuhkan', '>', 10)->orWhere('badge', 'like', '%Bestseller%');
            } elseif ($request->filter == 'prioritas') {
                $query->where('badge', 'Prioritas');
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
                $query->orderBy('id', 'desc');
            } elseif ($request->sort == 'Harga: Rendah ke Tinggi') {
                $query->orderBy('harga_estimasi', 'asc');
            } elseif ($request->sort == 'Harga: Tinggi ke Rendah') {
                $query->orderBy('harga_estimasi', 'desc');
            }
        } else {
            $query->latest();
        }

        return $query->paginate(12);
    }

    public function getBukuById($id)
    {
        return KatalogBuku::findOrFail($id);
    }

    public function getBukuTerkait($kategori, $id_sekarang)
    {
        $buku_terkait = KatalogBuku::where('kategori', $kategori)
            ->where('id', '!=', $id_sekarang)
            ->where('status_buku', 'Dibutuhkan')
            ->inRandomOrder()
            ->take(10)
            ->get();
            
        if ($buku_terkait->isEmpty()) {
            $buku_terkait = KatalogBuku::where('id', '!=', $id_sekarang)
                ->where('status_buku', 'Dibutuhkan')
                ->inRandomOrder()
                ->take(10)
                ->get();
        }

        return $buku_terkait;
    }
}
