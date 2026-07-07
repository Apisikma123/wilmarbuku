<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        if ($request->tipe_donatur == 'internal' && empty($user->identitas_kampus)) {
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

            // Soft Booking: Kurangi stok saat checkout
            $buku = \App\Models\KatalogBuku::find($id);
            if ($buku) {
                $newStok = max(0, $buku->stok_dibutuhkan - $details['qty']);
                $updateData = ['stok_dibutuhkan' => $newStok];
                if ($newStok == 0) {
                    $updateData['status_buku'] = 'Tersedia';
                }
                $buku->update($updateData);
            }
        }

        session()->forget('cart');

        return redirect()->route('payment')->with('kode_tracking', $kode_tracking);
    }

    public function payment(Request $request)
    {
        $kode_tracking = session('kode_tracking') ?? $request->input('kode');
        
        if (!$kode_tracking) {
            $transaksi = TransaksiCheckout::where('user_id', auth()->id())->where('status_pembayaran', 'Unpaid')->latest()->first();
        } else {
            $transaksi = TransaksiCheckout::where('kode_tracking', $kode_tracking)->where('user_id', auth()->id())->first();
        }

        if (!$transaksi) {
            return redirect()->route('dashboard');
        }
        
        if ($transaksi->bukti_pembayaran) {
            return redirect()->route('success')->with('kode_tracking', $kode_tracking);
        }

        $metodes = \App\Models\MetodePembayaran::where('is_active', true)->get();
        return view('payment', compact('transaksi', 'metodes'));
    }

    public function uploadProof(Request $request)
    {
        $kode_tracking = $request->input('kode_tracking');
        $transaksi = TransaksiCheckout::where('kode_tracking', $kode_tracking)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                
                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%
                $image->scale(width: 800);
                $filename = time() . '_' . uniqid() . '.webp';
                $path = 'bukti_pembayaran/' . $filename;
                
                Storage::disk('public')->makeDirectory('bukti_pembayaran');
                $image->toWebp(75)->save(storage_path('app/public/' . $path));
                
                $transaksi->update([
                    'bukti_pembayaran' => '/storage/' . $path,
                    'status_tracking' => 'Menunggu Konfirmasi'
                ]);
            } catch (\Exception $e) {
                // Fallback jika ekstensi GD tidak aktif (termasuk MissingDependencyException)
                $path = $file->store('bukti_pembayaran', 'public');
                $transaksi->update([
                    'bukti_pembayaran' => '/storage/' . $path,
                    'status_tracking' => 'Menunggu Konfirmasi'
                ]);
            }
        }

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


        $detail = TransaksiDetail::with('buku')->where('kode_tracking', $transaksi->kode_tracking)->first();

        return view('success', compact('transaksi', 'detail'));
    }
}
