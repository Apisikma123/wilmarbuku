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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Halaman khusus user yang sudah terautentikasi
    Route::get('/dashboard', function () {
        session(['is_user' => true]);
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

    Route::get('/kategori', function () {
        return view('kategori');
    })->name('kategori');

    Route::get('/akun', function () {
        return view('akun');
    })->name('akun');

    Route::get('/success', function () {
        return view('success');
    })->name('success');

    Route::get('/buku', function () {
        return view('buku');
    })->name('buku');
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
