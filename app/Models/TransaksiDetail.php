<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail';

    protected $fillable = [
        'kode_tracking',
        'buku_id',
        'qty',
        'harga_satuan',
        'pesan_dukungan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiCheckout::class, 'kode_tracking', 'kode_tracking');
    }

    public function buku()
    {
        return $this->belongsTo(KatalogBuku::class, 'buku_id');
    }
}
