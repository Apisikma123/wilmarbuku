<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WilmarBOOKS - Dashboard</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#003215">
    <link rel="apple-touch-icon" href="/images/wil.png">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">tailwind.config = {darkMode: "class", theme: {extend: {colors: {"on-tertiary": "#ffffff", "tertiary-fixed-dim": "#69d9c0", "surface-bright": "#f8f9ff", "outline-variant": "#c0c9be", "on-secondary-fixed": "#271900", "on-surface": "#121c29", "surface-dim": "#d0dbed", primary: "#003215", "on-tertiary-fixed-variant": "#005143", "tertiary-fixed": "#87f6dc", "on-primary-fixed-variant": "#0b5229", "inverse-surface": "#27313f", "error-container": "#ffdad6", error: "#ba1a1a", "primary-fixed": "#aef2bb", surface: "#f8f9ff", "on-surface-variant": "#404941", "on-secondary-container": "#715000", "surface-tint": "#2a6a3f", "surface-container-low": "#eff4ff", "surface-container": "#e6eeff", outline: "#707970", "tertiary-container": "#00493d", "secondary-container": "#fdc34d", "on-primary-container": "#79bb87", "surface-container-highest": "#d9e3f6", "on-error": "#ffffff", "secondary-fixed-dim": "#f7bd48", "on-background": "#121c29", "surface-container-high": "#dfe9fb", "surface-container-lowest": "#ffffff", background: "#f8f9ff", secondary: "#7b5800", "on-primary-fixed": "#00210c", "surface-variant": "#d9e3f6", "on-tertiary-container": "#4bbea5", "on-secondary-fixed-variant": "#5d4200", "primary-container": "#004b23", "on-primary": "#ffffff", tertiary: "#003128", "primary-fixed-dim": "#93d6a0", "on-error-container": "#93000a", "inverse-primary": "#93d6a0", "secondary-fixed": "#ffdea6", "on-secondary": "#ffffff", "inverse-on-surface": "#eaf1ff", "on-tertiary-fixed": "#00201a"}, borderRadius: {DEFAULT: "0.5rem", lg: "1rem", xl: "1.5rem", full: "9999px"}, spacing: {}, fontFamily: {headline: ["Poppins"], display: ["Poppins"], body: ["Poppins"], label: ["Poppins"]}, fontSize: {}}}};</script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .item-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">

    <!-- Main Header -->
    <header class="bg-primary text-white border-b border-white/10">
        <div class="max-w-[1280px] mx-auto px-6 py-4 flex items-center justify-between gap-8">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2">
                <img src="/images/wil.png" alt="WilmarBOOKS" class="h-8 md:h-10 object-contain">
                <span class="text-2xl font-bold tracking-tight hidden sm:block">WilmarBOOKS</span>
            </a>
            
            <!-- Search Bar -->
            <div class="flex-grow max-w-3xl relative">
                <div class="bg-white rounded-[4px] flex items-center overflow-hidden h-10 shadow-inner">
                    <span class="material-symbols-outlined text-outline-variant px-3">search</span>
                    <input type="text" class="w-full bg-transparent border-none focus:ring-0 text-sm text-on-surface placeholder-outline-variant h-full" placeholder="Cari Judul Buku, Penulis, atau Kategori Donasi...">
                    <button class="bg-[#eff4ff] text-primary text-xs font-bold px-4 h-full border-l border-outline-variant/30 hover:bg-[#dfe9fb] transition-colors">ENTER ↵</button>
                </div>
                <!-- Search Tags -->
                <div class="absolute -bottom-7 left-0 flex gap-2 text-[10px] text-white/70">
                    <span class="bg-white/10 px-2 py-0.5 rounded-sm">Manajemen</span>
                    <span class="bg-white/10 px-2 py-0.5 rounded-sm">Sastra</span>
                    <span class="bg-white/10 px-2 py-0.5 rounded-sm">IT & Komputer</span>
                    <span class="bg-white/10 px-2 py-0.5 rounded-sm">Bisnis</span>
                    <span class="bg-white/10 px-2 py-0.5 rounded-sm">Agrikultur</span>
                </div>
            </div>
            
            <!-- User Actions -->
            <div class="flex items-center gap-6">
                <a href="#" class="text-white/90 hover:text-white relative">
                    <span class="material-symbols-outlined">mail</span>
                </a>
                <a href="#" class="text-white/90 hover:text-white relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute -top-1.5 -right-1.5 bg-error text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">1</span>
                </a>
                <a href="#" class="text-white/90 hover:text-white relative">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span class="absolute -top-1.5 -right-1.5 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</span>
                </a>
                <div class="flex items-center gap-3 border-l border-white/20 pl-6 cursor-pointer group">
                    <div class="w-8 h-8 bg-surface-container-low text-primary rounded-full flex items-center justify-center font-bold text-sm">
                        WS
                    </div>
                    <div>
                        <p class="text-xs text-white/70 group-hover:text-white leading-tight">Halo,</p>
                        <p class="text-sm font-bold leading-tight">Wira Santoso</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sub Navigation -->
        <div class="max-w-[1280px] mx-auto px-6 py-3 flex items-center gap-8 text-sm overflow-x-auto hide-scroll text-white/90 font-medium">
            <a href="#" class="flex items-center gap-2 font-bold text-white hover:text-secondary-fixed transition-colors">
                <span class="material-symbols-outlined text-lg">grid_view</span> Kategori
            </a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Buku Terbaru</a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Bestseller Donasi</a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Event Literasi</a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Koleksi WBI</a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Startup & Bisnis</a>
            <a href="#" class="hover:text-secondary-fixed transition-colors whitespace-nowrap">Pertanian Modern</a>
        </div>
    </header>

    <!-- Banner Section -->
    <div class="bg-[#004b23] relative">
        <!-- Subtle Pattern Background -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
        
        <div class="max-w-[1280px] mx-auto px-6 py-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Hero Card 1 -->
                <div class="bg-gradient-to-b from-[#1E293B] to-[#0F172A] rounded-lg aspect-[3/4] p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-2 mt-4">
                        <span class="inline-block bg-secondary text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-2">Terlaris</span>
                        <h3 class="text-2xl font-bold font-display uppercase tracking-tight leading-tight">Mastering<br>Management</h3>
                        <p class="text-xs text-white/70">Tingkatkan Skill Kepemimpinan</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-white hover:text-slate-900 transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <!-- Hero Card 2 -->
                <div class="bg-gradient-to-b from-[#065F46] to-[#022C22] rounded-lg aspect-[3/4] p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-2 mt-4">
                        <span class="inline-block bg-yellow-400 text-black text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-2">Spesial WBI</span>
                        <h3 class="text-2xl font-bold font-display uppercase tracking-tight leading-tight text-yellow-400">Agrikultur<br>Modern</h3>
                        <p class="text-xs text-white/70">Masa Depan Pertanian</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-white hover:text-[#065F46] transition-colors">Donasi Sekarang</button>
                    </div>
                </div>

                <!-- Hero Card 3 -->
                <div class="bg-gradient-to-b from-[#991B1B] to-[#450A0A] rounded-lg aspect-[3/4] p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-2 mt-4">
                        <span class="inline-block bg-white text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-2">Baru Rilis</span>
                        <h3 class="text-2xl font-bold font-display uppercase tracking-tight leading-tight">Teknologi<br>AI Terapan</h3>
                        <p class="text-xs text-white/70">Revolusi Industri 4.0</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-white hover:text-red-900 transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <!-- Hero Card 4 -->
                <div class="bg-gradient-to-b from-[#3730A3] to-[#1E1B4B] rounded-lg aspect-[3/4] p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="relative z-20 text-center space-y-2 mt-4">
                        <span class="inline-block bg-cyan-400 text-indigo-900 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest shadow-sm mb-2">Literasi 2024</span>
                        <h3 class="text-2xl font-bold font-display uppercase tracking-tight leading-tight text-cyan-200">Start-Up<br>Playbook</h3>
                        <p class="text-xs text-white/70">Panduan Praktis Founder</p>
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <button class="bg-white/10 backdrop-blur border border-white/30 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-white hover:text-indigo-900 transition-colors">Donasi Sekarang</button>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Trust Bar -->
        <div class="bg-[#00210c]/40 backdrop-blur py-4 border-y border-white/10">
            <div class="max-w-[1280px] mx-auto px-6 flex justify-center gap-16 text-white/90 text-sm font-medium">
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-secondary-fixed">verified_user</span> Transaksi Aman & Terenkripsi</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-secondary-fixed">receipt_long</span> Transparansi Laporan 100%</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-secondary-fixed">support_agent</span> Bantuan Customer Care 24/7</div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="max-w-[1280px] mx-auto px-6 py-12 space-y-16">
        
        <!-- Quick Categories -->
        <div class="grid grid-cols-4 md:grid-cols-8 gap-4">
            <!-- Icon 1 -->
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">volunteer_activism</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Buku<br>Donasi</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md relative">
                    <span class="absolute -top-2 -right-2 bg-secondary text-white text-[9px] px-1.5 py-0.5 rounded font-bold">BARU</span>
                    <span class="material-symbols-outlined text-3xl text-primary">devices</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">E-Book<br>Eksklusif</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">article</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Jurnal<br>Akademik</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">menu_book</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Modul<br>Kuliah</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">lightbulb</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Inspirasi<br>Bisnis</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">science</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Sains &<br>Teknologi</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">auto_stories</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Sastra &<br>Novel</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-surface rounded-[20px] shadow-sm flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-md">
                    <span class="material-symbols-outlined text-3xl text-primary">more_horiz</span>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant text-center leading-tight">Lihat<br>Semua</span>
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
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-3 hover:shadow-md transition-shadow">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-[#003215] to-[#004b23] rounded mb-3 flex items-center justify-center p-2 text-center text-white border border-black/5">
                            <h4 class="text-[9px] font-bold uppercase leading-tight">Manajemen<br>Modern</h4>
                        </div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Manajemen Modern & Strategi Inovasi</h3>
                        <p class="text-[10px] text-on-surface-variant mb-2">Dr. Andi S.</p>
                        <p class="text-primary font-bold text-sm">Rp 150.000</p>
                    </div>
                    <!-- Book Item -->
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-3 hover:shadow-md transition-shadow">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 to-slate-900 rounded mb-3 flex items-center justify-center p-2 text-center text-white border border-black/5">
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-cyan-400">Artificial<br>Intelligence</h4>
                        </div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Pengantar Kecerdasan Buatan</h3>
                        <p class="text-[10px] text-on-surface-variant mb-2">Budi P., M.Kom</p>
                        <p class="text-primary font-bold text-sm">Rp 125.000</p>
                    </div>
                    <!-- Book Item -->
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-3 hover:shadow-md transition-shadow">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-amber-700 to-orange-950 rounded mb-3 flex items-center justify-center p-2 text-center text-white border border-black/5">
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-amber-200">Senja di<br>Jakarta</h4>
                        </div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Sastra: Senja di Jakarta Klasik</h3>
                        <p class="text-[10px] text-on-surface-variant mb-2">Mochtar Lubis</p>
                        <p class="text-primary font-bold text-sm">Rp 85.000</p>
                    </div>
                    <!-- Book Item -->
                    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-3 hover:shadow-md transition-shadow">
                        <div class="w-full aspect-[3/4] bg-gradient-to-br from-zinc-200 to-stone-300 rounded mb-3 flex items-center justify-center p-2 text-center text-primary border border-black/5">
                            <h4 class="text-[9px] font-bold uppercase leading-tight text-primary">Dasar<br>Kewirausahaan</h4>
                        </div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Dasar Kewirausahaan Berkelanjutan</h3>
                        <p class="text-[10px] text-on-surface-variant mb-2">Siti Rahayu</p>
                        <p class="text-primary font-bold text-sm">Rp 95.000</p>
                    </div>
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
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-outline-variant/20 item-card transition-all cursor-pointer">
                        <div class="w-full aspect-[3/4] bg-[#004b23] rounded mb-3"></div>
                        <span class="bg-red-100 text-red-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1 inline-block">Wajib Smst 1</span>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Pengantar Bisnis Modern</h3>
                        <p class="text-primary font-bold text-sm">Rp 210.000</p>
                        <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.9 (120 Donasi)
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-outline-variant/20 item-card transition-all cursor-pointer">
                        <div class="w-full aspect-[3/4] bg-slate-800 rounded mb-3"></div>
                        <span class="bg-red-100 text-red-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1 inline-block">Wajib Smst 3</span>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Algoritma & Struktur Data</h3>
                        <p class="text-primary font-bold text-sm">Rp 185.000</p>
                        <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.8 (85 Donasi)
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-outline-variant/20 item-card transition-all cursor-pointer">
                        <div class="w-full aspect-[3/4] bg-amber-800 rounded mb-3"></div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Akuntansi Manajerial</h3>
                        <p class="text-primary font-bold text-sm">Rp 320.000</p>
                        <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 5.0 (42 Donasi)
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-outline-variant/20 item-card transition-all cursor-pointer">
                        <div class="w-full aspect-[3/4] bg-teal-800 rounded mb-3"></div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Ekonomi Makro Terapan</h3>
                        <p class="text-primary font-bold text-sm">Rp 190.000</p>
                        <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.7 (210 Donasi)
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-outline-variant/20 item-card transition-all cursor-pointer">
                        <div class="w-full aspect-[3/4] bg-indigo-900 rounded mb-3"></div>
                        <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">Sistem Informasi Bisnis</h3>
                        <p class="text-primary font-bold text-sm">Rp 250.000</p>
                        <div class="flex items-center gap-1 text-[9px] text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[12px] text-secondary">star</span> 4.9 (98 Donasi)
                        </div>
                    </div>
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

    </main>

    <!-- Footer Simple -->
    <footer class="bg-primary text-white/80 py-8 border-t border-white/10 mt-12">
        <div class="max-w-[1280px] mx-auto px-6 text-center text-sm">
            <p>&copy; 2024 Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.</p>
        </div>
    </footer>

    <!-- PWA Service Worker -->
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator.serviceWorker.register('/sw.js').then(reg => {
            console.log('SW registered!', reg);
          }).catch(err => console.log('SW registration failed', err));
        });
      }
    </script>
</body>
</html>
