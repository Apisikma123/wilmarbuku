<?php

namespace App\Http\Controllers;

use App\Models\KatalogBuku;
use App\Models\PesanMasuk;
use App\Models\TransaksiCheckout;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDonations = TransaksiCheckout::where('status_pembayaran', 'Paid')->sum('total_harga');
        $booksNeeded = KatalogBuku::where('status_buku', 'Dibutuhkan')->sum('stok_dibutuhkan');
        $booksInProcess = TransaksiCheckout::whereNotIn('status_tracking', ['Selesai', 'Dibatalkan'])->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();

        $recentTransactions = TransaksiCheckout::with(['user', 'details.buku'])
            ->latest('tanggal_checkout')
            ->take(5)
            ->get();

        $months = [];
        for ($i = 7; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $months[$month->format('Y-m')] = [
                'name' => $month->format('M'),
                'funds' => 0,
                'books' => 0,
            ];
        }

        $transactions = TransaksiCheckout::with('details')
            ->where('status_pembayaran', 'Paid')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(7)->startOfMonth())
            ->get();

        foreach ($transactions as $trx) {
            $key = $trx->created_at->format('Y-m');
            if (isset($months[$key])) {
                $months[$key]['funds'] += $trx->total_harga;
                $months[$key]['books'] += $trx->details->sum('qty');
            }
        }

        $maxFunds = max(array_column($months, 'funds'));
        $maxBooks = max(array_column($months, 'books'));
        $maxFunds = $maxFunds > 0 ? $maxFunds : 1;
        $maxBooks = $maxBooks > 0 ? $maxBooks : 1;
        $chartData = array_values($months);

        return view('admins.dashboard', compact(
            'totalDonations',
            'booksNeeded',
            'booksInProcess',
            'totalUsers',
            'recentTransactions',
            'chartData',
            'maxFunds',
            'maxBooks'
        ));
    }

    public function catalog()
    {
        $books = KatalogBuku::latest()->get();
        $totalPengajuan = KatalogBuku::count();
        $dibutuhkanSegera = KatalogBuku::where('status_buku', 'Dibutuhkan')->count();
        $berhasilTersedia = KatalogBuku::where('status_buku', 'Tersedia')->count();
        $categories = Kategori::orderBy('nama_kategori')->get();
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();

        return view('admins.catalog', compact('books', 'totalPengajuan', 'dibutuhkanSegera', 'berhasilTersedia', 'categories', 'penerbits'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori'
        ]);

        $kategori = Kategori::create(['nama_kategori' => trim($request->nama_kategori)]);

        return response()->json([
            'success' => true,
            'kategori' => $kategori
        ]);
    }

    public function storePenerbit(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbits,nama_penerbit'
        ]);

        $penerbit = Penerbit::create(['nama_penerbit' => trim($request->nama_penerbit)]);

        return response()->json([
            'success' => true,
            'penerbit' => $penerbit
        ]);
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'kategori' => 'nullable|array',
            'kategori.*' => 'string',
            'kategori_baru' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'jumlah_halaman' => 'nullable|string',
            'badge' => 'nullable|string',
            'stok_dibutuhkan' => 'required|integer',
            'harga_estimasi' => 'required|numeric',
            'status_buku' => 'required|string',
            'cover_image' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                
                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%
                $image->scale(width: 800);
                $filename = time() . '_' . uniqid() . '.webp';
                $path = 'covers/' . $filename;
                
                Storage::disk('public')->makeDirectory('covers');
                $image->toWebp(75)->save(storage_path('app/public/' . $path));
                
                $validated['cover_image'] = '/storage/' . $path;
            } catch (\Exception $e) {
                // Fallback jika ekstensi GD tidak aktif
                $path = $file->store('covers', 'public');
                $validated['cover_image'] = '/storage/' . $path;
            }
        }

        unset($validated['cover_file']);
        unset($validated['kategori_baru']);
        
        $categories = $request->kategori ?? [];
        $categories = array_unique(array_filter($categories));
        
        if (empty($categories)) {
            if ($request->ajax()) {
                return response()->json(['errors' => ['kategori' => ['Kategori buku wajib diisi atau dipilih minimal satu.']]], 422);
            }
            return back()->withErrors(['kategori' => 'Kategori buku wajib diisi atau dipilih minimal satu.'])->withInput();
        }
        
        $validated['kategori'] = implode(', ', $categories);

        KatalogBuku::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan ke katalog!'
            ]);
        }

        return back()->with('success', 'Buku berhasil ditambahkan ke katalog!');
    }

    public function updateBook(Request $request, $id)
    {
        $book = KatalogBuku::findOrFail($id);
        
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'kategori' => 'nullable|array',
            'kategori.*' => 'string',
            'kategori_baru' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'jumlah_halaman' => 'nullable|string',
            'badge' => 'nullable|string',
            'stok_dibutuhkan' => 'required|integer',
            'harga_estimasi' => 'required|numeric',
            'status_buku' => 'required|string',
            'cover_image' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                
                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%
                $image->scale(width: 800);
                $filename = time() . '_' . uniqid() . '.webp';
                $path = 'covers/' . $filename;
                
                Storage::disk('public')->makeDirectory('covers');
                $image->toWebp(75)->save(storage_path('app/public/' . $path));
                
                $validated['cover_image'] = '/storage/' . $path;
            } catch (\Exception $e) {
                // Fallback jika ekstensi GD tidak aktif
                $path = $file->store('covers', 'public');
                $validated['cover_image'] = '/storage/' . $path;
            }
        } elseif (empty($validated['cover_image'])) {
            // User did not upload a new file AND did not provide a new URL.
            // Preserve the existing image by removing 'cover_image' from the update array.
            unset($validated['cover_image']);
        }

        unset($validated['cover_file']);
        unset($validated['kategori_baru']);

        $categories = $request->kategori ?? [];
        $categories = array_unique(array_filter($categories));
        
        if (empty($categories)) {
            if ($request->ajax()) {
                return response()->json(['errors' => ['kategori' => ['Kategori buku wajib diisi atau dipilih minimal satu.']]], 422);
            }
            return back()->withErrors(['kategori' => 'Kategori buku wajib diisi atau dipilih minimal satu.'])->withInput();
        }
        
        $validated['kategori'] = implode(', ', $categories);

        $book->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil diperbarui!'
            ]);
        }

        return back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroyBook($id)
    {
        $book = KatalogBuku::findOrFail($id);
        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }

    public function transactions()
    {
        $transactions = TransaksiCheckout::with(['user', 'details.buku'])
            ->latest('tanggal_checkout')
            ->get();

        $totalDonations = TransaksiCheckout::where('status_pembayaran', 'Paid')->sum('total_harga');
        $pendingPayments = TransaksiCheckout::where('status_pembayaran', 'Unpaid')->count();
        $inProcess = TransaksiCheckout::where('status_tracking', 'Dalam Pengiriman')->orWhere('status_tracking', 'Dana Diterima')->count();
        $completed = TransaksiCheckout::where('status_tracking', 'Selesai')->count();

        return view('admins.transactions', compact('transactions', 'totalDonations', 'pendingPayments', 'inProcess', 'completed'));
    }

    public function confirmTransaction(Request $request, $kode_tracking)
    {
        $transaction = TransaksiCheckout::findOrFail($kode_tracking);

        $request->validate([
            'pesan_admin' => 'nullable|string',
        ]);

        $transaction->update([
            'status_tracking' => 'Dalam Pengiriman',
            'status_pembayaran' => 'Paid',
            'is_read_by_user' => false,
        ]);

        $pesanContent = $request->pesan_admin 
            ? $request->pesan_admin 
            : "<b>Donasi anda dikonfirmasi, nomor pesanan/resi anda: {$transaction->kode_tracking}</b><br><br>Terima kasih atas donasi Anda. Pesanan Anda saat ini sedang dalam proses pengadaan/pengiriman oleh Admin.<br><br><a href='/track?kode={$transaction->kode_tracking}' class='inline-flex items-center gap-2 bg-[#004225] hover:bg-[#004225]/90 text-white font-semibold py-2 px-4 rounded-lg text-sm mt-2'><span class='material-symbols-outlined text-[18px]'>location_on</span>Lacak Sekarang</a>";

        PesanMasuk::create([
            'user_id' => $transaction->user_id,
            'judul' => 'Pesanan #' . $transaction->kode_tracking . ' Dikonfirmasi',
            'isi_pesan' => $pesanContent,
            'jenis' => 'info',
            'is_read' => false,
        ]);

        return back()->with('success', 'Transaksi berhasil dikonfirmasi dan pesan dikirim ke pengguna!');
    }

    public function cancelTransaction(Request $request, $kode_tracking)
    {
        $transaction = TransaksiCheckout::findOrFail($kode_tracking);

        $request->validate([
            'alasan_pembatalan' => 'required|string|max:500',
        ]);

        // Kembalikan stok karena dibatalkan
        if ($transaction->status_tracking !== 'Dibatalkan') {
            $transaction->load('details.buku');
            foreach ($transaction->details as $detail) {
                if ($detail->buku) {
                    $newStok = $detail->buku->stok_dibutuhkan + $detail->qty;
                    $updateDataBuku = ['stok_dibutuhkan' => $newStok];
                    if ($newStok > 0 && $detail->buku->status_buku === 'Tersedia') {
                        $updateDataBuku['status_buku'] = 'Dibutuhkan';
                    }
                    $detail->buku->update($updateDataBuku);
                }
            }
        }

        $transaction->update([
            'status_tracking' => 'Dibatalkan',
            'alasan_pembatalan' => $request->alasan_pembatalan,
            'is_read_by_user' => false,
        ]);

        PesanMasuk::create([
            'user_id' => $transaction->user_id,
            'judul' => 'Pesanan #' . $transaction->kode_tracking . ' Dibatalkan',
            'isi_pesan' => "Mohon maaf, pesanan Anda #{$transaction->kode_tracking} telah dibatalkan oleh Admin.\n\nAlasan Pembatalan: {$request->alasan_pembatalan}",
            'jenis' => 'peringatan',
            'is_read' => false,
        ]);

        return back()->with('success', 'Transaksi berhasil dibatalkan dan pemberitahuan dikirim ke pengguna.');
    }

    public function updateTransactionStatus(Request $request, $kode_tracking)
    {
        $transaction = TransaksiCheckout::findOrFail($kode_tracking);
        
        if ($transaction->status_tracking === 'Selesai') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat diubah lagi!');
        }
        
        $request->validate([
            'status_tracking' => 'required|string',
            'pesan_admin' => 'nullable|string',
        ]);

        $updateData = [
            'status_tracking' => $request->status_tracking,
            'is_read_by_user' => false,
        ];

        if (in_array($request->status_tracking, ['Dana Diterima', 'Dalam Pengiriman', 'Selesai'])) {
            $updateData['status_pembayaran'] = 'Paid';
        } elseif ($request->status_tracking == 'Dibatalkan') {
            $updateData['status_pembayaran'] = 'Failed';
        }

        // Cek jika status diubah menjadi Dibatalkan dari status lain, maka stok dikembalikan
        if ($request->status_tracking === 'Dibatalkan' && $transaction->status_tracking !== 'Dibatalkan') {
            $transaction->load('details.buku');
            foreach ($transaction->details as $detail) {
                if ($detail->buku) {
                    $newStok = $detail->buku->stok_dibutuhkan + $detail->qty;
                    $updateDataBuku = ['stok_dibutuhkan' => $newStok];
                    if ($newStok > 0 && $detail->buku->status_buku === 'Tersedia') {
                        $updateDataBuku['status_buku'] = 'Dibutuhkan';
                    }
                    $detail->buku->update($updateDataBuku);
                }
            }
        }

        // Cek jika status dibatalkan (dihidupkan kembali)
        if ($request->status_tracking !== 'Dibatalkan' && $transaction->status_tracking === 'Dibatalkan') {
            $transaction->load('details.buku');
            foreach ($transaction->details as $detail) {
                if ($detail->buku) {
                    $newStok = max(0, $detail->buku->stok_dibutuhkan - $detail->qty);
                    $updateDataBuku = ['stok_dibutuhkan' => $newStok];
                    if ($newStok == 0) {
                        $updateDataBuku['status_buku'] = 'Tersedia';
                    }
                    $detail->buku->update($updateDataBuku);
                }
            }
        }

        $transaction->update($updateData);
        $pesanText = "Status pesanan buku Anda #{$transaction->kode_tracking} saat ini: **{$request->status_tracking}**.";
        
        if ($request->pesan_admin) {
            $pesanText .= "\n\nPesan dari Admin:\n" . $request->pesan_admin;
        }

        // Kirim pesan ke inbox pengguna secara otomatis
        PesanMasuk::create([
            'user_id' => $transaction->user_id,
            'judul' => "Pesanan #{$transaction->kode_tracking} - {$request->status_tracking}",
            'isi_pesan' => $pesanText,
            'jenis' => $request->status_tracking == 'Dibatalkan' ? 'peringatan' : 'info',
            'is_read' => false,
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui dan pesan dikirim ke pengguna!');
    }

    public function users()
    {
        $users = User::latest()->get();
        $totalUsers = User::count();
        $internalUsers = User::where('role', 'user_internal')->count();
        $externalUsers = User::where('role', 'user_external')->count();

        return view('admins.users', compact('users', 'totalUsers', 'internalUsers', 'externalUsers'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,user_internal,user_external',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Peran pengguna berhasil diperbarui!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'identitas_kampus' => 'nullable|string|max:255',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'identitas_kampus' => $request->identitas_kampus,
        ]);

        return back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

    public function reports(Request $request)
    {
        $filter = $request->input('filter', '12_months');

        $query = TransaksiCheckout::query();
        
        $chartDataRaw = [];
        $startDate = null;

        if ($filter == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $diff = $startDate->diffInMonths(Carbon::now());
            for ($i = $diff; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $chartDataRaw[$month->format('Y-m')] = [
                    'name' => $month->format('M'),
                    'funds' => 0,
                    'books' => 0,
                ];
            }
        } elseif ($filter == '30_days') {
            $startDate = Carbon::now()->subDays(29)->startOfDay();
            for ($i = 29; $i >= 0; $i--) {
                $day = Carbon::now()->subDays($i);
                $chartDataRaw[$day->format('Y-m-d')] = [
                    'name' => $day->format('d M'),
                    'funds' => 0,
                    'books' => 0,
                ];
            }
        } else { // 12_months
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $chartDataRaw[$month->format('Y-m')] = [
                    'name' => $month->format('M'),
                    'funds' => 0,
                    'books' => 0,
                ];
            }
        }

        // Apply date filter to top metrics
        $metricsQuery = TransaksiCheckout::where('created_at', '>=', $startDate);
        
        $totalDonations = (clone $metricsQuery)->where('status_pembayaran', 'Paid')->sum('total_harga');
        $totalTransactions = (clone $metricsQuery)->count();
        $completedTransactions = (clone $metricsQuery)->where('status_tracking', 'Selesai')->count();
        
        $recentTransactions = TransaksiCheckout::with(['user', 'details.buku'])->latest()->take(10)->get();

        $transactions = TransaksiCheckout::with('details')
            ->where('status_pembayaran', 'Paid')
            ->where('created_at', '>=', $startDate)
            ->get();

        foreach ($transactions as $trx) {
            $key = $filter == '30_days' ? $trx->created_at->format('Y-m-d') : $trx->created_at->format('Y-m');
            if (isset($chartDataRaw[$key])) {
                $chartDataRaw[$key]['funds'] += $trx->total_harga;
                $chartDataRaw[$key]['books'] += $trx->details->sum('qty');
            }
        }

        $maxFunds = max(array_column($chartDataRaw, 'funds') ?: [0]);
        $maxBooks = max(array_column($chartDataRaw, 'books') ?: [0]);
        
        $maxFunds = $maxFunds > 0 ? $maxFunds : 1;
        $maxBooks = $maxBooks > 0 ? $maxBooks : 1;

        $chartData = array_values($chartDataRaw);

        return view('admins.reports', compact('totalDonations', 'totalTransactions', 'completedTransactions', 'recentTransactions', 'chartData', 'maxFunds', 'maxBooks', 'filter'));
    }

    public function exportPdf()
    {
        $totalDonations = TransaksiCheckout::where('status_pembayaran', 'Paid')->sum('total_harga');
        $totalTransactions = TransaksiCheckout::count();
        $completedTransactions = TransaksiCheckout::where('status_tracking', 'Selesai')->count();
        $recentTransactions = TransaksiCheckout::with(['user', 'details.buku'])->latest()->take(100)->get();

        $pdf = Pdf::loadView('admins.pdf_reports', compact('totalDonations', 'totalTransactions', 'completedTransactions', 'recentTransactions'));
        return $pdf->download('wilmarbuku-reports.pdf');
    }

    public function exportDashboardPdf()
    {
        $totalDonations = TransaksiCheckout::where('status_pembayaran', 'Paid')->sum('total_harga');
        $booksNeeded = KatalogBuku::where('status_buku', 'Dibutuhkan')->sum('stok_dibutuhkan');
        $booksInProcess = TransaksiCheckout::where('status_tracking', '!=', 'Selesai')->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();

        $recentTransactions = TransaksiCheckout::with(['user', 'details.buku'])
            ->latest('tanggal_checkout')
            ->take(50)
            ->get();

        $pdf = Pdf::loadView('admins.pdf_dashboard', compact(
            'totalDonations',
            'booksNeeded',
            'booksInProcess',
            'totalUsers',
            'recentTransactions'
        ));
        
        return $pdf->download('wilmarbuku-dashboard.pdf');
    }

    public function dibutuhkan()
    {
        $books = KatalogBuku::where('status_buku', 'Dibutuhkan')->latest()->get();
        return view('admins.dibutuhkan', compact('books'));
    }

    public function support()
    {
        return view('admins.support');
    }

    public function settings()
    {
        return view('admins.settings');
    }
}
