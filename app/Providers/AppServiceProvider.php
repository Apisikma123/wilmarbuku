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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            static $kategoris = null;
            static $penerbits = null;

            if ($kategoris === null) {
                $kategoris = \App\Models\Kategori::all();
            }
            if ($penerbits === null) {
                $penerbits = \App\Models\Penerbit::all();
            }

            $view->with('global_kategoris', $kategoris);
            $view->with('global_penerbits', $penerbits);
            // Buku Terkumpul: jumlah qty buku dari transaksi yang sudah Selesai (atau Paid)
            $totalBukuTerkumpul = \Illuminate\Support\Facades\Cache::remember('global_total_buku', 300, function () {
                return \App\Models\TransaksiDetail::whereHas('transaksi', function($q) {
                    $q->where('status_tracking', 'Selesai')->orWhere('status_pembayaran', 'Paid');
                })->sum('qty');
            });
            
            // Donatur Aktif: dari jumlah user (role bukan admin)
            $donaturAktif = \Illuminate\Support\Facades\Cache::remember('global_donatur_aktif', 300, function () {
                return \App\Models\User::where('role', '!=', 'admin')->count();
            });

            $view->with('global_total_buku', $totalBukuTerkumpul);
            $view->with('global_donatur_aktif', $donaturAktif);
        });
    }
}
