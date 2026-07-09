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
            'nama_lengkap' => 'required|string|max:255',
            'identitas_kampus' => 'nullable|string|max:255',
        ];

        // If not logged in via google, they can update their email
        if (!$user->google_id) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        }

        $request->validate($rules);

        $isNimUpdated = false;
        
        // If identitas_kampus is provided and different from before
        if ($request->identitas_kampus && $request->identitas_kampus !== $user->identitas_kampus) {
            $user->nim_status = 'pending';
            $isNimUpdated = true;
        } elseif (empty($request->identitas_kampus)) {
            $user->nim_status = 'unverified';
            // If they clear the NIM, they should be downgraded to external if they were internal
            if ($user->role == 'user_internal') {
                $user->role = 'user_external';
            }
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->identitas_kampus = $request->identitas_kampus;
        
        if (!$user->google_id) {
            $user->email = $request->email;
        }

        $user->save();

        if ($isNimUpdated) {
            return redirect()->back()->with('success', 'Profil berhasil diperbarui. NIM Anda akan divalidasi admin terlebih dahulu untuk akses akun internal.');
        }

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
