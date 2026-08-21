<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Bersihkan semua tabel transaksi, master data, pesan, notifikasi, job, sesi, cache, dan user
        DB::table('transaksi_detail')->truncate();
        DB::table('transaksi_checkout')->truncate();
        DB::table('pesan_masuk')->truncate();
        DB::table('notifications')->truncate();
        DB::table('katalog_buku')->truncate();
        DB::table('kategoris')->truncate();
        DB::table('penerbits')->truncate();
        DB::table('metode_pembayarans')->truncate();
        DB::table('labels')->truncate();
        DB::table('settings')->truncate();
        DB::table('sessions')->truncate();
        DB::table('cache')->truncate();
        DB::table('cache_locks')->truncate();
        DB::table('jobs')->truncate();
        DB::table('job_batches')->truncate();
        DB::table('failed_jobs')->truncate();
        DB::table('password_reset_tokens')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        // Buat 1 Akun Admin (ID: 1) untuk Testing
        User::create([
            'nama_lengkap' => 'Admin Testing',
            'email' => 'admin@wilmarbuku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_onboarding_completed' => 1,
            'email_verified_at' => now(),
        ]);
    }
}


