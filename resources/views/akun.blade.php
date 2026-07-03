@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <div class="mb-10">
        <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Profil Akun</h1>
        <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Kelola informasi pribadi dan unduh dokumen bebas pustaka/kelulusan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-primary to-primary-container"></div>
                <div class="px-6 pb-6 relative">
                    <div class="w-20 h-20 bg-surface-bright rounded-full border-4 border-white flex items-center justify-center -mt-10 mb-4 shadow-sm relative mx-auto lg:mx-0">
                        <span class="text-3xl font-bold text-primary uppercase">{{ substr(Auth::user()->nama_lengkap, 0, 2) }}</span>
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-secondary text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                            <span class="material-symbols-outlined text-[12px]">verified</span>
                        </div>
                    </div>
                    
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl font-bold text-on-surface mb-1">{{ Auth::user()->nama_lengkap }}</h2>
                        <p class="text-sm text-on-surface-variant font-medium mb-4">{{ Auth::user()->role == 'user_internal' ? 'Internal Kampus' : 'Donatur Eksternal' }}</p>
                        
                        <div class="space-y-3 pt-4 border-t border-outline-variant/30">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">badge</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-wider">NIM / NIDN</p>
                                    <p class="text-sm font-semibold text-on-surface">{{ Auth::user()->identitas_kampus ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">mail</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-wider">Email Akun</p>
                                    <p class="text-sm font-semibold text-on-surface">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-white border border-error/50 text-error font-bold py-3.5 rounded-xl hover:bg-error/10 transition-colors shadow-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">logout</span> Keluar Akun
                </button>
            </form>
        </div>

        <!-- Right Column: Settings Form -->
        <div class="lg:col-span-8 space-y-6">
            
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session("success") }}',
                        confirmButtonColor: '#003215'
                    });
                });
            </script>
            @endif

            @if($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terdapat kesalahan pada input Anda. Silakan cek kembali.',
                        confirmButtonColor: '#003215'
                    });
                });
            </script>
            @endif

            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/30">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/30">
                    <span class="material-symbols-outlined text-primary text-[28px]">manage_accounts</span>
                    <div>
                        <h3 class="font-bold text-on-surface text-lg">Informasi Pribadi</h3>
                        <p class="text-xs text-on-surface-variant">Perbarui detail profil dasar Anda</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('akun.updateProfile') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary transition-colors">
                            @error('nama_lengkap') <p class="text-[10px] text-error mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2">NIM / NIDN (Internal Kampus)</label>
                            <input type="text" value="{{ Auth::user()->identitas_kampus ?? '-' }}" readonly class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg py-3 px-4 text-sm text-on-surface/70 font-medium cursor-not-allowed">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-2">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" {{ Auth::user()->google_id ? 'readonly' : '' }} class="w-full {{ Auth::user()->google_id ? 'bg-surface-container-low cursor-not-allowed text-on-surface/70' : 'bg-surface-bright text-on-surface' }} border border-outline-variant/50 rounded-lg py-3 px-4 text-sm font-medium focus:ring-primary focus:border-primary transition-colors">
                        @error('email') <p class="text-[10px] text-error mt-1">{{ $message }}</p> @enderror
                        @if(Auth::user()->google_id)
                            <p class="text-[10px] text-on-surface-variant mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">info</span> Terhubung dengan akun Google.</p>
                        @endif
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary-container transition-colors shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/30">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/30">
                    <span class="material-symbols-outlined text-primary text-[28px]">lock</span>
                    <div>
                        <h3 class="font-bold text-on-surface text-lg">Keamanan Akun</h3>
                        <p class="text-xs text-on-surface-variant">Perbarui kata sandi Anda</p>
                    </div>
                </div>
                
                @if(Auth::user()->google_id && !Auth::user()->password)
                    <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/30 flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary">info</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Akun Google Tertaut</p>
                            <p class="text-xs text-on-surface-variant mt-1">Anda masuk menggunakan Google. Anda tidak perlu mengatur kata sandi, namun Anda bisa membuatnya jika ingin login menggunakan email dan password di kemudian hari.</p>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('akun.updatePassword') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="Masukkan kata sandi saat ini" class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary transition-colors">
                            @error('current_password') <p class="text-[10px] text-error mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-on-surface-variant mb-2">Kata Sandi Baru</label>
                                <input type="password" name="new_password" placeholder="Minimal 8 karakter" class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary transition-colors">
                                @error('new_password') <p class="text-[10px] text-error mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-on-surface-variant mb-2">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="new_password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary transition-colors">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-surface-container-high text-on-surface font-bold px-8 py-3 rounded-xl hover:bg-outline-variant/50 transition-colors shadow-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">key</span> Perbarui Sandi
                            </button>
                        </div>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
