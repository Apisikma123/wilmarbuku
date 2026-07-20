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
            $query->where(function($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori')) {
            $categories = is_array($request->kategori) ? $request->kategori : [$request->kategori];
            $categories = array_filter($categories);
            if (!empty($categories)) {
                $query->where(function($q) use ($categories) {
                    foreach ($categories as $cat) {
                        $q->orWhere('kategori', 'like', '%' . $cat . '%');
                    }
                });
            }
        }

        if ($request->has('filter') && !empty($request->filter)) {
            if ($request->filter == 'bulan_ini') {
                $query->where('created_at', '>=', now()->subMonth());
            } elseif ($request->filter == 'bestseller') {
                $query->where('terdonasi', '>', 0)->orderBy('terdonasi', 'desc');
            } elseif ($request->filter == 'prioritas') {
                $query->where('badge', 'Prioritas');
            }
        }

        if ($request->has('penerbit')) {
            $penerbits = is_array($request->penerbit) ? $request->penerbit : [$request->penerbit];
            $penerbits = array_filter($penerbits);
            if (!empty($penerbits)) {
                $query->whereIn('penerbit', $penerbits);
            }
        }

        if ($request->has('pengarang')) {
            $pengarangs = is_array($request->pengarang) ? $request->pengarang : [$request->pengarang];
            $pengarangs = array_filter($pengarangs);
            if (!empty($pengarangs)) {
                $query->whereIn('pengarang', $pengarangs);
            }
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
            } else {
                $query->where('badge', $request->sort)->latest();
            }
        } else {
            $query->latest();
        }

        $buku = $query->paginate(12);
        $labels = \App\Models\Label::all();
        
        return view('kategori', compact('buku', 'labels'));
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

        return view('buku', compact('buku', 'buku_terkait'));
    }
}
