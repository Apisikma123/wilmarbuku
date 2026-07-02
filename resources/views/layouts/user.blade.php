<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WilmarBOOKS</title>
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
        /* SweetAlert2 Theme Overrides based on DESIGN.md */
        div:where(.swal2-container) div:where(.swal2-popup) { font-family: 'Poppins', sans-serif; border-radius: 16px; }
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm { border-radius: 8px; font-weight: 600; background-color: #003215; }
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(0, 50, 21, 0.5); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.14/dist/dotlottie-wc.js" type="module"></script>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col overflow-x-hidden">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 z-[9999] bg-background flex flex-col items-center justify-center transition-all duration-700 ease-in-out">
        <dotlottie-wc src="https://lottie.host/2d5c7c63-ff45-4c14-9996-735ccba19274/c09TN00OAQ.lottie" style="width: 120px; height: 120px;" autoplay loop></dotlottie-wc>
        <p class="text-primary font-semibold text-xs tracking-[0.2em] mt-2 animate-pulse">MEMUAT</p>
    </div>

    <!-- Main Header -->
    <header class="bg-primary md:bg-white text-white md:text-on-surface shadow-sm relative z-50">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-2 md:py-4 flex flex-col md:flex-row md:items-center justify-between gap-2 md:gap-8">
            
            <div class="flex items-center justify-between w-full md:w-auto shrink-0">
                <!-- Hamburger and Logo -->
                <div class="flex items-center gap-3 md:gap-2">
                    <button class="md:hidden text-white flex items-center">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <a href="/dashboard" class="flex items-center gap-2">
                        <img src="/images/wil.png" alt="WilmarBOOKS" class="h-7 md:h-12 object-contain bg-white rounded px-2 py-1 md:bg-transparent md:p-0 md:rounded-none">
                    </a>
                </div>
                
                <div class="flex md:hidden items-center gap-4">
                    <a href="/cart" class="text-white hover:text-white/80 relative cursor-pointer active:scale-95 transition-transform">
                        <span class="material-symbols-outlined text-xl">shopping_cart</span>
                        <span class="absolute -top-1 -right-1 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-primary shadow-sm">3</span>
                    </a>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="w-full md:flex-grow md:w-auto max-w-none md:max-w-3xl relative mt-3 md:mt-0 pb-1 md:pb-0">
                <div class="bg-white md:bg-surface-bright border md:border-outline-variant/50 rounded flex items-center overflow-hidden h-10 md:h-12 shadow-sm md:shadow-none">
                    <span class="material-symbols-outlined text-outline-variant px-3 text-gray-400 md:text-gray-500">search</span>
                    <input type="text" class="w-full bg-transparent border-none focus:ring-0 text-sm md:text-base text-gray-800 md:text-on-surface placeholder-gray-400 h-full" placeholder="Cari Judul Buku atau Penulis...">
                    <button class="hidden md:block bg-primary-container text-white text-xs font-bold px-6 h-full hover:bg-primary transition-colors">CARI</button>
                </div>
            </div>
            
            <!-- User Actions Desktop -->
            <div class="hidden md:flex items-center gap-6 ml-auto">
                <a href="/cart" class="text-on-surface-variant hover:text-primary relative cursor-pointer active:scale-95 transition-transform">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span class="absolute -top-1.5 -right-1.5 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-sm">3</span>
                </a>
                <a href="/akun" class="flex items-center gap-3 border-l border-outline-variant/30 pl-6 cursor-pointer group">
                    <div class="w-8 h-8 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold text-sm">
                        WS
                    </div>
                    <div>
                        <p class="text-xs text-on-surface-variant group-hover:text-primary leading-tight">Halo,</p>
                        <p class="text-sm font-bold text-on-surface leading-tight">Wira Santoso</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Sub Navigation Desktop -->
        <div class="hidden md:block bg-surface-container-low border-b border-outline-variant/30">
            <div class="max-w-[1280px] mx-auto px-6 py-3 flex items-center gap-8 text-sm overflow-x-auto hide-scroll text-on-surface-variant font-medium">
                <a href="/dashboard" class="flex items-center gap-2 font-bold text-on-surface hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-lg">home</span> Beranda
                </a>
                <a href="/kategori" class="flex items-center gap-2 font-bold text-primary hover:text-primary/80 transition-colors">
                    <span class="material-symbols-outlined text-lg">grid_view</span> Kategori
                </a>
                <a href="/kategori?filter=terbaru" class="hover:text-primary transition-colors whitespace-nowrap">Buku Terbaru</a>
                <a href="/kategori?filter=bestseller" class="hover:text-primary transition-colors whitespace-nowrap">Bestseller Donasi</a>
                <a href="/kategori?filter=event" class="hover:text-primary transition-colors whitespace-nowrap">Event Literasi</a>
                <a href="/kategori?filter=koleksi" class="hover:text-primary transition-colors whitespace-nowrap">Koleksi WBI</a>
                <a href="/kategori?filter=startup" class="hover:text-primary transition-colors whitespace-nowrap">Startup & Bisnis</a>
                <a href="/kategori?filter=pertanian" class="hover:text-primary transition-colors whitespace-nowrap">Pertanian Modern</a>
            </div>
        </div>
    </header>

    <!-- Bottom Navigation Mobile -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-outline-variant/30 z-[100] flex justify-between items-center px-6 py-2 pb-safe text-[10px] font-medium text-on-surface-variant shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <a href="/dashboard" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined text-xl">home</span>
            <span>Beranda</span>
        </a>

        <a href="/transaksi" class="flex flex-col items-center gap-1 hover:text-primary">
            <span class="material-symbols-outlined text-xl">receipt_long</span>
            <span>Transaksi</span>
        </a>
        <a href="/akun" class="flex flex-col items-center gap-1 hover:text-primary">
            <span class="material-symbols-outlined text-xl">person</span>
            <span>Akun</span>
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary-container text-white w-full py-20 px-6 md:px-12 mt-auto border-t border-white/10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mb-16">
                <!-- Column 1: Brand Info -->
                <div class="space-y-6">
                    <a href="/" class="hover:opacity-90 transition-opacity inline-block">
                        <img src="/images/wil.png" alt="WilmarBOOKS" class="h-10 md:h-12 object-contain bg-white px-3 py-1.5 rounded-lg shadow-sm">
                    </a>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Platform donasi buku resmi Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs through literacy and accessible education.
                    </p>
                </div>
                <!-- Column 2: Tautan Cepat -->
                <div>
                    <h2 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">TAUTAN CEPAT</h2>
                    <ul class="space-y-4">
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/tentang-kami">Tentang Kami</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/panduan-donasi">Panduan Donasi</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/donasi">Buku Donasi</a></li>
                    </ul>
                </div>
                <!-- Column 3: Informasi -->
                <div>
                    <h2 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">INFORMASI</h2>
                    <ul class="space-y-4">
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/kebijakan-privasi">Kebijakan Privasi</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/faq">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-white/50">&copy; {{ date('Y') }} Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.</p>
                <div class="flex gap-8 text-xs text-white/50">
                    <a class="hover:text-white transition-colors" href="/terms">Terms of Service</a>
                    <a class="hover:text-white transition-colors" href="/cookie-policy">Cookie Policy</a>
                </div>
            </div>
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

        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.querySelector('button.md\\:hidden');
            if(btn) {
                btn.addEventListener('click', () => {
                    alert('Mobile menu clicked! (Mockup only)');
                });
            }
        });

        // Loading Overlay Logic
        window.addEventListener('load', function() {
            const loader = document.getElementById('loading-overlay');
            if (loader) {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500); 
                }, 800);
            }
        });
    </script>
</body>
</html>
