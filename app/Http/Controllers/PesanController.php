<?php

namespace App\Http\Controllers;

use App\Models\PesanMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $pesan = PesanMasuk::where('user_id', Auth::id())
            ->latest()
            ->get();
            
        // Mark as read in DB so badge disappears on page load
        PesanMasuk::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return view('pesan-masuk', compact('pesan'));
    }

    public function markAsRead(Request $request)
    {
        PesanMasuk::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return redirect()->back();
    }
}
