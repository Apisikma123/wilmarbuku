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
        $bukuIds = \Illuminate\Support\Facades\Cache::remember('random_buku_ids', 60, function () {
            $badge = \App\Models\Setting::where('key', 'landing_badge')->value('value');
            $query = KatalogBuku::where('status_buku', 'Dibutuhkan');
            if ($badge && $badge !== 'Acak') {
                $query->where('badge', $badge);
            }
            return $query->pluck('id')->toArray();
        });
        
        $buku = collect();
        if (!empty($bukuIds)) {
            $randomIds = \Illuminate\Support\Arr::random($bukuIds, min(4, count($bukuIds)));
            $buku = KatalogBuku::whereIn('id', $randomIds)->get();
        }
        $mahasiswaCount = \App\Models\User::where('role', 'user')->count();
        if ($request->is('donasi')) {
            return view('donasi', compact('buku'));
        }
        return view('welcome', compact('buku', 'mahasiswaCount'));
    }

    public function dashboard()
    {
        session(['is_user' => true]);
        $buku = KatalogBuku::where('status_buku', 'Dibutuhkan')
            ->orderByRaw("CASE WHEN badge = 'Prioritas' THEN 1 ELSE 2 END")
            ->latest()
            ->get();
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
                // Dummy logic for bestseller: assume books with high stok_dibutuhkan or specific badge
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
                $query->orderBy('terdonasi', 'desc')->orderBy('id', 'desc');
            } elseif ($request->sort == 'Harga: Rendah ke Tinggi') {
                $query->orderBy('harga_estimasi', 'asc');
            } elseif ($request->sort == 'Harga: Tinggi ke Rendah') {
                $query->orderBy('harga_estimasi', 'desc');
            }
        } else {
            $query->latest();
        }

        $buku = $query->paginate(12);
        
        return view('kategori', compact('buku'));
    }

    public function show($id)
    {
        $buku = KatalogBuku::findOrFail($id);
        $bukuIdsTerkait = \Illuminate\Support\Facades\Cache::remember('buku_terkait_ids_' . $buku->kategori, 60, function () use ($buku, $id) {
            return KatalogBuku::where('kategori', $buku->kategori)
                ->where('id', '!=', $id)
                ->where('status_buku', 'Dibutuhkan')
                ->pluck('id')->toArray();
        });
        
        $buku_terkait = collect();
        if (!empty($bukuIdsTerkait)) {
            $randomIds = \Illuminate\Support\Arr::random($bukuIdsTerkait, min(10, count($bukuIdsTerkait)));
            $buku_terkait = KatalogBuku::whereIn('id', $randomIds)->get();
        }
            
        if ($buku_terkait->isEmpty()) {
            $semuaBukuIds = \Illuminate\Support\Facades\Cache::remember('semua_buku_ids_kecuali_' . $id, 60, function () use ($id) {
                return KatalogBuku::where('id', '!=', $id)
                    ->where('status_buku', 'Dibutuhkan')
                    ->pluck('id')->toArray();
            });
            
            if (!empty($semuaBukuIds)) {
                $randomIds = \Illuminate\Support\Arr::random($semuaBukuIds, min(10, count($semuaBukuIds)));
                $buku_terkait = KatalogBuku::whereIn('id', $randomIds)->get();
            }
        }

        return view('buku', compact('buku', 'buku_terkait'));
    }
}
