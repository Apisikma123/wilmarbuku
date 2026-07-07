<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesanMasuk extends Model
{
    use HasFactory;

    protected $table = 'pesan_masuk';

    protected $fillable = [
        'user_id',
        'judul',
        'isi_pesan',
        'jenis',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($pesanMasuk) {
            // Check if the user exists and has an email
            if ($pesanMasuk->user && $pesanMasuk->user->email) {
                \Illuminate\Support\Facades\Mail::to($pesanMasuk->user->email)->send(new \App\Mail\NotificationMail($pesanMasuk));
            }
        });
    }
}
