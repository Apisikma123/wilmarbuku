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
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            \Illuminate\Support\Facades\Log::info('Login attempt', [
                'user_id' => $user->id,
                'has_trusted_cookie' => $request->hasCookie('trusted_device_user_' . $user->id),
                'all_cookies' => $request->cookies->all(),
                'remember_input' => $request->has('remember'),
                'remember_value' => $request->input('remember')
            ]);

            // Jika memilih Ingat Saya sebelumnya dan ada cookie, langsung login
            if ($request->cookie('trusted_device_user_' . $user->id) === '1') {
                Auth::login($user, $request->has('remember'));
                $request->session()->regenerate();
                
                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard', absolute: false));
                }
                return redirect()->intended('dashboard');
            }

            // Generate 6-digit OTP
            $otpCode = (string) mt_rand(100000, 999999);
            
            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            // Send OTP email
            Mail::to($user->email)->send(new OtpMail($otpCode));

            // Store user id and timestamp in session temporarily
            $request->session()->put('otp_user_id', $user->id);
            $request->session()->put('last_otp_sent_at', now()->timestamp);
            $request->session()->put('remember_me', $request->has('remember'));

            return redirect()->route('otp.show');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showOtp(Request $request)
    {
        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        $lastSent = $request->session()->get('last_otp_sent_at', 0);
        $cooldown = max(0, 60 - (now()->timestamp - $lastSent));

        return view('auth.otp', compact('cooldown'));
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi login telah habis.']);
        }

        $lastSent = $request->session()->get('last_otp_sent_at', 0);
        if (now()->timestamp - $lastSent < 60) {
            return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
        }

        $user = User::find($userId);
        if (!$user) return redirect()->route('login');

        // Generate new 6-digit OTP
        $otpCode = (string) mt_rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otpCode));

        // Update timestamp
        $request->session()->put('last_otp_sent_at', now()->timestamp);

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $userId = $request->session()->get('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi login telah habis.']);
        }

        $user = User::find($userId);

        if (!$user || $user->otp_code !== $request->otp_code || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        // Clear OTP and log in
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $remember = $request->session()->get('remember_me', false);
        Auth::login($user, $remember);
        
        $request->session()->forget(['otp_user_id', 'last_otp_sent_at', 'remember_me']);
        $request->session()->regenerate();

        $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : 'dashboard';
        $response = redirect()->intended($redirectUrl);

        // Jika user memilih Ingat Saya, simpan cookie trusted device selama 30 hari
        if ($remember) {
            \Illuminate\Support\Facades\Cookie::queue('trusted_device_user_' . $user->id, '1', 60 * 24 * 30);
        }

        return $response;
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user_external',
        ]);

        // Generate 6-digit OTP
        $otpCode = (string) mt_rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otpCode));

        // Store user id and timestamp in session temporarily
        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('last_otp_sent_at', now()->timestamp);
        $request->session()->put('remember_me', false); // No remember me on register by default

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
            $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
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
            } else {
                // Create a new user
                $user = User::create([
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'user_external',
                ]);
            }

            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            }

            return redirect()->intended('dashboard');

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
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem kami.']);
        }

        $otpCode = (string) mt_rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode));

        $request->session()->put('reset_user_email', $user->email);
        $request->session()->put('last_reset_otp_sent_at', now()->timestamp);

        return redirect()->route('password.otp.show');
    }

    public function showForgotOtpForm(Request $request)
    {
        if (!$request->session()->has('reset_user_email')) {
            return redirect()->route('password.request');
        }

        $lastSent = $request->session()->get('last_reset_otp_sent_at', 0);
        $cooldown = max(0, 60 - (now()->timestamp - $lastSent));

        return view('auth.forgot-otp', compact('cooldown'));
    }

    public function resendForgotOtp(Request $request)
    {
        $email = $request->session()->get('reset_user_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah habis.']);
        }

        $lastSent = $request->session()->get('last_reset_otp_sent_at', 0);
        if (now()->timestamp - $lastSent < 60) {
            return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) return redirect()->route('password.request');

        $otpCode = (string) mt_rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode));

        $request->session()->put('last_reset_otp_sent_at', now()->timestamp);

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function verifyForgotOtp(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->session()->get('reset_user_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah habis.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user || $user->otp_code !== $request->otp_code || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        // OTP Valid! Authorize for password reset
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $request->session()->put('reset_authorized_email', $user->email);
        $request->session()->forget(['reset_user_email', 'last_reset_otp_sent_at']);

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
