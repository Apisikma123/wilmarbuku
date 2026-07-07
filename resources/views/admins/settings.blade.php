@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Settings</h2>
        <p class="text-slate-500 mt-2">Manage your account settings and preferences.</p>
    </div>

    <!-- My Profile -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">My Profile</h3>
            <p class="text-sm text-slate-500">Update your personal information and photo.</p>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-8 mb-6">
                <!-- Avatar -->
                <div class="flex flex-col items-center gap-3">
                    <div class="w-24 h-24 rounded-full bg-slate-200 overflow-hidden border-4 border-white shadow-md relative group cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&background=0D8ABC&color=fff" alt="{{ Auth::user()->nama_lengkap }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <button class="text-xs font-bold text-green-700 hover:text-green-800 transition-colors uppercase tracking-wider">Change Photo</button>
                </div>
                <!-- Form Fields -->
                <div class="flex-1 space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Full Name</label>
                        <input type="text" value="{{ Auth::user()->nama_lengkap }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Email Address</label>
                        <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium">
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-100 mt-4">
                <button class="px-6 py-2.5 bg-green-900 text-white font-bold rounded-lg hover:bg-green-800 transition-colors shadow-sm text-sm mt-3">Save Changes</button>
            </div>
        </div>
    </section>

    <!-- Change Password -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Change Password</h3>
            <p class="text-sm text-slate-500">Ensure your account is using a long, random password to stay secure.</p>
        </div>
        <form method="POST" action="{{ route('user.password.update') }}" class="p-6">
            @csrf
            @method('put')

            @if(session('status') === 'password-updated')
                <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 border border-green-200 rounded-lg p-3">
                    Password successfully updated!
                </div>
            @endif

            <div class="space-y-5 max-w-xl">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">New Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-100 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-sm text-sm mt-3">Update Password</button>
            </div>
        </form>
    </section>



    <!-- Other Actions (Support & Logout) -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-12">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">More Actions</h3>
            <p class="text-sm text-slate-500">Other administrative tasks and information.</p>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('admin.support') }}" class="flex-1 flex items-center justify-center gap-3 px-6 py-3.5 border border-slate-200 rounded-xl text-slate-700 font-bold hover:bg-slate-50 hover:border-slate-300 transition-all cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors">
                        <i data-lucide="life-buoy" class="w-5 h-5"></i>
                    </div>
                    View Support Page
                </a>
                <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center gap-3 px-6 py-3.5 bg-red-50 text-red-700 border border-red-100 rounded-xl font-bold hover:bg-red-100 transition-all cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-600 shadow-sm group-hover:bg-red-50 transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </div>
                    Logout Account
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
