<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
| Halaman yang bisa diakses siapa saja tanpa perlu login.
*/

Route::get('/', function () {
    session(['is_user' => false]);
    return app(App\Http\Controllers\KatalogController::class)->index(request());
})->name('home');

Route::get('/donasi', function () {
    return app(App\Http\Controllers\KatalogController::class)->index(request());
})->name('donasi');

/*
|--------------------------------------------------------------------------
| Auth Routes (Login & Register)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Halaman khusus user yang sudah terautentikasi
    Route::get('/dashboard', [App\Http\Controllers\KatalogController::class, 'dashboard'])->name('dashboard');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/transaksi', [App\Http\Controllers\TransaksiController::class, 'index'])->name('transaksi');
    Route::get('/track', [App\Http\Controllers\TransaksiController::class, 'track'])->name('track');
    Route::get('/kategori', [App\Http\Controllers\KatalogController::class, 'kategori'])->name('kategori');
    Route::get('/pesan-masuk', [App\Http\Controllers\PesanController::class, 'index'])->name('pesan-masuk');
    Route::post('/pesan-masuk/read', [App\Http\Controllers\PesanController::class, 'markAsRead'])->name('pesan.read');

    Route::get('/akun', [App\Http\Controllers\ProfileController::class, 'index'])->name('akun');
    Route::get('/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');

    Route::get('/buku/{id}', [App\Http\Controllers\KatalogController::class, 'show'])->name('buku.detail');
});

// Static Pages
$staticPages = [
    'tentang-kami' => 'static.tentang',
    'panduan-donasi' => 'static.panduan',
    'kebijakan-privasi' => 'static.privasi',
    'faq' => 'static.faq',
    'terms' => 'static.terms',
    'cookie-policy' => 'static.cookie'
];

foreach ($staticPages as $uri => $view) {
    Route::get('/' . $uri, function () use ($view) {
        $referer = request()->headers->get('referer');
        if ($referer) {
            if (str_ends_with($referer, '8000/') || str_contains($referer, '/login') || str_contains($referer, '/register')) {
                session(['is_user' => false]);
            } else {
                session(['is_user' => true]);
            }
        }
        return view($view);
    })->name(str_replace('static.', '', $view));
}

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
