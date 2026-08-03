<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        return view('akun');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama_lengkap' => 'required|string|max:50',
        ];

        // If not logged in via google, they can update their email
        if (!$user->google_id) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        }

        $request->validate($rules);

        // Check limits for nama_lengkap
        if ($request->nama_lengkap !== $user->nama_lengkap) {
            $currentMonth = \Carbon\Carbon::now()->format('Y-m');
            $lastChangedMonth = $user->username_changed_at ? \Carbon\Carbon::parse($user->username_changed_at)->format('Y-m') : null;

            if ($lastChangedMonth !== $currentMonth) {
                $user->username_change_count = 0;
            }

            if ($user->username_change_count >= 2) {
                return redirect()->back()->with('error', 'Anda telah mencapai batas maksimal perubahan nama (2 kali) untuk bulan ini.');
            }

            $user->nama_lengkap = $request->nama_lengkap;
            $user->username_change_count += 1;
            $user->username_changed_at = now();
        }
        if (!$user->google_id && $request->email !== $user->email) {
            $user->save(); // Save name changes first

            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->update([
                'otp_code' => \Illuminate\Support\Facades\Hash::make($otpCode),
                'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(5),
            ]);

            \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\OtpMail($otpCode));

            $request->session()->put('pending_new_email', $request->email);
            \Illuminate\Support\Facades\Cache::put('last_email_otp_sent_at_' . $user->id, now()->timestamp, 60);

            return redirect()->route('akun.email.otp.show')->with('status', 'Kode OTP telah dikirim ke email baru Anda.');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function showEmailOtpForm(Request $request)
    {
        if (!$request->session()->has('pending_new_email')) {
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.settings' : 'akun');
        }

        $user = Auth::user();
        $lastSent = \Illuminate\Support\Facades\Cache::get('last_email_otp_sent_at_' . $user->id, 0);
        $cooldown = max(0, 60 - (now()->timestamp - $lastSent));
        $newEmail = $request->session()->get('pending_new_email');

        return view('auth.email-update-otp', compact('cooldown', 'newEmail'));
    }

    public function resendEmailOtp(Request $request)
    {
        $newEmail = $request->session()->get('pending_new_email');
        if (!$newEmail) return redirect()->route(Auth::user()->role === 'admin' ? 'admin.settings' : 'akun');

        $user = Auth::user();
        $lastSent = \Illuminate\Support\Facades\Cache::get('last_email_otp_sent_at_' . $user->id, 0);
        if (now()->timestamp - $lastSent < 60) {
            return back()->withErrors(['otp_code' => 'Harap tunggu 1 menit sebelum meminta kode baru.']);
        }

        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp_code' => \Illuminate\Support\Facades\Hash::make($otpCode),
            'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(5),
        ]);

        \Illuminate\Support\Facades\Mail::to($newEmail)->send(new \App\Mail\OtpMail($otpCode));
        \Illuminate\Support\Facades\Cache::put('last_email_otp_sent_at_' . $user->id, now()->timestamp, 60);

        return back()->with('status', 'Kode OTP baru telah dikirim ke email baru Anda.');
    }

    public function verifyEmailOtp(Request $request)
    {
        $throttleKey = 'email_otp|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $request->validate(['otp_code' => ['required', 'string', 'size:6']]);

        $newEmail = $request->session()->get('pending_new_email');
        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->otp_code, $user->otp_code) || \Carbon\Carbon::now()->greaterThan($user->otp_expires_at)) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        $user->update([
            'email' => $newEmail,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $request->session()->forget('pending_new_email');

        return redirect()->route($user->role === 'admin' ? 'admin.settings' : 'akun')->with('success', 'Email berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if ($user->google_id && !$user->password) {
            // Cannot update password if it's a google account without one setup yet
            // Though we could allow setting a new password. Let's allow setting it if old password is not provided.
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
