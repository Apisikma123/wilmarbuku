<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/donasi', function () {
    return view('donasi');
})->name('donasi');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
})->name('admin.dashboard');

Route::get('/admin/catalog', function () {
    return view('admins.catalog');
})->name('admin.catalog');

Route::get('/admin/transactions', function () {
    return view('admins.transactions');
})->name('admin.transactions');

Route::get('/admin/users', function () {
    return view('admins.users');
})->name('admin.users');

Route::get('/admin/reports', function () {
    return view('admins.reports');
})->name('admin.reports');

Route::get('/admin/about', function () {
    return view('admins.about');
})->name('admin.about');

Route::get('/admin/settings', function () {
    return view('admins.settings');
})->name('admin.settings');

Route::get('/admin/dibutuhkan', function () {
    return view('admins.dibutuhkan');
})->name('admin.dibutuhkan');
