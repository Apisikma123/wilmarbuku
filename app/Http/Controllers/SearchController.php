<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KatalogBuku;
use App\Models\Kategori;
use App\Models\Penerbit;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        if (empty($q)) {
            return response()->json([
                'books' => [],
                'categories' => [],
                'publishers' => []
            ]);
        }

        $books = KatalogBuku::where('judul_buku', 'LIKE', '%' . $q . '%')
            ->orWhere('pengarang', 'LIKE', '%' . $q . '%')
            ->orWhere('deskripsi', 'LIKE', '%' . $q . '%')
            ->orderByRaw("CASE WHEN judul_buku = ? THEN 1 WHEN judul_buku LIKE ? THEN 2 ELSE 3 END", [$q, $q . '%'])
            ->limit(5)
            ->get();

        $categories = Kategori::where('nama_kategori', 'LIKE', '%' . $q . '%')
            ->orderByRaw("CASE WHEN nama_kategori = ? THEN 1 WHEN nama_kategori LIKE ? THEN 2 ELSE 3 END", [$q, $q . '%'])
            ->limit(5)
            ->get();

        $publishers = Penerbit::where('nama_penerbit', 'LIKE', '%' . $q . '%')
            ->orderByRaw("CASE WHEN nama_penerbit = ? THEN 1 WHEN nama_penerbit LIKE ? THEN 2 ELSE 3 END", [$q, $q . '%'])
            ->limit(5)
            ->get();

        return response()->json([
            'books' => $books,
            'categories' => $categories,
            'publishers' => $publishers
        ]);
    }
}
