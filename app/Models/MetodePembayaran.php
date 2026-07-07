<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $fillable = [
        'tipe',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'is_active',
    ];
}
