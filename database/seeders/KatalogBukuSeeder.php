<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KatalogBuku;

class KatalogBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'judul_buku' => 'Manajemen Strategis',
                'pengarang' => 'Prof. Dr. Budi Santoso',
                'penerbit' => 'Erlangga',
                'kategori' => 'Bisnis & Manajemen',
                'deskripsi' => 'Buku ini membahas strategi manajemen untuk inovasi bisnis modern.',
                'jumlah_halaman' => '342 Hal',
                'badge' => 'Prioritas Kampus',
                'stok_dibutuhkan' => 15,
                'cover_image' => 'from-[#003215] to-[#004b23]', // using gradient classes
                'harga_estimasi' => 150000,
                'status_buku' => 'Dibutuhkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_buku' => 'Dasar Pemrograman',
                'pengarang' => 'Andreas Setiawan',
                'penerbit' => 'Andi Publisher',
                'kategori' => 'Teknologi',
                'deskripsi' => 'Konsep dasar pemrograman untuk mahasiswa jurusan TI.',
                'jumlah_halaman' => '410 Hal',
                'badge' => 'Buku Wajib',
                'stok_dibutuhkan' => 10,
                'cover_image' => 'from-slate-800 to-slate-900',
                'harga_estimasi' => 125000,
                'status_buku' => 'Dibutuhkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_buku' => 'Senja di Jakarta',
                'pengarang' => 'Mochtar Lubis',
                'penerbit' => 'Yayasan Obor Indonesia',
                'kategori' => 'Sastra',
                'deskripsi' => 'Novel klasik Indonesia yang mengangkat isu sosial di Jakarta.',
                'jumlah_halaman' => '250 Hal',
                'badge' => null,
                'stok_dibutuhkan' => 5,
                'cover_image' => 'from-amber-700 to-orange-950',
                'harga_estimasi' => 85000,
                'status_buku' => 'Dibutuhkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_buku' => 'Kisah Sukses Pengusaha Muda',
                'pengarang' => 'Ahmad Setiawan & Tim',
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Motivasi',
                'deskripsi' => 'Inspirasi bisnis dan kisah perjalanan pengusaha sukses Indonesia.',
                'jumlah_halaman' => '180 Hal',
                'badge' => 'Bestseller',
                'stok_dibutuhkan' => 8,
                'cover_image' => 'from-teal-800 to-[#003128]',
                'harga_estimasi' => 110000,
                'status_buku' => 'Dibutuhkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        KatalogBuku::insert($books);
    }
}
