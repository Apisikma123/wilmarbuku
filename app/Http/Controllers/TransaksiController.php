<?php

namespace App\Http\Controllers;

use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Mark all unread transactions for this user as read
        TransaksiCheckout::where('user_id', auth()->id())
            ->where('is_read_by_user', false)
            ->update(['is_read_by_user' => true]);

        $filter = $request->query('status', 'menunggu_konfirmasi');

        $query = TransaksiCheckout::with('details.buku')
            ->where('user_id', auth()->id());

        if ($filter == 'menunggu_konfirmasi') {
            $query->whereIn('status_tracking', ['Menunggu Pembayaran', 'Menunggu Konfirmasi']);
        } elseif ($filter == 'sedang_dikirim') {
            $query->whereIn('status_tracking', ['Dana Diterima', 'Dalam Pengiriman', 'Dipesan Admin', 'Dikirim ke Perpus']);
        } elseif ($filter == 'selesai') {
            $query->whereIn('status_tracking', ['Masuk Katalog', 'Selesai']);
        } elseif ($filter == 'dibatalkan') {
            $query->whereIn('status_tracking', ['Dibatalkan'])->orWhere('status_pembayaran', 'Failed');
        }

        $transaksi = $query->latest()->get();
            
        return view('transaksi', compact('transaksi', 'filter'));
    }

    public function track(Request $request)
    {
        $kode = $request->query('kode');
        $transaksiDetail = null;

        if ($kode) {
            $transaksiDetail = TransaksiDetail::with(['buku', 'transaksi'])
                ->where('kode_tracking', $kode)
                ->first();
        }

        return view('track', compact('transaksiDetail', 'kode'));
    }
}
