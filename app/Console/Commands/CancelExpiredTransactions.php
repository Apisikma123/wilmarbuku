<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use App\Models\KatalogBuku;
use App\Models\PesanMasuk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Models\User;

#[Signature('app:cancel-expired-transactions')]
#[Description('Membatalkan transaksi yang sudah lewat 1 jam dan mengembalikan stok buku')]
class CancelExpiredTransactions extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTransactions = TransaksiCheckout::where('status_tracking', 'Menunggu Pembayaran')
            ->where('created_at', '<', Carbon::now()->subHour())
            ->get();

        if ($expiredTransactions->isEmpty()) {
            $this->info('Tidak ada transaksi kedaluwarsa.');
            return;
        }

        foreach ($expiredTransactions as $transaction) {
            $transaction->update([
                'status_tracking' => 'Dibatalkan',
                'status_pembayaran' => 'Failed',
                'alasan_pembatalan' => 'Batas waktu pembayaran (1 jam) telah habis.',
            ]);

            // Kembalikan stok buku
            $details = TransaksiDetail::where('kode_tracking', $transaction->kode_tracking)->get();
            foreach ($details as $detail) {
                $buku = KatalogBuku::find($detail->buku_id);
                if ($buku) {
                    $buku->stok_dibutuhkan += $detail->qty;
                    if ($buku->stok_dibutuhkan > 0) {
                        $buku->status_buku = 'Dibutuhkan';
                    }
                    $buku->save();
                }
            }

            // Kirim pesan inbox
            $pesan = PesanMasuk::create([
                'user_id' => $transaction->user_id,
                'judul' => 'Pesanan #' . $transaction->kode_tracking . ' Dibatalkan',
                'isi_pesan' => "Mohon maaf, pesanan Anda <b>#{$transaction->kode_tracking}</b> telah dibatalkan secara otomatis.<br><br>Alasan Pembatalan:<br>Batas waktu pembayaran (1 jam) telah habis.",
                'jenis' => 'peringatan',
                'is_read' => false,
            ]);

            // Kirim notifikasi email
            try {
                $user = User::find($transaction->user_id);
                if ($user) {
                    Mail::to($user->email)->send(new NotificationMail($pesan));
                }
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email pembatalan transaksi otomatis: " . $e->getMessage());
            }

            $this->info("Transaksi #{$transaction->kode_tracking} dibatalkan.");
        }
        
        $this->info("Berhasil membatalkan {$expiredTransactions->count()} transaksi.");
    }
}
