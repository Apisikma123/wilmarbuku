@extends('layouts.main')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1400px] mx-auto py-12 flex flex-col md:flex-row gap-10">
    
    <!-- Sidebar / Filters -->
    <aside class="w-full md:w-64 flex-shrink-0">
        <h2 class="text-xl font-bold text-on-surface mb-4">Cari Buku</h2>
        
        <!-- Search -->
        <div class="relative mb-8">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant">search</span>
            <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-surface-bright border border-outline-variant rounded-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm" placeholder="Judul atau Penulis...">
        </div>

        <!-- Categories -->
        <div class="mb-8">
            <h3 class="text-sm font-bold text-primary mb-4 uppercase tracking-widest">KATEGORI</h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Pendidikan</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Novel</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Komik</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Bisnis</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Teknologi</span>
                </label>
            </div>
        </div>

        <!-- Status -->
        <div>
            <h3 class="text-sm font-bold text-primary mb-4 uppercase tracking-widest">STATUS</h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Tersedia</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">DiDonasi</span>
                </label>
            </div>
        </div>
    </aside>

    <!-- Main Catalog Area -->
    <div class="flex-grow">
        <h1 class="text-3xl md:text-4xl font-bold text-primary mb-8 tracking-tight">Pilihan Buku Donasi</h1>
        
        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Book 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow flex flex-col p-4 group">
                <div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-lg bg-gradient-to-br from-[#003215] to-[#004b23] flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-white text-primary text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">Bisnis</span>
                    </div>
                    <div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
                        <span class="material-symbols-outlined text-4xl opacity-80 font-light">account_balance</span>
                        <h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Manajemen<br/>Modern</h3>
                        <div class="w-12 h-[2px] bg-[#fdc34d] mx-auto mt-2 rounded-full"></div>
                    </div>
                    <div class="mt-auto text-center opacity-70 text-[9px] tracking-widest uppercase">Prof. Dr. Budi Setiawan</div>
                </div>
                
                <h3 class="font-bold text-lg text-on-surface mb-1 leading-tight group-hover:text-primary transition-colors line-clamp-2">Manajemen Modern & Strategi Inovasi</h3>
                <p class="text-sm text-on-surface-variant mb-2">Oleh Dr. Andi Setiawan</p>
                <p class="text-primary font-bold text-lg mb-4">Rp 150.000</p>
                
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-outline-variant/20">
                    <div class="flex items-center gap-1 text-primary">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span class="text-xs font-bold">Tersedia</span>
                    </div>
                    <a href="/login" class="bg-primary text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-primary-container transition-colors shadow-sm">Donasi</a>
                </div>
            </div>

            <!-- Book 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow flex flex-col p-4 group">
                <div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-lg bg-gradient-to-br from-slate-800 to-slate-900 flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-white text-slate-800 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">Teknologi</span>
                    </div>
                    <div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
                        <span class="material-symbols-outlined text-4xl text-cyan-400 opacity-80 font-light">neurology</span>
                        <h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Artificial<br/>Intelligence</h3>
                        <div class="w-12 h-[2px] bg-cyan-400 mx-auto mt-2 rounded-full"></div>
                    </div>
                    <div class="mt-auto text-center opacity-70 text-[9px] tracking-widest uppercase">Dr. Elly Yuli</div>
                </div>
                
                <h3 class="font-bold text-lg text-on-surface mb-1 leading-tight group-hover:text-primary transition-colors line-clamp-2">Pengantar Kecerdasan Buatan Terapan</h3>
                <p class="text-sm text-on-surface-variant mb-2">Oleh Budi Pratama, M.Kom</p>
                <p class="text-primary font-bold text-lg mb-4">Rp 125.000</p>
                
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-outline-variant/20">
                    <div class="flex items-center gap-1 text-red-600">
                        <span class="material-symbols-outlined text-[18px]">schedule</span>
                        <span class="text-xs font-bold">Sedang Didonasi</span>
                    </div>
                    <a href="/login" class="bg-surface-container-high text-on-surface-variant text-sm font-semibold px-4 py-2 rounded-md hover:bg-surface-container-highest transition-colors shadow-sm">Detail</a>
                </div>
            </div>

            <!-- Book 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow flex flex-col p-4 group">
                <div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-lg bg-gradient-to-br from-zinc-200 to-stone-300 flex flex-col p-6 text-zinc-900 border border-black/10 shadow-[inset_4px_0_12px_rgba(0,0,0,0.1)]">
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">Pendidikan</span>
                    </div>
                    <div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
                        <span class="material-symbols-outlined text-4xl opacity-80 font-light">school</span>
                        <h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase text-primary">Entrepreneurship</h3>
                        <div class="w-12 h-[2px] bg-primary mx-auto mt-2 rounded-full"></div>
                    </div>
                    <div class="mt-auto text-center opacity-70 text-[9px] tracking-widest uppercase font-bold text-primary">Academic Edition</div>
                </div>
                
                <h3 class="font-bold text-lg text-on-surface mb-1 leading-tight group-hover:text-primary transition-colors line-clamp-2">Dasar Kewirausahaan Berkelanjutan</h3>
                <p class="text-sm text-on-surface-variant mb-2">Oleh Siti Rahayu</p>
                <p class="text-primary font-bold text-lg mb-4">Rp 85.000</p>
                
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-outline-variant/20">
                    <div class="flex items-center gap-1 text-primary">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span class="text-xs font-bold">Tersedia</span>
                    </div>
                    <a href="/login" class="bg-primary text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-primary-container transition-colors shadow-sm">Donasi</a>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center gap-2">
                <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant/50 text-on-surface-variant hover:bg-surface-container-low transition-colors disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded bg-primary text-white font-semibold shadow-sm">1</button>
                <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant/50 text-on-surface hover:bg-surface-container-low transition-colors font-medium">2</button>
                <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant/50 text-on-surface hover:bg-surface-container-low transition-colors font-medium">3</button>
                <span class="w-10 h-10 flex items-center justify-center text-on-surface-variant">...</span>
                <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant/50 text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </nav>
        </div>

    </div>
</div>
@endsection
