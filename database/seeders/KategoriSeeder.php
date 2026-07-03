<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Ekonomi & Bisnis',
            'Pengembangan Diri',
            'Sosial & Budaya',
            'Umum',
            'Fiksi & Sastra',
            'Sains & Matematika',
            'Teknologi & Informasi',
        ];

        foreach ($categories as $category) {
            \App\Models\Kategori::firstOrCreate(['nama_kategori' => $category]);
        }
    }
}
