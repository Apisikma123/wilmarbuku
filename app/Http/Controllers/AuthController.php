<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

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
                'has_trusted_cookie' => $request->hasCookie('trusted_device_user_' . $user->id),
                'remember_input' => $request->has('remember'),
                'remember_value' => $request->input('remember')
            ]);

            // Jika memilih Ingat Saya sebelumnya dan ada cookie, langsung login
            if ($request->cookie('trusted_device_user_' . $user->id) === '1') {
                Auth::login($user, $request->has('remember'));
                $request->session()->regenerate();
                
                if (!$user->is_onboarding_completed) {
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

            // Generate 6-digit OTP
            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            $user->update([
                'otp_code' => Hash::make($otpCode),
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            // Send OTP email
            Mail::to($user->email)->send(new OtpMail($otpCode));

            // Store user id and timestamp temporarily
            $request->session()->put('otp_user_id', $user->id);
            \Illuminate\Support\Facades\Cache::put('last_otp_sent_at_' . $user->id, now()->timestamp, 60);
            $request->session()->put('remember_me', $request->has('remember'));

            return redirect()->route('otp.show');
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showOtp(Request $request)
    {
        $userId = $request->session()->get('otp_user_id');
        $regData = $request->session()->get('registration_data');
        
        if (!$userId && !$regData) {
            return redirect()->route('login');
        }

        $cacheKey = $userId ? 'last_otp_sent_at_' . $userId : 'last_otp_sent_at_' . md5($regData['email']);
        $lastSent = \Illuminate\Support\Facades\Cache::get($cacheKey, 0);
        $cooldown = max(0, 60 - (now()->timestamp - $lastSent));

        return view('auth.otp', compact('cooldown'));
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('otp_user_id');
        $regData = $request->session()->get('registration_data');
        
        if ($userId) {
            $lastSent = \Illuminate\Support\Facades\Cache::get('last_otp_sent_at_' . $userId, 0);
            if (now()->timestamp - $lastSent < 60) {
                return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
            }

            $user = User::find($userId);
            if (!$user) return redirect()->route('login');

            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->update([
                'otp_code' => Hash::make($otpCode),
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new OtpMail($otpCode));
            \Illuminate\Support\Facades\Cache::put('last_otp_sent_at_' . $userId, now()->timestamp, 60);

            return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
        } elseif ($regData) {
            $cacheKey = 'last_otp_sent_at_' . md5($regData['email']);
            $lastSent = \Illuminate\Support\Facades\Cache::get($cacheKey, 0);
            if (now()->timestamp - $lastSent < 60) {
                return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
            }

            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $regData['otp_code'] = Hash::make($otpCode);
            $regData['otp_expires_at'] = Carbon::now()->addMinutes(5)->timestamp;
            $request->session()->put('registration_data', $regData);

            Mail::to($regData['email'])->send(new OtpMail($otpCode));
            \Illuminate\Support\Facades\Cache::put($cacheKey, now()->timestamp, 60);

            return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
        }

        return redirect()->route('login')->withErrors(['email' => 'Sesi login telah habis.']);
    }

    public function verifyOtp(Request $request)
    {
        $throttleKey = 'otp|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $userId = $request->session()->get('otp_user_id');
        $regData = $request->session()->get('registration_data');

        if ($regData) {
            if (!Hash::check($request->otp_code, $regData['otp_code']) || now()->timestamp > $regData['otp_expires_at']) {
                \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
                return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
            }

            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            $regData['otp_verified'] = true;
            $request->session()->put('registration_data', $regData);
            
            return redirect()->route('onboarding.student-check');
        } elseif ($userId) {
            $user = User::find($userId);

            if (!$user || !Hash::check($request->otp_code, $user->otp_code ?? '') || Carbon::now()->greaterThan($user->otp_expires_at)) {
                \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
                return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
            }

            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            // Clear OTP and log in, also set email_verified_at
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            $remember = $request->session()->get('remember_me', false);
            Auth::login($user, $remember);
            
            $request->session()->forget(['otp_user_id', 'remember_me']);
            $request->session()->regenerate();

            if (!$user->is_onboarding_completed) {
                if ($remember) {
                    \Illuminate\Support\Facades\Cookie::queue('trusted_device_user_' . $user->id, '1', 60 * 24 * 30);
                }
                return redirect()->route('onboarding.student-check');
            }

            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : '/dashboard';
            $intendedUrl = session()->pull('url.intended', $redirectUrl);
            
            if ($user->role === 'admin') {
                if (!str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            } else {
                if (str_contains($intendedUrl, '/admin')) $intendedUrl = $redirectUrl;
            }

            $response = redirect()->to($intendedUrl);

            if ($remember) {
                \Illuminate\Support\Facades\Cookie::queue('trusted_device_user_' . $user->id, '1', 60 * 24 * 30);
            }

            return $response;
        }

        return redirect()->route('login')->withErrors(['email' => 'Sesi login telah habis.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            return back()->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login.'])->withInput();
        }

        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $request->session()->put('registration_data', [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => Hash::make($otpCode),
            'otp_expires_at' => Carbon::now()->addMinutes(5)->timestamp,
        ]);

        Mail::to($request->email)->send(new OtpMail($otpCode));
        \Illuminate\Support\Facades\Cache::put('last_otp_sent_at_' . md5($request->email), now()->timestamp, 60);

        return redirect()->route('otp.show');
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

            if (!$user->is_onboarding_completed) {
                return redirect()->route('onboarding.profile');
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
        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp_code' => Hash::make($otpCode),
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode));

        $request->session()->put('reset_user_email', $user->email);
        \Illuminate\Support\Facades\Cache::put('last_reset_otp_sent_at_' . $user->email, now()->timestamp, 60);

        return redirect()->route('password.otp.show');
    }

    public function showForgotOtpForm(Request $request)
    {
        if (!$request->session()->has('reset_user_email')) {
            return redirect()->route('password.request');
        }

        $lastSent = \Illuminate\Support\Facades\Cache::get('last_reset_otp_sent_at_' . $request->session()->get('reset_user_email'), 0);
        $cooldown = max(0, 60 - (now()->timestamp - $lastSent));

        return view('auth.forgot-otp', compact('cooldown'));
    }

    public function resendForgotOtp(Request $request)
    {
        $email = $request->session()->get('reset_user_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah habis.']);
        }

        $lastSent = \Illuminate\Support\Facades\Cache::get('last_reset_otp_sent_at_' . $email, 0);
        if (now()->timestamp - $lastSent < 60) {
            return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) return redirect()->route('password.request');

        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp_code' => Hash::make($otpCode),
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode));

        \Illuminate\Support\Facades\Cache::put('last_reset_otp_sent_at_' . $email, now()->timestamp, 60);

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function verifyForgotOtp(Request $request)
    {
        $throttleKey = 'forgot_otp|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->session()->get('reset_user_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah habis.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($request->otp_code, $user->otp_code ?? '') || Carbon::now()->greaterThan($user->otp_expires_at)) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
        // OTP Valid! Authorize for password reset
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $request->session()->put('reset_authorized_email', $user->email);
        $request->session()->forget(['reset_user_email']);

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
