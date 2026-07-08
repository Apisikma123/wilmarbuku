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
        } elseif ($filter == 'dana_diterima') {
            $query->where('status_tracking', 'Dana Diterima');
        } elseif ($filter == 'sedang_dikirim') {
            $query->where('status_tracking', 'Dalam Pengiriman');
        } elseif ($filter == 'selesai') {
            $query->where('status_tracking', 'Selesai');
        } elseif ($filter == 'dibatalkan') {
            $query->where(function($q) {
                $q->where('status_tracking', 'Dibatalkan')->orWhere('status_pembayaran', 'Failed');
            });
        }

        $transaksi = $query->latest()->get();
            
        return view('transaksi', compact('transaksi', 'filter'));
    }

    public function track(Request $request)
    {
        $kode = $request->query('kode');
        $transaksi = null;

        if ($kode) {
            $transaksi = TransaksiCheckout::with(['details.buku'])
                ->where('kode_tracking', $kode)
                ->whereHas('transaksi', fn($q) => $q->where('user_id', auth()->id()))
                ->first();
        }

        return view('track', compact('transaksi', 'kode'));
    }
}
