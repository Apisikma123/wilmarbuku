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

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return false; 
            }

            $code = $e->getStatusCode();
            
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
