<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\PesanMasukObserver;

#[ObservedBy([PesanMasukObserver::class])]
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
                \Illuminate\Support\Facades\Mail::to($pesanMasuk->user->email)->queue(new \App\Mail\NotificationMail($pesanMasuk));
            }
        });
    }
}
