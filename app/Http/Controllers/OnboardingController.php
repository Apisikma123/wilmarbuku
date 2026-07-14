<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Show profile confirmation for Google users.
     */
    public function showProfile()
    {
        $googleData = session('google_user_data');
        $user = Auth::user();

        if (!$googleData && !$user) {
            return redirect()->route('login');
        }

        if ($user && $user->is_onboarding_completed) {
            return redirect()->to($this->getRedirectUrl());
        }

        $userData = $googleData ? (object) $googleData : $user;

        return view('auth.onboarding-profile', ['user' => $userData]);
    }

    /**
     * Handle profile submission (Google users).
     */
    public function storeProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
        ]);

        $googleData = session('google_user_data');
        if ($googleData) {
            if ($request->is_student) {
                // Keep in session, update name
                $googleData['nama_lengkap'] = $request->nama_lengkap;
                session()->put('google_user_data', $googleData);
                return redirect()->route('onboarding.nim');
            } else {
                // Register as external and complete onboarding
                $user = \App\Models\User::create([
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $googleData['email'],
                    'google_id' => $googleData['google_id'],
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                    'role' => 'user_external',
                    'is_onboarding_completed' => true,
                ]);
                Auth::login($user);
                session()->forget('google_user_data');
                return redirect()->to($this->getRedirectUrl());
            }
        } else {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }
            $user->update([
                'nama_lengkap' => $request->nama_lengkap
            ]);
            
            if ($request->is_student) {
                return redirect()->route('onboarding.nim');
            } else {
                // Skip NIM, set as external user
                $user->update([
                    'is_onboarding_completed' => true,
                    'role' => 'user_external'
                ]);
                return redirect()->to($this->getRedirectUrl());
            }
        }
    }

    /**
     * Show student check for Regular registered users.
     */
    public function showStudentCheck()
    {
        $regData = session('registration_data');
        $user = Auth::user();

        if (!$regData && !$user) {
            return redirect()->route('login');
        }

        if ($regData && !isset($regData['otp_verified'])) {
            return redirect()->route('otp.show');
        }

        if ($user && $user->is_onboarding_completed) {
            return redirect()->to($this->getRedirectUrl());
        }

        return view('auth.onboarding-student-check');
    }

    /**
     * Handle student check submission (Regular users).
     */
    public function storeStudentCheck(Request $request)
    {
        if ($request->is_student) {
            return redirect()->route('onboarding.nim');
        } else {
            $regData = session('registration_data');
            
            if ($regData && isset($regData['otp_verified'])) {
                $user = \App\Models\User::create([
                    'nama_lengkap' => $regData['nama_lengkap'],
                    'email' => $regData['email'],
                    'password' => $regData['password'],
                    'role' => 'user_external',
                    'is_onboarding_completed' => true,
                    'email_verified_at' => now(),
                ]);
                Auth::login($user);
                session()->forget('registration_data');
            } else {
                $user = Auth::user();
                if (!$user) return redirect()->route('login');
                
                $updateData = ['is_onboarding_completed' => true];
                if ($user->role !== 'admin') {
                    $updateData['role'] = 'user_external';
                }
                
                $user->update($updateData);
            }
            return redirect()->to($this->getRedirectUrl());
        }
    }

    /**
     * Show NIM input page.
     */
    public function showNim()
    {
        $googleData = session('google_user_data');
        $regData = session('registration_data');
        $user = Auth::user();

        if (!$googleData && !$regData && !$user) {
            return redirect()->route('login');
        }

        if ($user && $user->is_onboarding_completed) {
            return redirect()->to($this->getRedirectUrl());
        }

        return view('auth.onboarding-nim');
    }

    /**
     * Handle NIM submission.
     */
    public function storeNim(Request $request)
    {
        $request->validate([
            'identitas_kampus' => ['required', 'string', 'max:15'],
        ]);

        $googleData = session('google_user_data');
        $regData = session('registration_data');
        
        if ($googleData) {
            $user = \App\Models\User::create([
                'nama_lengkap' => $googleData['nama_lengkap'],
                'email' => $googleData['email'],
                'google_id' => $googleData['google_id'],
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                'identitas_kampus' => $request->identitas_kampus,
                'role' => 'user_internal',
                'nim_status' => 'verified',
                'is_onboarding_completed' => true,
            ]);
            Auth::login($user);
            session()->forget('google_user_data');
        } elseif ($regData && isset($regData['otp_verified'])) {
            $user = \App\Models\User::create([
                'nama_lengkap' => $regData['nama_lengkap'],
                'email' => $regData['email'],
                'password' => $regData['password'],
                'identitas_kampus' => $request->identitas_kampus,
                'role' => 'user_internal',
                'nim_status' => 'verified',
                'is_onboarding_completed' => true,
                'email_verified_at' => now(),
            ]);
            Auth::login($user);
            session()->forget('registration_data');
        } else {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }
            $user->update([
                'identitas_kampus' => $request->identitas_kampus,
                'is_onboarding_completed' => true,
                'role' => 'user_internal',
                'nim_status' => 'verified',
            ]);
        }

        return redirect()->to($this->getRedirectUrl());
    }

    /**
     * Get redirect URL based on role.
     */
    private function getRedirectUrl()
    {
        $user = Auth::user();
        if (!$user) return '/dashboard';
        $redirectUrl = $user->role === 'admin' ? route('admin.dashboard', absolute: false) : '/dashboard';
        return session()->pull('url.intended', $redirectUrl);
    }
}
