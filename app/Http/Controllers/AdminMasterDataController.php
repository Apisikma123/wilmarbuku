<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Label;

class AdminMasterDataController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        $labels = Label::all();
        
        return view('admins.master_data', compact('kategoris', 'penerbits', 'labels'));
    }

    // KATEGORI
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);
        Kategori::create(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    // PENERBIT
    public function storePenerbit(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required|string|max:255'
        ]);
        Penerbit::create(['nama_penerbit' => $request->nama_penerbit]);
        return redirect()->back()->with('success', 'Penerbit berhasil ditambahkan!');
    }

    public function updatePenerbit(Request $request, $id)
    {
        $request->validate([
            'nama_penerbit' => 'required|string|max:255'
        ]);
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->update(['nama_penerbit' => $request->nama_penerbit]);
        return redirect()->back()->with('success', 'Penerbit berhasil diperbarui!');
    }

    public function destroyPenerbit($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->delete();
        return redirect()->back()->with('success', 'Penerbit berhasil dihapus!');
    }

    // LABEL (BADGE)
    public function storeLabel(Request $request)
    {
        $request->validate([
            'nama_label' => 'required|string|max:255'
        ]);
        Label::create(['nama_label' => $request->nama_label]);
        return redirect()->back()->with('success', 'Label berhasil ditambahkan!');
    }

    public function updateLabel(Request $request, $id)
    {
        $request->validate([
            'nama_label' => 'required|string|max:255'
        ]);
        $label = Label::findOrFail($id);
        $label->update(['nama_label' => $request->nama_label]);
        return redirect()->back()->with('success', 'Label berhasil diperbarui!');
    }

    public function destroyLabel($id)
    {
        $label = Label::findOrFail($id);
        $label->delete();
        return redirect()->back()->with('success', 'Label berhasil dihapus!');
    }
}
