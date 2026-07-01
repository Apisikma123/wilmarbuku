@extends('layouts.user')

@section('content')

    <!-- Banner Section -->
    <div class="bg-gradient-to-b from-primary to-[#004b23] md:bg-[#004b23] relative">
        <!-- Subtle Pattern Background -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
        
        <div class="max-w-[1280px] mx-auto px-0 md:px-6 py-6 md:py-8 relative z-10">
            <div class="flex overflow-x-auto hide-scroll snap-x snap-mandatory gap-4 px-4 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-4">
                
                <!-- Hero Card 1 -->
                <div class="snap-center shrink-0 w-[85vw] sm:w-[60vw] md:w-auto md:min-w-[260px] lg:min-w-[280px] bg-gradient-to-b from-[#1E293B] to-[#0F172A] rounded-lg aspect-[4/3] md:aspect-[3/4] p-4 md:p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-1.5 mt-2 md:mt-4">
                        <span class="inline-block bg-secondary text-white text-[9px] md:text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-1 md:mb-2">Terlaris</span>
                        <h3 class="text-xl md:text-2xl font-bold font-display uppercase tracking-tight leading-tight">Mastering<br>Management</h3>
                        <p class="text-[10px] md:text-xs text-white/70">Tingkatkan Skill Kepemimpinan</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-[10px] md:text-sm font-semibold px-4 md:px-6 py-1.5 md:py-2 rounded-full hover:bg-white hover:text-slate-900 transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <!-- Hero Card 2 -->
                <div class="snap-center shrink-0 w-[85vw] sm:w-[60vw] md:w-auto md:min-w-[260px] lg:min-w-[280px] bg-gradient-to-b from-[#065F46] to-[#022C22] rounded-lg aspect-[4/3] md:aspect-[3/4] p-4 md:p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-1.5 mt-2 md:mt-4">
                        <span class="inline-block bg-yellow-400 text-black text-[9px] md:text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-1 md:mb-2">Spesial WBI</span>
                        <h3 class="text-xl md:text-2xl font-bold font-display uppercase tracking-tight leading-tight text-yellow-400">Agrikultur<br>Modern</h3>
                        <p class="text-[10px] md:text-xs text-white/70">Masa Depan Pertanian</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-[10px] md:text-sm font-semibold px-4 md:px-6 py-1.5 md:py-2 rounded-full hover:bg-white hover:text-[#065F46] transition-colors">Donasi Sekarang</button>
                    </div>
                </div>

                <!-- Hero Card 3 -->
                <div class="snap-center shrink-0 w-[85vw] sm:w-[60vw] md:w-auto md:min-w-[260px] lg:min-w-[280px] bg-gradient-to-b from-[#991B1B] to-[#450A0A] rounded-lg aspect-[4/3] md:aspect-[3/4] p-4 md:p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-1.5 mt-2 md:mt-4">
                        <span class="inline-block bg-white text-red-700 text-[9px] md:text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-1 md:mb-2">Baru Rilis</span>
                        <h3 class="text-xl md:text-2xl font-bold font-display uppercase tracking-tight leading-tight">Teknologi<br>AI Terapan</h3>
                        <p class="text-[10px] md:text-xs text-white/70">AI untuk Dunia Nyata</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-[10px] md:text-sm font-semibold px-4 md:px-6 py-1.5 md:py-2 rounded-full hover:bg-white hover:text-red-900 transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <!-- Hero Card 4 -->
                <div class="snap-center shrink-0 w-[85vw] sm:w-[60vw] md:w-auto md:min-w-[260px] lg:min-w-[280px] bg-gradient-to-b from-[#3730A3] to-[#1E1B4B] rounded-lg aspect-[4/3] md:aspect-[3/4] p-4 md:p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-1.5 mt-2 md:mt-4">
                        <span class="inline-block bg-cyan-400 text-indigo-900 text-[9px] md:text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-1 md:mb-2">Literasi 2024</span>
                        <h3 class="text-xl md:text-2xl font-bold font-display uppercase tracking-tight leading-tight text-cyan-200">Start-Up<br>Playbook</h3>
                        <p class="text-[10px] md:text-xs text-white/70">Panduan Praktis Founder</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-[10px] md:text-sm font-semibold px-4 md:px-6 py-1.5 md:py-2 rounded-full hover:bg-white hover:text-indigo-900 transition-colors">Donasi Sekarang</button>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Trust Bar -->
        <div class="bg-[#00210c]/40 backdrop-blur py-3 md:py-4 border-y border-white/10 overflow-x-auto hide-scroll">
            <div class="max-w-[1280px] mx-auto px-4 md:px-6 flex md:justify-center gap-6 md:gap-16 text-white/90 text-[10px] md:text-sm font-medium w-max md:w-auto">
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">verified_user</span> Transaksi Aman & Terenkripsi</div>
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">receipt_long</span> Transparansi Laporan 100%</div>
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">support_agent</span> Bantuan Customer Care 24/7</div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-grow max-w-[1280px] mx-auto w-full px-4 md:px-6 py-6 md:py-12 space-y-8 md:space-y-16 pb-24 md:pb-12">
        
        <!-- Quick Categories -->
        <div class="grid grid-cols-4 md:grid-cols-8 gap-3 md:gap-4">
            <!-- Icon 1 -->
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">volunteer_activism</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Buku<br>Donasi</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)] relative">
                    <span class="absolute -top-1.5 -right-1.5 md:-top-2 md:-right-2 bg-secondary text-white text-[8px] md:text-[9px] px-1.5 py-0.5 rounded font-bold">BARU</span>
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">devices</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">E-Book<br>Eksklusif</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">article</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Jurnal<br>Akademik</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">menu_book</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Modul<br>Kuliah</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">lightbulb</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Inspirasi<br>Bisnis</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">science</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Sains &<br>Teknologi</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">auto_stories</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Sastra &<br>Novel</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 md:gap-3 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">more_horiz</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Lihat<br>Semua</span>
            </a>
        </div>

        <!-- Split Layout (Pilihan Kampus & Kategori Terpopuler) -->
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Pilihan Kampus (Left - 60%) -->
            <div class="w-full lg:w-[60%]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">star</span> Pilihan Prioritas Kampus
                    </h2>
                    <a href="#" class="text-sm text-primary font-semibold border border-primary/20 px-4 py-1.5 rounded-full hover:bg-primary/5 transition-colors">Lihat Semua</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Book Item -->
                    <a href="/buku" class="bg-white rounded-lg shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-[#003215] to-[#004b23] rounded mb-3 flex items-center justify-center p-2 text-center text-white relative group overflow-hidden">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                            </div>
                            <h4 class="text-[9px] font-bold uppercase leading-tight">Manajemen<br>Modern</h4>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Manajemen Modern & Strategi Inovasi</h3>
                                <p class="text-[10px] text-on-surface-variant mb-2">Dr. Andi S.</p>
                            </div>
                            <p class="text-primary font-bold text-sm mt-auto">Rp 150.000</p>
                        </div>
                    </a>
                    <!-- Book Item -->
                    <a href="/buku?id=2" class="bg-white rounded-lg shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 to-slate-900 rounded mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                            </div>
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-cyan-400">Artificial<br>Intelligence</h4>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Pengantar Kecerdasan Buatan</h3>
                                <p class="text-[10px] text-on-surface-variant mb-2">Budi P., M.Kom</p>
                            </div>
                            <p class="text-primary font-bold text-sm mt-auto">Rp 125.000</p>
                        </div>
                    </a>
                    <!-- Book Item -->
                    <a href="/buku?id=3" class="bg-white rounded-lg shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-amber-700 to-orange-950 rounded mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                            </div>
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-amber-200">Senja di<br>Jakarta</h4>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Sastra: Senja di Jakarta Klasik</h3>
                                <p class="text-[10px] text-on-surface-variant mb-2">Mochtar Lubis</p>
                            </div>
                            <p class="text-primary font-bold text-sm mt-auto">Rp 85.000</p>
                        </div>
                    </a>
                    <!-- Book Item -->
                    <a href="/buku?id=4" class="bg-white rounded-lg shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-zinc-200 to-stone-300 rounded mb-3 flex items-center justify-center p-2 text-center text-primary relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                            </div>
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-primary">Dasar<br>Kewirausahaan</h4>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Dasar Kewirausahaan Berkelanjutan</h3>
                                <p class="text-[10px] text-on-surface-variant mb-2">Siti Rahayu</p>
                            </div>
                            <p class="text-primary font-bold text-sm mt-auto">Rp 95.000</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Kategori Terpopuler (Right - 40%) -->
            <div class="w-full lg:w-[40%]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">category</span> Partner Penerbit
                    </h2>
                    <a href="#" class="text-sm text-primary font-semibold border border-primary/20 px-4 py-1.5 rounded-full hover:bg-primary/5 transition-colors">Lihat Semua</a>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Publisher Brand -->
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">menu_book</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Erlangga</span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">import_contacts</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Gramedia</span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">school</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Andi Publ.</span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">science</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Informatika</span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">language</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Pearson</span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">workspace_premium</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary">Wiley</span>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Full Width Section (Buku Resmi & Akademik) -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">local_library</span> Referensi Resmi WBI
                    </h2>
                    <p class="text-sm text-on-surface-variant mt-1">Daftar buku wajib untuk mahasiswa semester berjalan.</p>
                </div>
                <a href="#" class="text-sm text-primary font-semibold border border-primary/20 px-4 py-1.5 rounded-full hover:bg-primary/5 transition-colors">Lihat Semua</a>
            </div>

            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/30">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <!-- Item -->
                    <a href="/buku?id=5" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-[#004b23] rounded mb-3"></div>
                        <div class="flex-grow flex flex-col">
                            <span class="bg-red-100 text-red-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1 self-start">Wajib Smst 1</span>
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Pengantar Bisnis Modern</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp 210.000</p>
                                <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.9 (120 Donasi)
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Item -->
                    <a href="/buku?id=6" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-slate-800 rounded mb-3"></div>
                        <div class="flex-grow flex flex-col">
                            <span class="bg-red-100 text-red-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1 self-start">Wajib Smst 3</span>
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Algoritma & Struktur Data</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp 185.000</p>
                                <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.8 (85 Donasi)
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Item -->
                    <a href="/buku?id=7" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-amber-800 rounded mb-3"></div>
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Akuntansi Manajerial</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp 320.000</p>
                                <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 5.0 (42 Donasi)
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Item -->
                    <a href="/buku?id=8" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-teal-800 rounded mb-3"></div>
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Ekonomi Makro Terapan</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp 190.000</p>
                                <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.7 (210 Donasi)
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Item -->
                    <a href="/buku?id=9" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] bg-indigo-900 rounded mb-3"></div>
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Sistem Informasi Bisnis</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp 250.000</p>
                                <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.9 (98 Donasi)
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Donasi Lagi Yuk Section -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-secondary">history</span> Donasi Lagi Yuk
                </h2>
                <a href="#" class="text-sm text-primary font-semibold border border-primary/20 px-4 py-1.5 rounded-full hover:bg-primary/5 transition-colors">Lihat Riwayat</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- History Item -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-outline-variant/30 flex gap-4 items-center">
                    <div class="w-12 aspect-[3/4] bg-slate-800 rounded flex-shrink-0"></div>
                    <div>
                        <h4 class="text-xs font-bold text-on-surface line-clamp-1">Kecerdasan Buatan</h4>
                        <p class="text-[10px] text-on-surface-variant">Donasi: 12 Jun 2024</p>
                        <button class="mt-2 text-[10px] font-bold text-primary border border-primary px-3 py-1 rounded hover:bg-primary/10 transition-colors">Donasi Lagi</button>
                    </div>
                </div>
                <!-- History Item -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-outline-variant/30 flex gap-4 items-center">
                    <div class="w-12 aspect-[3/4] bg-[#004b23] rounded flex-shrink-0"></div>
                    <div>
                        <h4 class="text-xs font-bold text-on-surface line-clamp-1">Manajemen Strategis</h4>
                        <p class="text-[10px] text-on-surface-variant">Donasi: 05 Jun 2024</p>
                        <button class="mt-2 text-[10px] font-bold text-primary border border-primary px-3 py-1 rounded hover:bg-primary/10 transition-colors">Donasi Lagi</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
