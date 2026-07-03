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

Route::get('/debug-cookies', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'cookies' => $request->cookies->all(),
        'session' => $request->session()->all()
    ]);
});

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
    
    // Google OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    
    // OTP Routes (Login)
    Route::get('/otp', [AuthController::class, 'showOtp'])->name('otp.show');
    Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->name('password.email');
    
    Route::get('/forgot-password/otp', [AuthController::class, 'showForgotOtpForm'])->name('password.otp.show');
    Route::post('/forgot-password/otp/verify', [AuthController::class, 'verifyForgotOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/otp/resend', [AuthController::class, 'resendForgotOtp'])->name('password.otp.resend');
    
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
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

    Route::get('/payment', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment/upload', [App\Http\Controllers\CheckoutController::class, 'uploadProof'])->name('payment.upload');

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

use App\Http\Controllers\AdminController;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/export', [AdminController::class, 'exportDashboardPdf'])->name('admin.dashboard.export');
    Route::get('/catalog', [AdminController::class, 'catalog'])->name('admin.catalog');
    Route::post('/catalog/store', [AdminController::class, 'storeBook'])->name('admin.catalog.store');
    Route::post('/catalog/update/{id}', [AdminController::class, 'updateBook'])->name('admin.catalog.update');
    Route::post('/catalog/delete/{id}', [AdminController::class, 'destroyBook'])->name('admin.catalog.delete');

    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/transactions/status/{kode_tracking}', [AdminController::class, 'updateTransactionStatus'])->name('admin.transactions.status');
    Route::post('/transactions/confirm/{kode_tracking}', [AdminController::class, 'confirmTransaction'])->name('admin.transactions.confirm');
    Route::post('/transactions/cancel/{kode_tracking}', [AdminController::class, 'cancelTransaction'])->name('admin.transactions.cancel');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/role/{id}', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');

    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/export', [AdminController::class, 'exportPdf'])->name('admin.reports.export');
    Route::get('/support', [AdminController::class, 'support'])->name('admin.support');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/dibutuhkan', [AdminController::class, 'dibutuhkan'])->name('admin.dibutuhkan');
});
