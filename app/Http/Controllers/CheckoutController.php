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
    public function index(Request $request)
    {
        $type = $request->query('type');
        $cart = $type === 'buy_now' ? session()->get('buy_now_cart', []) : (Auth::user()->cart_data ?? []);
        
        // Filter out items that have no stock
        $filteredCart = [];
        foreach ($cart as $id => $details) {
            $buku = \App\Models\KatalogBuku::find($id);
            if ($buku && $buku->stok_dibutuhkan > 0) {
                $filteredCart[$id] = $details;
                $filteredCart[$id]['qty'] = min($details['qty'], $buku->stok_dibutuhkan);
            }
        }
        $cart = $filteredCart;

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Tidak ada buku yang dapat didonasikan saat ini.');
        }

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['harga_estimasi'] * $details['qty'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $type = $request->input('type');
        $cart = $type === 'buy_now' ? session()->get('buy_now_cart', []) : (Auth::user()->cart_data ?? []);
        
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
            $user->save();
        }

        // Filter keranjang: abaikan buku yang stoknya sudah habis (disabled)
        $checkoutCart = [];
        foreach ($cart as $id => $details) {
            $buku = \App\Models\KatalogBuku::find($id);
            if ($buku && $buku->stok_dibutuhkan > 0) {
                // Validasi Race Condition: jika stok sisa lebih kecil dari qty yang diminta
                if ($buku->stok_dibutuhkan < $details['qty']) {
                    $judul = $buku->judul_buku;
                    $pesan = "Yah! Keduluan. 🏃‍♂️ Stok buku '$judul' baru saja berkurang atau habis didonasikan oleh pengguna lain. Silakan periksa kembali keranjang Anda.";
                    return redirect()->route('cart')->with('error', $pesan);
                }
                $checkoutCart[$id] = $details;
            }
        }

        if (empty($checkoutCart)) {
            return redirect()->route('cart')->with('error', 'Tidak ada buku yang valid untuk diproses.');
        }

        $total = 0;
        foreach ($checkoutCart as $details) {
            $total += $details['harga_estimasi'] * $details['qty'];
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($cart, $user, $kode_tracking) {
            $total = 0;

            // Re-fetch harga dari database untuk mencegah price tampering dari session
            foreach ($cart as $id => $details) {
                $buku = \App\Models\KatalogBuku::where('id', $id)->lockForUpdate()->first();
                if ($buku) {
                    $total += $buku->harga_estimasi * $details['qty'];
                }
            }

        foreach ($checkoutCart as $id => $details) {
            TransaksiDetail::create([
                'kode_tracking' => $kode_tracking,
                'user_id' => $user->id,
                'total_harga' => $total,
                'status_pembayaran' => 'Unpaid',
                'status_tracking' => 'Menunggu Pembayaran',
            ]);

            foreach ($cart as $id => $details) {
                $buku = \App\Models\KatalogBuku::where('id', $id)->lockForUpdate()->first();
                $hargaSatuan = $buku ? $buku->harga_estimasi : $details['harga_estimasi'];

                TransaksiDetail::create([
                    'kode_tracking' => $kode_tracking,
                    'buku_id' => $id,
                    'qty' => $details['qty'],
                    'harga_satuan' => $hargaSatuan,
                    'pesan_dukungan' => $details['pesan_dukungan'] ?? null,
                ]);

                // Soft Booking: Kurangi stok saat checkout (dengan lock untuk mencegah race condition)
                if ($buku) {
                    $newStok = max(0, $buku->stok_dibutuhkan - $details['qty']);
                    $updateData = ['stok_dibutuhkan' => $newStok];
                    if ($newStok == 0) {
                        $updateData['status_buku'] = 'Tersedia';
                    }
                    $buku->update($updateData);
                }
            }
        });

        if ($type === 'buy_now') {
            session()->forget('buy_now_cart');
        } else {
            // Hanya hapus buku yang berhasil di-checkout dari database keranjang
            foreach ($checkoutCart as $id => $details) {
                unset($cart[$id]);
            }
            
            if (empty($cart)) {
                $user->update(['cart_data' => null]);
            } else {
                $user->update(['cart_data' => $cart]);
            }
        }

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
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->decode($file->getRealPath());
                
                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%
                $image->scale(width: 800);
                $filename = time() . '_' . uniqid() . '.webp';
                $path = 'bukti_pembayaran/' . $filename;
                
                Storage::disk('public')->makeDirectory('bukti_pembayaran');
                $image->encode(new \Intervention\Image\Encoders\WebpEncoder(75))->save(storage_path('app/public/' . $path));
                
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

            // Create notification (which also triggers the email)
            \App\Models\PesanMasuk::create([
                'user_id' => $transaksi->user_id,
                'judul' => "Bukti Pembayaran Terkirim",
                'isi_pesan' => "Bukti Pembayaran anda terkirim, mohon tunggu konfirmasi admin.<br><br>Detail Transaksi:<br>Total Tagihan: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "<br>Status: Menunggu Konfirmasi",
                'jenis' => 'info',
                'is_read' => false,
            ]);
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
