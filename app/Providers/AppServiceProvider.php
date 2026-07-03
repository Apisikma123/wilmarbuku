<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('global_kategoris', \App\Models\Kategori::all());
            $view->with('global_penerbits', \App\Models\Penerbit::all());
            $view->with('global_total_buku', \App\Models\KatalogBuku::count());
            $view->with('global_donatur_aktif', \App\Models\TransaksiCheckout::distinct('user_id')->count());
        });
    }
}
