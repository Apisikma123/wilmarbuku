@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6 p-4 md:p-0">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Pengaturan</h2>
        <p class="text-slate-500 mt-2">Kelola pengaturan akun dan preferensi Anda.</p>
    </div>

    <!-- My Profile -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Profil Saya</h3>
            <p class="text-sm text-slate-500">Perbarui informasi pribadi dan foto Anda.</p>
        </div>
        <form method="POST" action="{{ route('akun.updateProfile') }}" class="p-6">
            @csrf
            
            @if(session('success') && str_contains(session('success'), 'Profil'))
                <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 border border-green-200 rounded-lg p-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col items-center gap-6 mb-6">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 rounded-full bg-slate-200 overflow-hidden border-4 border-white shadow-md flex items-center justify-center">
                        <i data-lucide="user" class="w-12 h-12 text-slate-400"></i>
                    </div>
                    <button class="text-xs font-bold text-green-700 hover:text-green-800 transition-colors uppercase tracking-wider"></button>
                </div>
                <!-- Form Fields -->
                <div class="w-full space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium">
                        @error('nama_lengkap') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-100 mt-4">
                <button type="submit" class="px-6 py-2.5 bg-green-900 text-white font-bold rounded-lg hover:bg-green-800 transition-colors shadow-sm text-sm mt-3">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <!-- Change Password -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Ubah Kata Sandi</h3>
            <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan kata sandi acak dan panjang agar tetap aman.</p>
        </div>
        <form method="POST" action="{{ route('user.password.update') }}" class="p-6">
            @csrf
            @method('put')

            @if(session('success') && str_contains(session('success'), 'sandi'))
                <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 border border-green-200 rounded-lg p-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-5 max-w-xl">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Kata Sandi Baru</label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                    @error('new_password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="new_password_confirmation" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-100 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-sm text-sm mt-3">Perbarui Kata Sandi</button>
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
                <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center gap-3 px-6 py-3.5 bg-green-50 text-green-700 border border-green-100 rounded-xl font-bold hover:bg-green-100 transition-all cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-green-600 shadow-sm group-hover:bg-green-50 transition-colors">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </div>
                    View User Dashboard
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
