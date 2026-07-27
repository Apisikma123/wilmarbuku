<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !empty(Auth::user()->last_login_token)) {
            $sessionToken = $request->session()->get('last_login_token');
            $userToken = Auth::user()->last_login_token;

            // Jika ada perbedaan token (berarti ada device lain yang login belakangan dengan akun ini)
            if ($sessionToken !== $userToken) {
                Auth::logout();
                
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $request->session()->flash('kicked_out_warning', true);
                
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
