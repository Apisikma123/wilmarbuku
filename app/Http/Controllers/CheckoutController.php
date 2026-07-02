<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['harga_estimasi'] * $details['qty'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart');
        }

        $request->validate([
            'tipe_donatur' => 'required',
            'identitas_kampus' => 'required_if:tipe_donatur,internal',
            'nama_lengkap' => 'required',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        
        // Update user data if internal
        if ($request->tipe_donatur == 'internal') {
            $user->role = 'user_internal';
            $user->identitas_kampus = $request->identitas_kampus;
        }
        $user->nama_lengkap = $request->nama_lengkap;
        $user->save();

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['harga_estimasi'] * $details['qty'];
        }

        $kode_tracking = 'WLH-' . date('Ym') . '-' . strtoupper(Str::random(5));

        $transaksi = TransaksiCheckout::create([
            'kode_tracking' => $kode_tracking,
            'user_id' => $user->id,
            'total_harga' => $total,
            'status_pembayaran' => 'Unpaid',
            'status_tracking' => 'Menunggu Pembayaran',
        ]);

        foreach ($cart as $id => $details) {
            TransaksiDetail::create([
                'kode_tracking' => $kode_tracking,
                'buku_id' => $id,
                'qty' => $details['qty'],
                'harga_satuan' => $details['harga_estimasi'],
                'pesan_dukungan' => $details['pesan_dukungan'] ?? null,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('success')->with('kode_tracking', $kode_tracking);
    }

    public function success(\Illuminate\Http\Request $request)
    {
        $kode_tracking = $request->input('kode') ?? session('kode_tracking');
        
        if (!$kode_tracking) {
            $transaksi = TransaksiCheckout::where('user_id', auth()->id())->latest()->first();
        } else {
            $transaksi = TransaksiCheckout::where('kode_tracking', $kode_tracking)->where('user_id', auth()->id())->first();
        }

        if (!$transaksi) {
            return redirect()->route('dashboard');
        }

        // Simulate successful payment if it's unpaid
        if ($transaksi->status_pembayaran == 'Unpaid') {
            $transaksi->update([
                'status_pembayaran' => 'Paid',
                'status_tracking' => 'Dana Diterima',
                'is_read_by_user' => false // Trigger notification
            ]);

            \App\Models\PesanMasuk::create([
                'user_id' => $transaksi->user_id,
                'judul' => 'Pembayaran Berhasil',
                'isi_pesan' => "Pembayaran untuk {$transaksi->kode_tracking} telah diterima. Menunggu verifikasi Admin.",
                'jenis' => 'pembayaran',
                'is_read' => false,
            ]);
        }

        $detail = TransaksiDetail::with('buku')->where('kode_tracking', $transaksi->kode_tracking)->first();

        return view('success', compact('transaksi', 'detail'));
    }
}
