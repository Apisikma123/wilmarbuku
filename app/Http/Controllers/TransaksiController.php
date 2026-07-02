<?php

namespace App\Http\Controllers;

use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mark all unread transactions for this user as read
        TransaksiCheckout::where('user_id', auth()->id())
            ->where('is_read_by_user', false)
            ->update(['is_read_by_user' => true]);

        $transaksi = TransaksiCheckout::with('details.buku')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('transaksi', compact('transaksi'));
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
