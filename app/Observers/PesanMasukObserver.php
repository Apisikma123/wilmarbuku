<?php

namespace App\Observers;

use App\Models\PesanMasuk;

class PesanMasukObserver
{
    /**
     * Handle the PesanMasuk "created" event.
     */
    public function created(PesanMasuk $pesanMasuk): void
    {
        \Illuminate\Support\Facades\Log::info("PesanMasuk created for user {$pesanMasuk->user_id}. Broadcasting event...");
        broadcast(new \App\Events\PesanBaruEvent($pesanMasuk->user_id, $pesanMasuk->judul, $pesanMasuk->isi_pesan));
    }

    /**
     * Handle the PesanMasuk "updated" event.
     */
    public function updated(PesanMasuk $pesanMasuk): void
    {
        //
    }

    /**
     * Handle the PesanMasuk "deleted" event.
     */
    public function deleted(PesanMasuk $pesanMasuk): void
    {
        //
    }

    /**
     * Handle the PesanMasuk "restored" event.
     */
    public function restored(PesanMasuk $pesanMasuk): void
    {
        //
    }

    /**
     * Handle the PesanMasuk "force deleted" event.
     */
    public function forceDeleted(PesanMasuk $pesanMasuk): void
    {
        //
    }
}
