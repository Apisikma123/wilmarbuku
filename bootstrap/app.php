<?php

if (!defined('SIGINT')) define('SIGINT', 2);
if (!defined('SIGTERM')) define('SIGTERM', 15);
if (!defined('SIGHUP')) define('SIGHUP', 1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        
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

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return false; 
            }

            // Biarkan Laravel menangani exception bawaan (Validasi, Login, Redirect)
            if ($e instanceof \Illuminate\Validation\ValidationException ||
                $e instanceof \Illuminate\Auth\AuthenticationException ||
                $e instanceof \Illuminate\Session\TokenMismatchException ||
                $e instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
                return false;
            }

            // Jika dalam mode development (APP_DEBUG=true), biarkan halaman error Ignition muncul untuk error coding (500)
            // Tapi tetap render halaman dinamis untuk error 404, 403, dsb.
            if (config('app.debug') && !$e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                return false;
            }

            $code = $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface ? $e->getStatusCode() : 500;
            
            $errors = [
                400 => ['title' => 'Permintaan Tidak Valid', 'desc' => 'Maaf, sistem tidak dapat memproses permintaan yang Anda kirim. Mungkin ada kesalahan pada URL atau data.'],
                401 => ['title' => 'Akses Terbatas', 'desc' => 'Anda harus masuk (login) ke dalam sistem untuk dapat mengakses halaman ini.'],
                403 => ['title' => 'Akses Ditolak', 'desc' => 'Maaf, Anda tidak memiliki izin atau hak akses yang cukup untuk melihat halaman ini.'],
                404 => ['title' => 'Halaman Tidak Ditemukan', 'desc' => 'Buku atau halaman yang Anda cari mungkin telah dihapus, dipindahkan, atau memang tidak pernah ada.'],
                500 => ['title' => 'Gangguan Server', 'desc' => 'Terjadi kesalahan internal pada server kami. Tim teknis sedang memperbaikinya, silakan coba lagi nanti.']
            ];

            $title = $errors[$code]['title'] ?? 'Terjadi Kesalahan';
            $desc = $errors[$code]['desc'] ?? ($e->getMessage() ?: 'Kami mendeteksi adanya kendala, mohon coba beberapa saat lagi.');

            return response()->view('errors.dynamic', [
                'ERROR_CODE' => $code,
                'ERROR_TITLE' => $title,
                'ERROR_DESCRIPTION' => $desc
            ], $code);
        });
    })->create();
