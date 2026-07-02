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
            <a href="/" class="w-full bg-white border border-error/50 text-error font-bold py-3.5 rounded-xl hover:bg-error/10 transition-colors shadow-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">logout</span> Keluar Akun
            </a>
        </div>

        <!-- Right Column: Settings & Certs -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Graduation Status -->
            <div class="bg-gradient-to-br from-[#003215] to-[#004b23] rounded-2xl p-8 text-white shadow-md relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <span class="material-symbols-outlined text-[150px]">workspace_premium</span>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center md:items-start gap-6">
                    <div class="text-center md:text-left">
                        <div class="inline-flex items-center gap-1.5 text-[10px] font-bold text-[#005143] bg-[#87f6dc] px-3 py-1.5 rounded-full uppercase tracking-wider mb-3">
                            <span class="material-symbols-outlined text-[14px]">verified</span> Syarat Terpenuhi
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Surat Bebas Pustaka</h3>
                        <p class="text-white/80 text-sm max-w-md leading-relaxed">Anda telah berhasil memenuhi syarat donasi buku untuk keperluan kelulusan. Surat bebas pustaka sudah dapat diunduh.</p>
                    </div>
                    <button class="shrink-0 bg-secondary text-white font-bold px-6 py-3 rounded-xl hover:bg-secondary-fixed transition-colors shadow-lg flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">download</span> Unduh PDF
                    </button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/30">
                <h3 class="font-bold text-on-surface text-lg mb-6 pb-4 border-b border-outline-variant/30">Pengaturan Profil</h3>
                
                <form class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->nama_lengkap }}" class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2">NIM / NIDN (Internal Kampus)</label>
                            <input type="text" value="{{ Auth::user()->identitas_kampus ?? '-' }}" readonly class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg py-3 px-4 text-sm text-on-surface/70 font-medium cursor-not-allowed">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-2">Email Publik (Opsional)</label>
                        <input type="email" placeholder="Email sekunder..." class="w-full bg-surface-bright border border-outline-variant/50 rounded-lg py-3 px-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary-container transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
