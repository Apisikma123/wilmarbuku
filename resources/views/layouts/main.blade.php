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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.14/dist/dotlottie-wc.js" type="module"></script>
    <script id="tailwind-config">tailwind.config = {darkMode: "class", theme: {extend: {colors: {"on-tertiary": "#ffffff", "tertiary-fixed-dim": "#69d9c0", "surface-bright": "#f8f9ff", "outline-variant": "#c0c9be", "on-secondary-fixed": "#271900", "on-surface": "#121c29", "surface-dim": "#d0dbed", primary: "#003215", "on-tertiary-fixed-variant": "#005143", "tertiary-fixed": "#87f6dc", "on-primary-fixed-variant": "#0b5229", "inverse-surface": "#27313f", "error-container": "#ffdad6", error: "#ba1a1a", "primary-fixed": "#aef2bb", surface: "#f8f9ff", "on-surface-variant": "#404941", "on-secondary-container": "#715000", "surface-tint": "#2a6a3f", "surface-container-low": "#eff4ff", "surface-container": "#e6eeff", outline: "#707970", "tertiary-container": "#00493d", "secondary-container": "#fdc34d", "on-primary-container": "#79bb87", "surface-container-highest": "#d9e3f6", "on-error": "#ffffff", "secondary-fixed-dim": "#f7bd48", "on-background": "#121c29", "surface-container-high": "#dfe9fb", "surface-container-lowest": "#ffffff", background: "#f8f9ff", secondary: "#7b5800", "on-primary-fixed": "#00210c", "surface-variant": "#d9e3f6", "on-tertiary-container": "#4bbea5", "on-secondary-fixed-variant": "#5d4200", "primary-container": "#004b23", "on-primary": "#ffffff", tertiary: "#003128", "primary-fixed-dim": "#93d6a0", "on-error-container": "#93000a", "inverse-primary": "#93d6a0", "secondary-fixed": "#ffdea6", "on-secondary": "#ffffff", "inverse-on-surface": "#eaf1ff", "on-tertiary-fixed": "#00201a"}, borderRadius: {DEFAULT: "0.5rem", lg: "1rem", xl: "1.5rem", full: "9999px"}, spacing: {}, fontFamily: {headline: ["Poppins"], display: ["Poppins"], body: ["Poppins"], label: ["Poppins"]}, fontSize: {}}}};</script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px -4px rgba(0, 50, 21, 0.1);
        }
        .book-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 10px 0px 15px -3px rgba(0,0,0,0.1) inset;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex flex-col font-sans selection:bg-primary selection:text-white">

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 z-[9999] bg-[#F8FAFC] flex flex-col items-center justify-center transition-all duration-700 ease-in-out">
        <dotlottie-wc src="https://lottie.host/2d5c7c63-ff45-4c14-9996-735ccba19274/c09TN00OAQ.lottie" style="width: 120px; height: 120px;" autoplay loop></dotlottie-wc>
        <p class="text-primary font-semibold text-xs tracking-[0.2em] mt-2 animate-pulse">MEMUAT</p>
    </div>

    <!-- Navigation -->
    <header class="bg-surface/90 backdrop-blur-md border-b border-outline-variant/30 fixed top-0 left-0 w-full z-50">
        <div class="flex justify-between items-center px-6 md:px-12 xl:px-24 h-20 w-full">
            <div class="flex items-center gap-4">
                <a href="/">
                    <img src="/images/wil.png" alt="WilmarBOOKS" class="h-10 object-contain bg-white px-3 py-1.5 rounded-lg shadow-sm">
                </a>
            </div>
            <nav class="hidden md:flex gap-8">
                <a class="font-medium hover:text-primary transition-colors text-sm uppercase tracking-wider {{ request()->is('/') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant' }}" href="/">Donasi</a>
                <a class="font-medium hover:text-primary transition-colors text-sm uppercase tracking-wider {{ request()->is('track') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant' }}" href="/track">Lacak Status</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="{{ Auth::check() ? url('/cart') : route('login') }}" class="hidden md:block bg-primary text-on-primary text-sm font-semibold px-6 py-2.5 rounded-md hover:bg-primary-container transition-colors shadow-sm">Donasi Sekarang</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
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
                    <h3 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">TAUTAN CEPAT</h3>
                    <ul class="space-y-4">
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/tentang-kami">Tentang Kami</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/panduan-donasi">Panduan Donasi</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/">Buku Donasi</a></li>
                    </ul>
                </div>
                <!-- Column 3: Informasi -->
                <div>
                    <h3 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">INFORMASI</h3>
                    <ul class="space-y-4">
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/kebijakan-privasi">Kebijakan Privasi</a></li>
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/faq">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-white/50">© {{ date('Y') }} Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.</p>
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

        // Mobile menu toggle
        const btn = document.querySelector('button.md\\:hidden');
        if (btn) {
            btn.addEventListener('click', () => {
                alert('Menu navigasi diklik (Mockup)');
            });
        }

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
