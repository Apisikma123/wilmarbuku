<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $throttleKey = 'login|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            \Illuminate\Support\Facades\Log::info('Login attempt', [
                'user_id' => $user->id,
            ]);

            // Jika memilih Ingat Saya sebelumnya dan ada cookie, langsung login
            if ($request->cookie('trusted_device_user_' . $user->id) === '1') {
                Auth::login($user, $request->has('remember'));
                $request->session()->regenerate();
                
                if (!$user->is_onboarding_completed && $user->role !== 'admin') {
                    return redirect()->route('onboarding.student-check');
                }
                
                $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : '/dashboard';
                $intendedUrl = session()->pull('url.intended', $redirectUrl);
                
                if ($user->role === 'admin') {
                    if (!str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
                } else {
                    if (str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
                }
                
                return redirect()->to($intendedUrl);
            }

            // Bypass OTP for Login
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            
            if (!$user->is_onboarding_completed && $user->role !== 'admin') {
                return redirect()->route('onboarding.student-check');
            }
            
            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : '/dashboard';
            $intendedUrl = session()->pull('url.intended', $redirectUrl);
            
            if ($user->role === 'admin') {
                if (!str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            } else {
                if (str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            }
            
            return redirect()->to($intendedUrl);
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            return back()->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login.'])->withInput();
        }

        $request->session()->put('registration_data', [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_verified' => true,
        ]);

        return redirect()->route('onboarding.student-check');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Disable SSL verification for local Windows development (cURL error 60)
            $verifySSL = config('app.env') === 'production';
        $guzzleClient = new \GuzzleHttp\Client(['verify' => $verifySSL]);
            $googleUser = Socialite::driver('google')->setHttpClient($guzzleClient)->user();

            // Check if user already exists
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // If user exists but doesn't have google_id, update it
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                Auth::login($user);
            } else {
                // Do not create user yet, store in session
                session()->put('google_user_data', [
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);
                return redirect()->route('onboarding.profile');
            }

            if (!$user->is_onboarding_completed && $user->role !== 'admin') {
                return redirect()->route('onboarding.student-check');
            }

            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : '/dashboard';
            $intendedUrl = session()->pull('url.intended', $redirectUrl);
            
            if ($user->role === 'admin') {
                if (!str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            } else {
                if (str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            }
            
            return redirect()->to($intendedUrl);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.']);
        }
    }

    // --- Forgot Password Flow ---

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $throttleKey = 'forgot_pass|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem kami.']);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        $request->session()->put('reset_authorized_email', $user->email);

        return redirect()->route('password.reset');
    }

    public function showResetPasswordForm(Request $request)
    {
        if (!$request->session()->has('reset_authorized_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = $request->session()->get('reset_authorized_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $request->session()->forget('reset_authorized_email');

        return redirect()->route('login')->with('status', 'Kata sandi berhasil diubah! Silakan login dengan kata sandi baru.');
    }
}
