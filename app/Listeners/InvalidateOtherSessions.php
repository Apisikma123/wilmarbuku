<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InvalidateOtherSessions
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Generate token unik baru untuk sesi login saat ini
        $token = \Illuminate\Support\Str::random(60);
        
        /** @var \App\Models\User $user */
        $user = $event->user;
        
        // Simpan token di database pada akun user dan di dalam session aktif saat ini
        $user->last_login_token = $token;
        $user->save();

        Session::put('last_login_token', $token);
    }
}
