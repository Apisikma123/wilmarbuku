<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\BukuRepositoryInterface;
use App\Repositories\BukuRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BukuRepositoryInterface::class, BukuRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\InvalidateOtherSessions::class,
        );

        if (str_contains(request()->header('X-Forwarded-Proto') ?? '', 'https') || request()->secure()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $kategoris = \Illuminate\Support\Facades\Cache::store('array')->remember('global_kategoris', 3600, function () {
                return \App\Models\Kategori::all();
            });
            $penerbits = \Illuminate\Support\Facades\Cache::store('array')->remember('global_penerbits', 3600, function () {
                return \App\Models\Penerbit::all();
            });

            $view->with('global_kategoris', $kategoris);
            $view->with('global_penerbits', $penerbits);
            // Buku Terkumpul: jumlah qty buku dari transaksi yang sudah Selesai (atau Paid)
            $totalBukuTerkumpul = \Illuminate\Support\Facades\Cache::store('array')->remember('global_total_buku', 300, function () {
                return \App\Models\TransaksiDetail::whereHas('transaksi', function($q) {
                    $q->where('status_tracking', 'Selesai')->orWhere('status_pembayaran', 'Paid');
                })->sum('qty');
            });
            
            // Donatur Aktif: dari jumlah user (role bukan admin)
            $donaturAktif = \Illuminate\Support\Facades\Cache::store('array')->remember('global_donatur_aktif', 300, function () {
                return \App\Models\User::where('role', '!=', 'admin')->count();
            });

            $view->with('global_total_buku', $totalBukuTerkumpul);
            $view->with('global_donatur_aktif', $donaturAktif);
        });
    }
}
