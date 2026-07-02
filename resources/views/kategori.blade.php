@extends('layouts.user')

@section('content')
<div class="bg-gradient-to-b from-primary to-[#004b23] relative text-white py-12 md:py-20">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-5xl font-bold font-display uppercase tracking-tight mb-4">Jelajahi Kategori</h1>
        <p class="text-white/80 max-w-xl mx-auto text-sm md:text-base">Temukan ratusan buku menarik dari berbagai kategori untuk mendukung literasi dan perkuliahan Anda.</p>
    </div>
</div>



<div class="max-w-[1280px] mx-auto px-4 md:px-6 py-12">
    <!-- Filters & Results -->
    <div class="flex flex-col md:flex-row gap-10">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-5 sticky top-24">
                <h2 class="text-lg font-bold text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">filter_alt</span> Filter
                </h2>
                
                <!-- Categories -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">KATEGORI</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" checked class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">E-Book Eksklusif</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Buku Donasi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Jurnal Akademik</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Modul Kuliah</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Sains & Teknologi</span>
                        </label>
                    </div>
                </div>

                <!-- Penerbit -->
                <div>
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">PENERBIT</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Erlangga</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Gramedia</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-primary mb-1">Hasil Pencarian</h2>
                    <p class="text-sm text-on-surface-variant">Menampilkan 1-12 dari 45 buku dalam kategori ini.</p>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <label class="text-sm text-on-surface-variant">Urutkan:</label>
                    <select class="bg-white border border-outline-variant rounded-lg px-3 py-1.5 text-sm outline-none focus:border-primary">
                        <option>Terbaru</option>
                        <option>Terpopuler</option>
                        <option>Harga: Rendah ke Tinggi</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Book Item 1 -->
                <a href="/buku?id=2" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                        <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight text-cyan-400">Artificial<br>Intelligence</h4>
                    </div>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="bg-secondary/10 text-secondary text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1.5 inline-block">Teknologi</span>
                            <h3 class="text-xs md:text-sm font-bold text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">Pengantar Kecerdasan Buatan Terapan</h3>
                            <p class="text-[10px] text-on-surface-variant mb-2">Budi P., M.Kom</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto pt-3 border-t border-outline-variant/20">
                            <div>
                                <p class="text-primary font-bold text-sm md:text-base">Rp 125.000</p>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </a>

                <!-- Book Item 2 -->
                <a href="/buku?id=1" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-[#003215] to-[#004b23] rounded-lg mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                        <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight">Manajemen<br>Modern</h4>
                    </div>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="bg-secondary/10 text-secondary text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1.5 inline-block">Bisnis</span>
                            <h3 class="text-xs md:text-sm font-bold text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">Manajemen Modern & Strategi Inovasi</h3>
                            <p class="text-[10px] text-on-surface-variant mb-2">Dr. Andi S.</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto pt-3 border-t border-outline-variant/20">
                            <div>
                                <p class="text-primary font-bold text-sm md:text-base">Rp 150.000</p>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </a>
                
                <!-- Book Item 3 -->
                <a href="/buku?id=4" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-zinc-200 to-stone-300 rounded-lg mb-3 flex items-center justify-center p-2 text-center text-primary relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                        <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight">Dasar<br>Kewirausahaan</h4>
                    </div>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="bg-secondary/10 text-secondary text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1.5 inline-block">Bisnis</span>
                            <h3 class="text-xs md:text-sm font-bold text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">Dasar Kewirausahaan Berkelanjutan</h3>
                            <p class="text-[10px] text-on-surface-variant mb-2">Siti Rahayu</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto pt-3 border-t border-outline-variant/20">
                            <div>
                                <p class="text-primary font-bold text-sm md:text-base">Rp 95.000</p>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center gap-2">
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/50 text-on-surface-variant hover:bg-surface-container-low transition-colors disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-semibold shadow-sm">1</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/50 text-on-surface hover:bg-surface-container-low transition-colors font-medium">2</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/50 text-on-surface hover:bg-surface-container-low transition-colors font-medium">3</button>
                    <span class="w-10 h-10 flex items-center justify-center text-on-surface-variant">...</span>
                    <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/50 text-on-surface-variant hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </nav>
            </div>

        </div>
    </div>
</div>
@endsection
