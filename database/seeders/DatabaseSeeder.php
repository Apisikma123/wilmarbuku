<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua data user sebelumnya
        User::query()->delete();

        // Buat Admin Dummy
        User::factory()->create([
            'nama_lengkap' => 'Admin Dummy',
            'email' => 'admin@dummy.com',
            'role' => 'admin',
        ]);

        // Buat User Dummy
        User::factory()->create([
            'nama_lengkap' => 'User Dummy',
            'email' => 'user@dummy.com',
            'role' => 'user_internal',
        ]);

        // $this->call([
        //     KatalogBukuSeeder::class,
        // ]);
    }
}
