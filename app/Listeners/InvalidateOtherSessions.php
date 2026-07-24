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
        // Delete all other sessions for this user from the database
        DB::table('sessions')
            ->where('user_id', $event->user->id)
            ->where('id', '!=', Session::getId())
            ->delete();
    }
}
