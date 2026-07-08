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
        // User::factory(10)->create();

        User::factory()->create([
            'nama_lengkap' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user_internal',
        ]);

        User::factory()->create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@wilmar.com',
            'role' => 'admin',
        ]);

        // $this->call([
        //     KatalogBukuSeeder::class,
        // ]);
    }
}
