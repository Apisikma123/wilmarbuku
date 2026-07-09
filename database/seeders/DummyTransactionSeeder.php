<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TransaksiCheckout;
use App\Models\TransaksiDetail;
use App\Models\KatalogBuku;
use App\Models\MetodePembayaran;
use Illuminate\Support\Str;

class DummyTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all available books to attach to transactions
        $bukuIds = KatalogBuku::pluck('id')->toArray();
        if(empty($bukuIds)) {
            $this->command->error("Tolong buat data buku terlebih dahulu!");
            return;
        }

        $metodeId = MetodePembayaran::first()->id ?? 1;

        $this->command->info('Membuat 100 User baru...');
        // We make exactly 100 users
        $users = User::factory()->count(100)->create();

        $this->command->info('Membuat 100 Transaksi acak...');
        $statuses = ['Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
        
        $transactionCount = 0;

        foreach($users as $user) {
            // Randomly create 1 to 2 transactions per user
            $numTransactions = rand(1, 2);
            for ($i = 0; $i < $numTransactions; $i++) {
                if ($transactionCount >= 100) {
                    break 2; // stop if we reach 100 transactions
                }

                $statusTracking = $statuses[array_rand($statuses)];
                $statusPembayaran = in_array($statusTracking, ['Menunggu Pembayaran', 'Dibatalkan']) ? 'Unpaid' : 'Paid';

                $transaksi = TransaksiCheckout::create([
                    'kode_tracking' => 'WB' . date('Ym') . strtoupper(Str::random(5)),
                    'user_id' => $user->id,
                    'total_harga' => 0, // Will calculate below
                    'status_pembayaran' => $statusPembayaran,
                    'status_tracking' => $statusTracking,
                    'metode_pembayaran_id' => $metodeId,
                    'tanggal_checkout' => now()->subDays(rand(1, 30)),
                    'validasi_lulus' => rand(0, 1),
                    'is_read_by_user' => rand(0, 1),
                ]);

                // Create random details
                $numDetails = rand(1, 3);
                $totalHarga = 0;
                $usedBooks = [];
                
                for ($j = 0; $j < $numDetails; $j++) {
                    $bukuId = $bukuIds[array_rand($bukuIds)];
                    if(in_array($bukuId, $usedBooks)) continue; // Avoid duplicate book in same transaction
                    $usedBooks[] = $bukuId;

                    $buku = KatalogBuku::find($bukuId);
                    if(!$buku) continue;

                    $qty = rand(1, 3);
                    $hargaSatuan = $buku->harga_estimasi ?? rand(50000, 150000);
                    $subtotal = $qty * $hargaSatuan;
                    
                    TransaksiDetail::create([
                        'kode_tracking' => $transaksi->kode_tracking,
                        'buku_id' => $bukuId,
                        'qty' => $qty,
                        'harga_satuan' => $hargaSatuan,
                        'pesan_dukungan' => rand(0, 1) ? 'Semoga bermanfaat!' : null,
                    ]);

                    $totalHarga += $subtotal;
                }

                $transaksi->update(['total_harga' => $totalHarga]);
                $transactionCount++;
            }
        }
        
        $this->command->info('100 User dan ' . $transactionCount . ' Transaksinya berhasil dibuat!');
    }
}
