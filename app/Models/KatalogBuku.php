<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatalogBuku extends Model
{
    use HasFactory;

    protected $table = 'katalog_buku';

    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'kategori',
        'deskripsi',
        'jumlah_halaman',
        'badge',
        'stok_dibutuhkan',
        'cover_image',
        'harga_estimasi',
        'status_buku',
    ];
}
