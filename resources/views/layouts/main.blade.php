<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>WilmarBOOKS</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#003215">
    <link rel="apple-touch-icon" href="/images/wil.png">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="hidden md:block border border-primary text-primary text-sm font-semibold px-6 py-2.5 rounded-md hover:bg-primary/10 transition-colors shadow-sm">Admin Dashboard</a>
                @endif
                <a href="{{ Auth::check() ? url('/cart') : route('login') }}" class="hidden md:block bg-primary text-on-primary text-sm font-semibold px-6 py-2.5 rounded-md hover:bg-primary-container transition-colors shadow-sm">Donasi Sekarang</a>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer-backdrop" class="fixed inset-0 bg-black/50 z-[100] opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>
    <aside id="mobile-drawer" class="fixed top-0 left-0 bottom-0 w-72 bg-white z-[110] transform -translate-x-full transition-transform duration-300 shadow-2xl md:hidden overflow-y-auto flex flex-col">
        <div class="p-4 border-b border-outline-variant/30 flex items-center justify-between sticky top-0 bg-white z-10">
            <img src="/images/wil.png" alt="WilmarBOOKS" class="h-8 object-contain">
            <button id="close-drawer" class="w-8 h-8 flex items-center justify-center rounded-full bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <div class="p-4 border-b border-outline-variant/20">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-3">Menu Utama</p>
            <nav class="space-y-1">
                <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-surface-container-low text-on-surface {{ request()->is('/') ? 'bg-primary/10 text-primary font-bold' : '' }}">
                    <span class="material-symbols-outlined text-[20px]">volunteer_activism</span> Donasi
                </a>
                <a href="/track" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-surface-container-low text-on-surface {{ request()->is('track') ? 'bg-primary/10 text-primary font-bold' : '' }}">
                    <span class="material-symbols-outlined text-[20px]">location_on</span> Lacak Status
                </a>
            </nav>
        </div>

        <div class="p-4 mt-auto">
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-surface-container-low text-primary font-bold py-3 rounded-xl hover:bg-surface-container-high transition-colors mb-3 border border-outline-variant/30">
                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span> Admin Dashboard
            </a>
            @endif
            <a href="{{ Auth::check() ? url('/cart') : route('login') }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold py-3 rounded-xl hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">volunteer_activism</span> Donasi Sekarang
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow pt-20 w-full">
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
            // SW registered
          }).catch(err => {
            // SW failed
          });
        });
      }

        // Smart Button Loading
        document.addEventListener('submit', function(e) {
            if (e.defaultPrevented) return;
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            
            if(btn && !btn.classList.contains('no-loading')) {
                if(btn.disabled) return;
                
                const originalText = btn.innerHTML;
                btn.dataset.originalText = originalText;
                
                setTimeout(() => {
                    if (!e.defaultPrevented) {
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px] align-middle mr-1">sync</span> Memproses...';
                    }
                }, 300);
            }
        });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.querySelector('button.md\\:hidden');
            const drawer = document.getElementById('mobile-drawer');
            const backdrop = document.getElementById('mobile-drawer-backdrop');
            const closeBtn = document.getElementById('close-drawer');
            
            function toggleDrawer() {
                if(!drawer || !backdrop) return;
                const isOpen = drawer.classList.contains('translate-x-0');
                if (isOpen) {
                    drawer.classList.remove('translate-x-0');
                    drawer.classList.add('-translate-x-full');
                    backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                } else {
                    drawer.classList.remove('-translate-x-full');
                    drawer.classList.add('translate-x-0');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-100', 'pointer-events-auto');
                }
            }

            if(btn) btn.addEventListener('click', toggleDrawer);
            if(closeBtn) closeBtn.addEventListener('click', toggleDrawer);
            if(backdrop) backdrop.addEventListener('click', toggleDrawer);
        });

    </script>
</body>
</html>
