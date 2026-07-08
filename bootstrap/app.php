<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // CSRF diaktifkan untuk semua route (except dihapus)
        $middleware->validateCsrfTokens(except: [
            // Jika ada route third party webhook (misal Midtrans nanti), taruh di sini
        ]);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
        ]);
        $middleware->appendToGroup('web', \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
