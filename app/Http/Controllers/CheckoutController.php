<?php

namespace App\Http\Controllers;

use App\Models\KatalogBuku;
use App\Models\MetodePembayaran;
use App\Models\PesanMasuk;
use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $cart = $type === 'buy_now' ? session()->get('buy_now_cart', []) : (Auth::user()->cart_data ?? []);

        // Filter out items that have no stock
        $filteredCart = [];
        foreach ($cart as $id => $details) {
            $buku = KatalogBuku::find($id);
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
            'nama_lengkap' => 'required|string|max:50',
            'email' => 'required|email',
        ]);

        $user = Auth::user();

        // Update user data if internal
        if ($request->tipe_donatur == 'internal' && empty($user->identitas_kampus)) {
            $user->identitas_kampus = $request->identitas_kampus;
            $user->save();
        }

        try {
            DB::beginTransaction();

            // Filter keranjang: abaikan buku yang stoknya sudah habis (disabled)
            $checkoutCart = [];
            foreach ($cart as $id => $details) {
                // Lock row untuk mencegah race condition (User lain tidak bisa checkout buku ini di milidetik yang sama)
                $buku = KatalogBuku::where('id', $id)->lockForUpdate()->first();
                if ($buku && $buku->stok_dibutuhkan > 0) {
                    // Validasi Race Condition: jika stok sisa lebih kecil dari qty yang diminta
                    if ($buku->stok_dibutuhkan < $details['qty']) {
                        throw new \Exception("STOK_HABIS:{$buku->judul_buku}");
                    }
                    $checkoutCart[$id] = $details;
                }
            }

            if (empty($checkoutCart)) {
                throw new \Exception("EMPTY_CART");
            }

            $total = 0;
            foreach ($checkoutCart as $details) {
                $total += $details['harga_estimasi'] * $details['qty'];
            }

            $kode_tracking = 'WB' . date('Ym') . strtoupper(Str::random(5));

            $transaksi = TransaksiCheckout::create([
                'kode_tracking' => $kode_tracking,
                'user_id' => $user->id,
                'total_harga' => $total,
                'status_pembayaran' => 'Unpaid',
                'status_tracking' => 'Menunggu Pembayaran',
            ]);

            foreach ($checkoutCart as $id => $details) {
                TransaksiDetail::create([
                    'kode_tracking' => $kode_tracking,
                    'buku_id' => $id,
                    'qty' => $details['qty'],
                    'harga_satuan' => $details['harga_estimasi'],
                    'pesan_dukungan' => $details['pesan_dukungan'] ?? null,
                ]);

                // Soft Booking: Kurangi stok saat checkout
                $buku = KatalogBuku::find($id);
                if ($buku) {
                    $newStok = max(0, $buku->stok_dibutuhkan - $details['qty']);
                    $updateData = ['stok_dibutuhkan' => $newStok];
                    if ($newStok == 0) {
                        $updateData['status_buku'] = 'Tersedia';
                        
                        $admins = \App\Models\User::where('role', 'admin')->get();
                        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\AdminNotification(
                            "Stok buku <b>{$buku->judul_buku}</b> telah terpenuhi (0).",
                            'info',
                            "/admin/catalog?search=" . urlencode($buku->judul_buku)
                        ));
                    }
                    $buku->update($updateData);
                }
            }

            DB::commit();

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

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (strpos($e->getMessage(), 'STOK_HABIS:') === 0) {
                $judul = explode(':', $e->getMessage())[1];
                $pesan = "Yah! Keduluan. 🏃‍♂️ Stok buku '$judul' baru saja berkurang atau habis didonasikan oleh pengguna lain. Silakan periksa kembali keranjang Anda.";
                return redirect()->route('cart')->with('error', $pesan);
            }
            
            if ($e->getMessage() === 'EMPTY_CART') {
                return redirect()->route('cart')->with('error', 'Tidak ada buku yang valid untuk diproses.');
            }
            
            throw $e;
        }

        return redirect()->route('payment')->with('token', encrypt($transaksi->id));
    }

    public function payment(Request $request)
    {
        $token = session('token') ?? $request->input('token');
        
        $transaksi = null;
        if ($token) {
            try {
                $id = decrypt($token);
                $transaksi = \App\Models\TransaksiCheckout::where('id', $id)->where('user_id', auth()->id())->first();
            } catch (\Exception $e) {
                $transaksi = null;
            }
        }
        
        if (!$transaksi) {
            $transaksi = \App\Models\TransaksiCheckout::where('user_id', auth()->id())->where('status_pembayaran', 'Unpaid')->latest()->first();
        }

        if (! $transaksi) {
            return redirect()->route('dashboard');
        }

        if ($transaksi->status_tracking == 'Dibatalkan' || $transaksi->status_pembayaran == 'Expired') {
            return redirect()->route('dashboard')->with('error', 'Transaksi ini telah dibatalkan atau kedaluwarsa.');
        }

        // Check expiration here to prevent infinite loop on auto-reload
        if (\Carbon\Carbon::parse($transaksi->created_at)->addHour()->isPast()) {
            if ($transaksi->status_pembayaran == 'Unpaid') {
                $transaksi->update(['status_tracking' => 'Dibatalkan']);
                
                // Return stock
                foreach ($transaksi->details as $detail) {
                    if ($detail->buku) {
                        $detail->buku->increment('stok_dibutuhkan', $detail->qty);
                    }
                }
                
                return redirect()->route('dashboard')->with('error', 'Waktu pembayaran untuk donasi ini telah habis.');
            }
        }

        if ($transaksi->bukti_pembayaran) {
            return redirect()->route('success')->with('kode_tracking', $transaksi->kode_tracking);
        }

        $metodes = MetodePembayaran::where('is_active', true)->get();

        return view('payment', compact('transaksi', 'metodes'));
    }

    public function uploadProof(Request $request)
    {
        $kode_tracking = $request->input('kode_tracking');
        $transaksi = TransaksiCheckout::where('kode_tracking', $kode_tracking)->where('user_id', auth()->id())->firstOrFail();

        if (\Carbon\Carbon::parse($transaksi->created_at)->addHour()->isPast()) {
            if ($transaksi->status_pembayaran == 'Unpaid') {
                $transaksi->update(['status_tracking' => 'Dibatalkan']);
                
                // Return stock
                foreach ($transaksi->details as $detail) {
                    if ($detail->buku) {
                        $detail->buku->increment('stok_dibutuhkan', $detail->qty);
                    }
                }
                
                return redirect()->route('dashboard')->with('error', 'Waktu pembayaran untuk donasi ini telah habis. Transaksi dibatalkan.');
            }
            return redirect()->route('dashboard')->with('error', 'Transaksi sudah tidak valid.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->decode($file->getRealPath());

                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%
                $image->scale(width: 800);
                $filename = time().'_'.uniqid().'.webp';
                $path = 'bukti_pembayaran/'.$filename;

                Storage::disk('public')->makeDirectory('bukti_pembayaran');
                $image->encode(new WebpEncoder(75))->save(storage_path('app/public/'.$path));

                $transaksi->update([
                    'bukti_pembayaran' => '/storage/'.$path,
                    'status_tracking' => 'Menunggu Konfirmasi',
                    'metode_pembayaran_id' => $request->input('metode_pembayaran_id'),
                ]);
            } catch (\Exception $e) {
                // Fallback jika ekstensi GD tidak aktif (termasuk MissingDependencyException)
                $path = $file->store('bukti_pembayaran', 'public');
                $transaksi->update([
                    'bukti_pembayaran' => '/storage/'.$path,
                    'status_tracking' => 'Menunggu Konfirmasi',
                    'metode_pembayaran_id' => $request->input('metode_pembayaran_id'),
                ]);
            }

            PesanMasuk::create([
                'user_id' => $transaksi->user_id,
                'judul' => 'Bukti Pembayaran Terkirim',
                'isi_pesan' => 'Bukti Pembayaran anda terkirim, mohon tunggu konfirmasi admin.<br><br>Detail Transaksi:<br>Total Tagihan: Rp '.number_format($transaksi->total_harga, 0, ',', '.').'<br>Status: Menunggu Konfirmasi',
                'jenis' => 'info',
                'is_read' => false,
            ]);

            // Notify all admins via Real-time WebSockets
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\AdminNotification(
                "Donatur telah mengunggah bukti pembayaran untuk pesanan #{$transaksi->kode_tracking}. Butuh konfirmasi Anda.",
                'info',
                "/admin/transactions?search={$transaksi->kode_tracking}"
            ));
        }

        return redirect()->route('success')->with('kode_tracking', $kode_tracking);
    }

    public function success(Request $request)
    {
        $kode_tracking = $request->input('kode') ?? session('kode_tracking');

        if (! $kode_tracking) {
            $transaksi = TransaksiCheckout::where('user_id', auth()->id())->latest()->first();
        } else {
            $transaksi = TransaksiCheckout::where('kode_tracking', $kode_tracking)->where('user_id', auth()->id())->first();
        }

        if (! $transaksi) {
            return redirect()->route('dashboard');
        }

        $detail = TransaksiDetail::with('buku')->where('kode_tracking', $transaksi->kode_tracking)->first();

        return view('success', compact('transaksi', 'detail'));
    }
}
