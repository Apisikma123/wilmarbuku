<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
| Halaman yang bisa diakses siapa saja tanpa perlu login.
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/donasi', function () {
    return view('donasi');
})->name('donasi');

/*
|--------------------------------------------------------------------------
| Auth Routes (Login & Register)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/*
|--------------------------------------------------------------------------
| User Routes (Perlu Login)
|--------------------------------------------------------------------------
| Halaman khusus user yang sudah terautentikasi.
| TODO: Tambahkan middleware('auth') setelah auth system aktif.
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/transaksi', function () {
    return view('transaksi');
})->name('transaksi');

Route::get('/track', function () {
    return view('track');
})->name('track');

Route::get('/akun', function () {
    return view('akun');
})->name('akun');

Route::get('/buku', function () {
    return view('buku');
})->name('buku');

// Static Pages
Route::get('/tentang-kami', function () { return view('static.tentang'); })->name('tentang');
Route::get('/panduan-donasi', function () { return view('static.panduan'); })->name('panduan');
Route::get('/kebijakan-privasi', function () { return view('static.privasi'); })->name('privasi');
Route::get('/faq', function () { return view('static.faq'); })->name('faq');
Route::get('/terms', function () { return view('static.terms'); })->name('terms');
Route::get('/cookie-policy', function () { return view('static.cookie'); })->name('cookie');
