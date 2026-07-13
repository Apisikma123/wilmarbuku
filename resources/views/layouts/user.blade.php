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
    @if(!View::hasSection('hide_header'))

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="bg-slate-900 text-white px-4 py-2 flex items-center justify-between z-[100] relative text-xs shrink-0">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[16px] text-green-400">admin_panel_settings</span>
            <span class="font-bold tracking-wide">Viewing as Admin</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-green-400 hover:text-green-300 hover:bg-white/20 transition-colors flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-full">
            Back to Admin Dashboard <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>
    @endif


    <!-- Main Header -->
    <header class="bg-primary md:bg-white text-white md:text-on-surface shadow-sm relative z-50">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-2 md:py-4 flex flex-col md:flex-row md:items-center justify-between gap-2 md:gap-8">
            
            <div class="flex items-center justify-between w-full md:w-auto shrink-0">
                <!-- Hamburger and Logo -->
                <div class="flex items-center gap-3 md:gap-2">
                    <button class="md:hidden text-white flex items-center">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <a href="/dashboard" class="hidden md:flex items-center gap-2">
                        <img src="/images/wil.png" alt="WilmarBOOKS" class="h-7 md:h-12 object-contain bg-white rounded px-2 py-1 md:bg-transparent md:p-0 md:rounded-none">
                    </a>
                </div>
                
                @php
                    $cartQty = 0;
                    $unreadPesan = 0;
                    $currentCart = Auth::check() ? (Auth::user()->cart_data ?? []) : [];
                    if($currentCart) {
                        foreach($currentCart as $c) {
                            $cartQty += $c['qty'];
                        }
                    }
                    if(Auth::check()) {
                        $unreadPesan = \App\Models\PesanMasuk::where('user_id', Auth::id())->where('is_read', false)->count();
                    }
                @endphp

                <div class="flex md:hidden items-center gap-4">
                    @if(auth()->check())
                    <a href="/pesan-masuk" class="text-white hover:text-white/80 relative cursor-pointer active:scale-95 transition-transform">
                        <span class="material-symbols-outlined text-xl">mail</span>
                        @if($unreadPesan > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-sm">{{ $unreadPesan }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <a href="/cart" class="text-white hover:text-white/80 relative cursor-pointer active:scale-95 transition-transform">
                        <span class="material-symbols-outlined text-xl">shopping_cart</span>
                        @if($cartQty > 0)
                        <span class="absolute -top-1 -right-1 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-primary shadow-sm">{{ $cartQty }}</span>
                        @endif
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Search Bar -->
            <div id="global-search-container" class="w-full md:flex-grow md:w-auto max-w-none md:max-w-3xl relative mt-3 md:mt-0 pb-1 md:pb-0">
                <form action="/kategori" method="GET" class="bg-white md:bg-surface-bright border md:border-outline-variant/50 rounded flex items-center overflow-hidden h-10 md:h-12 shadow-sm md:shadow-none relative z-10">
                    <span class="material-symbols-outlined text-outline-variant px-3 text-gray-400 md:text-gray-500">search</span>
                    <input type="text" name="search" id="global-search-input" autocomplete="off" value="{{ request('search') }}" class="w-full bg-transparent border-none focus:ring-0 text-sm md:text-base text-gray-800 md:text-on-surface placeholder-gray-400 h-full" placeholder="Cari Judul Buku atau Penulis...">
                    <button type="submit" class="hidden md:block bg-primary-container text-white text-xs font-bold px-6 h-full hover:bg-primary transition-colors">CARI</button>
                </form>
                
                <!-- Search Dropdown -->
                <div id="global-search-dropdown" class="absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible transition-all duration-200 transform translate-y-[-10px] z-[100] max-h-[500px] overflow-y-auto hidden">
                    <div id="global-search-results" class="py-2"></div>
                </div>
            </div>
            
            <!-- User Actions Desktop -->
            <div class="hidden md:flex items-center gap-6 ml-auto">
                @if(auth()->check())
                <a href="/pesan-masuk" class="text-on-surface-variant hover:text-primary relative cursor-pointer active:scale-95 transition-transform">
                    <span class="material-symbols-outlined">mail</span>
                    @if($unreadPesan > 0)
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-sm">{{ $unreadPesan }}</span>
                    @endif
                </a>
                @endif

                @if(!auth()->check() || auth()->user()->role !== 'admin')
                <a href="/cart" class="text-on-surface-variant hover:text-primary relative cursor-pointer active:scale-95 transition-transform">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    @if($cartQty > 0)
                    <span class="absolute -top-1.5 -right-1.5 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-sm">{{ $cartQty }}</span>
                    @endif
                </a>
                @endif
                @auth
                <div class="relative group pt-4 pb-4">
                    <a href="/akun" class="flex items-center gap-3 border-l border-outline-variant/30 pl-6 cursor-pointer">
                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold text-sm uppercase">
                            {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant group-hover:text-primary leading-tight transition-colors">Halo,</p>
                            <p class="text-sm font-bold text-on-surface leading-tight group-hover:text-primary transition-colors">{{ Auth::user()->nama_lengkap }}</p>
                        </div>
                    </a>

                    <!-- Hover Dropdown Menu -->
                    <div class="absolute right-0 top-full w-[400px] bg-surface rounded-2xl shadow-xl border border-outline-variant/30 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] transform origin-top group-hover:translate-y-0 -translate-y-2 pointer-events-none group-hover:pointer-events-auto">
                        
                        <!-- User Info Header -->
                        <div class="bg-primary text-white p-4 rounded-t-2xl relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                            <div class="flex items-center justify-between relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-white text-primary rounded-full flex items-center justify-center font-bold text-lg border-2 border-primary-fixed uppercase">
                                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-base leading-tight">{{ Auth::user()->nama_lengkap }}</h4>
                                            <a href="/akun" class="material-symbols-outlined text-[14px] cursor-pointer hover:text-secondary-fixed transition-colors" title="Edit Profil">edit</a>
                                        </div>
                                        <p class="text-xs text-white/80 mt-0.5">{{ Auth::user()->role == 'user_internal' ? 'Internal WBI' : 'Donatur Umum' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="p-4 border-b border-outline-variant/20 bg-surface-container-lowest">
                            <div class="flex justify-between items-center mb-3">
                                <h5 class="text-sm font-bold text-on-surface">Riwayat Transaksi</h5>
                                <a href="/transaksi" class="text-xs font-bold text-primary hover:text-primary/80 flex items-center group/link2">Lihat Semua <span class="material-symbols-outlined text-[14px] group-hover/link2:translate-x-1 transition-transform">chevron_right</span></a>
                            </div>
                            @php
                                $unreadTrx = \App\Models\TransaksiCheckout::where('user_id', Auth::id())
                                    ->where('is_read_by_user', false)
                                    ->get();
                                    
                                $countMenunggu = $unreadTrx->whereIn('status_tracking', ['Menunggu Pembayaran', 'Menunggu Konfirmasi'])->whereNotIn('status_pembayaran', ['Failed', 'Expired'])->count();
                                $countDana = $unreadTrx->where('status_tracking', 'Dana Diterima')->whereNotIn('status_pembayaran', ['Failed', 'Expired'])->count();
                                $countDikirim = $unreadTrx->where('status_tracking', 'Dalam Pengiriman')->whereNotIn('status_pembayaran', ['Failed', 'Expired'])->count();
                                $countSelesai = $unreadTrx->where('status_tracking', 'Selesai')->count();
                                $countBatal = $unreadTrx->where(function($q) {
                                    return $q->status_tracking == 'Dibatalkan' || $q->status_pembayaran == 'Failed';
                                })->count();
                            @endphp
                            <div class="flex justify-between px-2">
                                <a href="/transaksi?status=menunggu_konfirmasi" class="flex flex-col items-center gap-1.5 group/item">
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-outline group-hover/item:text-primary transition-colors text-2xl">assignment</span>
                                        @if($countMenunggu > 0)
                                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-error text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $countMenunggu }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-on-surface-variant font-medium leading-tight w-16 text-center">Menunggu Konfirmasi</span>
                                </a>
                                <a href="/transaksi?status=dana_diterima" class="flex flex-col items-center gap-1.5 group/item">
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-outline group-hover/item:text-primary transition-colors text-2xl">account_balance_wallet</span>
                                        @if($countDana > 0)
                                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-error text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $countDana }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-on-surface-variant font-medium leading-tight w-16 text-center">Dana Diterima</span>
                                </a>
                                <a href="/transaksi?status=sedang_dikirim" class="flex flex-col items-center gap-1.5 group/item">
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-outline group-hover/item:text-primary transition-colors text-2xl">local_shipping</span>
                                        @if($countDikirim > 0)
                                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-error text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $countDikirim }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-on-surface-variant font-medium leading-tight w-16 text-center">Sedang Dikirim</span>
                                </a>
                                <a href="/transaksi?status=selesai" class="flex flex-col items-center gap-1.5 group/item">
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-outline group-hover/item:text-primary transition-colors text-2xl">done_all</span>
                                        @if($countSelesai > 0)
                                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-error text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $countSelesai }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-on-surface-variant font-medium leading-tight w-16 text-center">Selesai</span>
                                </a>
                                <a href="/transaksi?status=dibatalkan" class="flex flex-col items-center gap-1.5 group/item">
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-outline group-hover/item:text-primary transition-colors text-2xl">cancel</span>
                                        @if($countBatal > 0)
                                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-error text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $countBatal }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-on-surface-variant font-medium leading-tight w-16 text-center">Dibatalkan</span>
                                </a>
                            </div>
                        </div>

                        <!-- Menu Links -->
                        <div class="py-2 bg-surface-container-lowest rounded-b-2xl shadow-[inset_0px_2px_4px_rgba(0,0,0,0.02)]">
                            <a href="/pesan-masuk" class="flex items-center gap-3 px-5 py-2.5 hover:bg-surface-container-low transition-colors text-on-surface group/link">
                                <span class="material-symbols-outlined text-outline group-hover/link:text-primary text-[20px] transition-colors">mail</span>
                                <span class="text-sm font-medium">Pesan Masuk</span>
                                @php
                                    $unread = \App\Models\PesanMasuk::where('user_id', Auth::id())->where('is_read', false)->count();
                                @endphp
                                @if($unread > 0)
                                <span class="ml-auto bg-error text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $unread }}</span>
                                @endif
                            </a>
                            <a href="/track" class="flex items-center gap-3 px-5 py-2.5 hover:bg-surface-container-low transition-colors text-on-surface group/link">
                                <span class="material-symbols-outlined text-outline group-hover/link:text-primary text-[20px] transition-colors">location_on</span>
                                <span class="text-sm font-medium">Lacak Donasi</span>
                            </a>
                            <div class="h-px bg-outline-variant/30 my-1 mx-4"></div>
                            <a href="/akun" class="flex items-center gap-3 px-5 py-2.5 hover:bg-surface-container-low transition-colors text-on-surface group/link">
                                <span class="material-symbols-outlined text-outline group-hover/link:text-primary text-[20px] transition-colors">settings</span>
                                <span class="text-sm font-medium">Pengaturan Akun</span>
                            </a>
                            <a href="/support" class="flex items-center gap-3 px-5 py-2.5 hover:bg-surface-container-low transition-colors text-on-surface group/link">
                                <span class="material-symbols-outlined text-outline group-hover/link:text-primary text-[20px] transition-colors">help</span>
                                <span class="text-sm font-medium">Support</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 hover:bg-error-container hover:text-error transition-colors text-on-surface group/link mt-1 text-left">
                                    <span class="material-symbols-outlined text-outline group-hover/link:text-error text-[20px] transition-colors">logout</span>
                                    <span class="text-sm font-bold">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3 pl-4 border-l border-outline-variant/30">
                    <a href="{{ route('login') }}" class="flex items-center gap-2 bg-[#003215] text-white font-bold py-2 px-5 rounded-lg hover:bg-[#004b23] transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">login</span> Masuk / Daftar
                    </a>
                </div>
                @endauth
            </div>
        </div>
        
        <!-- Sub Navigation Desktop -->
        <div class="hidden md:block bg-surface-container-low border-b border-outline-variant/30 relative">
            <div class="max-w-[1280px] mx-auto px-6 flex items-center gap-8 text-sm text-on-surface-variant font-medium">
                <a href="/dashboard" class="flex items-center gap-2 font-bold text-on-surface hover:text-primary transition-colors py-3">
                    <span class="material-symbols-outlined text-lg">home</span> Beranda
                </a>
                
                <div class="relative group h-full flex items-center">
                    <a href="/kategori" class="flex items-center gap-2 font-bold text-primary hover:text-primary/80 transition-colors py-3 cursor-pointer">
                        <span class="material-symbols-outlined text-lg">grid_view</span> Kategori
                        <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:rotate-180">expand_more</span>
                    </a>
                    
                    <div class="absolute top-full left-0 w-[560px] bg-white border border-outline-variant/30 shadow-[0_10px_40px_rgba(0,0,0,0.08)] opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-4 group-hover:translate-y-0 transition-all duration-300 z-[200] p-0 overflow-hidden">
                        <div class="grid grid-cols-2">
                            @foreach($global_kategoris as $cat)
                            <a href="{{ route('kategori', ['kategori' => [$cat->nama_kategori]]) }}" class="flex items-center justify-between px-5 py-3.5 border-b border-r border-outline-variant/10 hover:bg-[#F0F5FA] transition-colors group/item relative">
                                <span class="text-[14px] font-medium text-on-surface group-hover/item:text-primary transition-colors">{{ $cat->nama_kategori }}</span>
                                <span class="material-symbols-outlined text-[18px] text-outline-variant group-hover/item:text-primary transition-colors">chevron_right</span>
                                <!-- Hover indicator line like Itemku -->
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-8 overflow-x-auto hide-scroll flex-grow py-3">
                    <a href="/kategori?filter=bulan_ini" class="hover:text-primary transition-colors whitespace-nowrap">Buku Terbaru</a>
                    <a href="/kategori?filter=bestseller" class="hover:text-primary transition-colors whitespace-nowrap">Bestseller Donasi</a>
                    @foreach($global_kategoris->take(6) as $kategori)
                    <a href="{{ route('kategori', ['kategori' => [$kategori->nama_kategori]]) }}" class="hover:text-primary transition-colors whitespace-nowrap">{{ $kategori->nama_kategori }}</a>
                    @endforeach
                </div>
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
                <a href="/kategori" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-surface-container-low text-on-surface {{ request()->is('kategori') ? 'bg-primary/10 text-primary font-bold' : '' }}">
                    <span class="material-symbols-outlined text-[20px]">grid_view</span> Kategori Buku
                </a>
            </nav>
        </div>

        <div class="p-4 border-b border-outline-variant/20 flex-grow">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-3">Kategori Populer</p>
            <div class="space-y-1">
                @foreach($global_kategoris->take(5) as $cat)
                <a href="{{ route('kategori', ['kategori' => [$cat->nama_kategori]]) }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-on-surface hover:bg-surface-container-low group">
                    <span>{{ $cat->nama_kategori }}</span>
                    <span class="material-symbols-outlined text-[16px] text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                </a>
                @endforeach
            </div>
            <a href="/kategori" class="inline-block mt-3 text-xs font-bold text-primary hover:text-primary-container px-3">Lihat Semua Kategori &rarr;</a>
        </div>

        <div class="p-4 mt-auto">
            @if(auth()->check())
            <div class="bg-surface-container-low rounded-xl p-4 mb-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold text-base uppercase shrink-0">
                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-surface leading-tight">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="text-xs text-on-surface-variant">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-error/10 text-error rounded-lg text-sm font-bold hover:bg-error/20 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold py-3 rounded-xl hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">login</span> Masuk / Daftar
            </a>
            @endif
        </div>
    </aside>

    <!-- Bottom Navigation Mobile -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-outline-variant/30 z-[90] flex justify-between items-center px-6 py-2 pb-safe text-[10px] font-medium text-on-surface-variant shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <a href="/dashboard" class="flex flex-col items-center gap-1 {{ request()->is('dashboard') ? 'text-primary' : 'hover:text-primary' }}">
            <span class="material-symbols-outlined text-xl {{ request()->is('dashboard') ? 'fill-1' : '' }}">home</span>
            <span>Beranda</span>
        </a>

        <a href="/transaksi" class="flex flex-col items-center gap-1 {{ request()->is('transaksi*') ? 'text-primary' : 'hover:text-primary' }}">
            <span class="material-symbols-outlined text-xl {{ request()->is('transaksi*') ? 'fill-1' : '' }}">receipt_long</span>
            <span>Transaksi</span>
        </a>
        <a href="/akun" class="flex flex-col items-center gap-1 {{ request()->is('akun*') ? 'text-primary' : 'hover:text-primary' }}">
            <span class="material-symbols-outlined text-xl {{ request()->is('akun*') ? 'fill-1' : '' }}">person</span>
            <span>Akun</span>
        </a>
    </nav>
    @endif

    <!-- Main Content -->
    <main class="flex-grow w-full md:pb-0 pb-16">
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
                        <li><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="/">Buku Donasi</a></li>
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

        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.querySelector('button.md\\:hidden');
            const drawer = document.getElementById('mobile-drawer');
            const backdrop = document.getElementById('mobile-drawer-backdrop');
            const closeBtn = document.getElementById('close-drawer');
            
            function toggleDrawer() {
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


        // Global Search Logic (Steam Style)
        const searchInput = document.getElementById('global-search-input');
        const searchContainer = document.getElementById('global-search-container');
        const searchDropdown = document.getElementById('global-search-dropdown');
        const searchResults = document.getElementById('global-search-results');
        
        let searchTimeout;
        let currentFocus = -1;

        if(searchInput && searchDropdown) {
            searchInput.addEventListener('input', function(e) {
                const keyword = e.target.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (keyword.length < 2) {
                    closeSearchDropdown();
                    return;
                }
                
                searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center"><span class="material-symbols-outlined animate-spin text-primary align-middle mr-2">sync</span>Mencari...</div>';
                showSearchDropdown();

                searchTimeout = setTimeout(() => {
                    fetch(`/search?q=${encodeURIComponent(keyword)}`)
                        .then(res => res.json())
                        .then(data => {
                            renderSearchResults(data, keyword);
                        })
                        .catch(err => {
                            searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-error text-center">Terjadi kesalahan.</div>';
                        });
                }, 300);
            });
            
            searchInput.addEventListener('keydown', function(e) {
                const items = searchDropdown.querySelectorAll('.search-item');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    currentFocus++;
                    addActive(items);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentFocus--;
                    addActive(items);
                } else if (e.key === 'Enter') {
                    if (currentFocus > -1) {
                        e.preventDefault();
                        if (items[currentFocus]) {
                            items[currentFocus].click();
                        }
                    }
                } else if (e.key === 'Escape') {
                    closeSearchDropdown();
                }
            });

            function addActive(items) {
                if (!items || items.length === 0) return false;
                removeActive(items);
                if (currentFocus >= items.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (items.length - 1);
                
                items[currentFocus].classList.add('bg-gray-100');
                items[currentFocus].scrollIntoView({ block: "nearest" });
            }

            function removeActive(items) {
                for (let i = 0; i < items.length; i++) {
                    items[i].classList.remove('bg-gray-100');
                }
            }
            
            function showSearchDropdown() {
                searchDropdown.classList.remove('hidden');
                setTimeout(() => {
                    searchDropdown.classList.remove('opacity-0', 'invisible', 'translate-y-[-10px]');
                    searchDropdown.classList.add('opacity-100', 'visible', 'translate-y-0');
                }, 10);
            }
            
            function closeSearchDropdown() {
                searchDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
                searchDropdown.classList.add('opacity-0', 'invisible', 'translate-y-[-10px]');
                setTimeout(() => {
                    searchDropdown.classList.add('hidden');
                }, 200);
                currentFocus = -1;
            }

            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    closeSearchDropdown();
                }
            });

            function renderSearchResults(data, keyword) {
                currentFocus = -1;
                let html = '';
                
                const hasBooks = data.books && data.books.length > 0;
                const hasCategories = data.categories && data.categories.length > 0;
                const hasPublishers = data.publishers && data.publishers.length > 0;
                
                if (!hasBooks && !hasCategories && !hasPublishers) {
                    searchResults.innerHTML = `
                        <div class="px-6 py-8 text-center text-gray-500">
                            <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">search_off</span>
                            <p class="text-sm">Tidak ada hasil ditemukan</p>
                            <p class="text-xs mt-1">Coba gunakan kata kunci lain.</p>
                        </div>
                    `;
                    return;
                }
                
                const escapeRegExp = (string) => string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${escapeRegExp(keyword)})`, 'gi');
                const highlight = (text) => text ? text.replace(regex, '<span class="font-bold text-gray-900">$1</span>') : '';

                if (hasBooks) {
                    html += `<div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider sticky top-0 bg-white/95 backdrop-blur z-10 border-b border-gray-50">Buku</div>`;
                    data.books.forEach(book => {
                        html += `
                            <a href="/buku/${book.id}" class="search-item flex items-center gap-3 px-4 py-2.5 hover:bg-gray-100 transition-colors duration-150 cursor-pointer border-b border-gray-50 last:border-0 outline-none">
                                <span class="material-symbols-outlined text-primary bg-primary/10 p-1.5 rounded-md">menu_book</span>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-800 truncate">${highlight(book.judul_buku)}</div>
                                    <div class="text-xs text-gray-500 truncate">${highlight(book.pengarang)}</div>
                                </div>
                            </a>
                        `;
                    });
                }
                
                if (hasCategories) {
                    html += `<div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider sticky top-0 bg-white/95 backdrop-blur z-10 border-b border-gray-50 mt-1">Kategori</div>`;
                    data.categories.forEach(category => {
                        html += `
                            <a href="/kategori?kategori[]=${encodeURIComponent(category.nama_kategori)}" class="search-item flex items-center gap-3 px-4 py-2.5 hover:bg-gray-100 transition-colors duration-150 cursor-pointer border-b border-gray-50 last:border-0 outline-none">
                                <span class="material-symbols-outlined text-secondary bg-secondary/10 p-1.5 rounded-md">folder</span>
                                <div class="text-sm font-medium text-gray-800 truncate flex-1">${highlight(category.nama_kategori)}</div>
                            </a>
                        `;
                    });
                }
                
                if (hasPublishers) {
                    html += `<div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider sticky top-0 bg-white/95 backdrop-blur z-10 border-b border-gray-50 mt-1">Penerbit</div>`;
                    data.publishers.forEach(publisher => {
                        html += `
                            <a href="/kategori?penerbit[]=${encodeURIComponent(publisher.nama_penerbit)}" class="search-item flex items-center gap-3 px-4 py-2.5 hover:bg-gray-100 transition-colors duration-150 cursor-pointer border-b border-gray-50 last:border-0 outline-none">
                                <span class="material-symbols-outlined text-tertiary bg-tertiary/10 p-1.5 rounded-md">business</span>
                                <div class="text-sm font-medium text-gray-800 truncate flex-1">${highlight(publisher.nama_penerbit)}</div>
                            </a>
                        `;
                    });
                }
                
                searchResults.innerHTML = html;
            }
        }
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
    @endif
</body>
</html>
