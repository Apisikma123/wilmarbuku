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
        
        if (!$user->google_id) {
            $user->email = $request->email;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
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
