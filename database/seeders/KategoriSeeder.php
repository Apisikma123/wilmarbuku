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
            ['nama_kategori' => 'Buku Donasi', 'icon' => 'volunteer_activism'],
            ['nama_kategori' => 'E-Book Eksklusif', 'icon' => 'devices'],
            ['nama_kategori' => 'Jurnal Akademik', 'icon' => 'article'],
            ['nama_kategori' => 'Modul Kuliah', 'icon' => 'menu_book'],
            ['nama_kategori' => 'Inspirasi Bisnis', 'icon' => 'lightbulb'],
            ['nama_kategori' => 'Sains & Teknologi', 'icon' => 'science'],
            ['nama_kategori' => 'Sastra & Novel', 'icon' => 'auto_stories'],
            ['nama_kategori' => 'Sosial & Budaya', 'icon' => 'public'],
            ['nama_kategori' => 'Buku Terbaru', 'icon' => 'new_releases'],
            ['nama_kategori' => 'Bestseller Donasi', 'icon' => 'military_tech'],
        ];

        foreach ($categories as $category) {
            \App\Models\Kategori::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                ['icon' => $category['icon']]
            );
        }
    }
}
