<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiCheckout extends Model
{
    use HasFactory;

    protected $table = 'transaksi_checkout';
    
    protected $primaryKey = 'kode_tracking';
    
    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tracking',
        'user_id',
        'total_harga',
        'midtrans_id',
        'status_pembayaran',
        'status_tracking',
        'validasi_lulus',
        'tanggal_checkout',
        'is_read_by_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'kode_tracking', 'kode_tracking');
    }
}
