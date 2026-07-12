<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WilmarBOOKS - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.14/dist/dotlottie-wc.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">


    <div class="flex h-screen overflow-hidden relative">

        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-[90] opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-[100] w-64 bg-white border-r border-slate-200 flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
            <!-- Logo area -->
            <div class="h-20 flex flex-col justify-center px-6 border-b border-slate-100">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Polytechnic Logo" class="h-10 w-auto object-contain object-left">
                <p class="text-[10px] text-slate-500 font-medium mt-1">Admin Dashboard</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-6 flex flex-col gap-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.catalog') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.catalog') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                    Katalog
                </a>
                <a href="{{ route('admin.transactions') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.transactions') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                    Transaksi
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.users') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Pengguna
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.reports') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    Laporan
                </a>
                

            </nav>

            <!-- Bottom actions -->
            <div class="p-6 pb-8 flex flex-col gap-1">
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.settings') ? 'text-slate-900 bg-slate-50' : 'text-slate-600 hover:text-slate-900' }} font-medium transition-colors">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Pengaturan
                </a>
                <a href="{{ route('admin.support') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.support') ? 'text-slate-900 bg-slate-50' : 'text-slate-600 hover:text-slate-900' }} font-medium transition-colors">
                    <i data-lucide="life-buoy" class="w-5 h-5"></i>
                    Bantuan
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 shrink-0 gap-4 md:gap-8">
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 -ml-2 text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-lg transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>



                <!-- Right items -->
                <div class="flex items-center gap-5 ml-auto h-full">
                    
                    <!-- Notifications -->
                    <div class="relative" x-data="{ 
                        open: false, 
                        notifications: {{ auth()->user()->unreadNotifications->toJson() }},
                        get unreadCount() {
                            return this.notifications.length;
                        },
                        init() {
                            const setupEcho = () => {
                                if(window.Echo) {
                                    window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                                        .notification((notification) => {
                                            this.notifications.unshift({
                                                id: notification.id,
                                                data: notification,
                                                created_at: new Date().toISOString()
                                            });
                                        });
                                } else {
                                    setTimeout(setupEcho, 200);
                                }
                            };
                            setupEcho();
                        },
                        markAllAsRead() {
                            fetch('{{ route('admin.notifications.read') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => {
                                this.notifications = [];
                                this.open = false;
                            });
                        },
                        markAsRead(id, link) {
                            fetch('/admin/notifications/mark-as-read/' + id, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => {
                                this.notifications = this.notifications.filter(n => n.id !== id);
                                if(link) {
                                    window.location.href = link;
                                }
                            });
                        }
                    }">
                        <button @click="open = !open" @click.away="open = false" class="relative p-2 text-slate-500 hover:text-slate-700 transition-colors">
                            <i data-lucide="bell" class="w-6 h-6"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full"></span>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1">
                            
                            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                <h3 class="font-bold text-slate-800">Notifikasi</h3>
                                <button @click="markAllAsRead" x-show="notifications.length > 0" class="text-xs text-green-600 hover:text-green-700 font-medium">Tandai dibaca</button>
                            </div>
                            
                            <div class="max-h-[300px] overflow-y-auto">
                                <template x-if="notifications.length === 0">
                                    <div class="p-6 text-center text-slate-500 flex flex-col items-center">
                                        <i data-lucide="bell-off" class="w-8 h-8 mb-2 opacity-50"></i>
                                        <p class="text-sm">Tidak ada notifikasi baru</p>
                                    </div>
                                </template>
                                <template x-for="notif in notifications" :key="notif.id">
                                    <a href="#" @click.prevent="markAsRead(notif.id, notif.data.link)" class="block p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                        <div class="flex gap-3">
                                            <div class="shrink-0 mt-1">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-700 leading-tight" x-html="notif.data.message"></p>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Logout Button Form -->
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center m-0">
                        @csrf
                        <button type="submit" class="w-10 h-10 shrink-0 rounded-full border border-slate-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-100 hover:text-red-700 flex items-center justify-center transition-colors shadow-sm" title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>

                    <!-- Profile Pill & Dropdown -->
                    <a href="{{ route('admin.settings') }}" class="group relative flex items-center h-full">
                        <!-- Pill -->
                        <div class="flex items-center gap-3 cursor-pointer bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-full p-1.5 pr-5 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-[13px] font-bold text-slate-700 leading-tight">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
                                <span class="text-[10px] font-medium text-slate-400 leading-tight">Administrator</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 ml-1 transition-transform group-hover:rotate-180"></i>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="absolute top-full right-0 mt-3 w-64 bg-white border border-slate-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 flex flex-col overflow-hidden translate-y-2 group-hover:translate-y-0">
                            <div class="p-5 flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden mb-3 border-4 border-slate-50 shadow-sm flex items-center justify-center">
                                    <i data-lucide="user" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <h4 class="font-bold text-slate-900 text-lg leading-tight">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</h4>
                                <p class="text-sm text-slate-500 mb-3">{{ auth()->user()->email ?? 'admin@wilmar.com' }}</p>
                                <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 font-bold text-[10px] uppercase tracking-widest rounded-full">Administrator</span>
                            </div>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto w-full overflow-x-hidden md:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        lucide.createIcons();

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
                        
                        // For Lucide icons in admin
                        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-1 inline-block align-middle"></i> Memproses...';
                        if(window.lucide) {
                            window.lucide.createIcons();
                        }
                    }
                }, 300);
            }
        });

        // Mobile Sidebar Toggle Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        let isSidebarOpen = false;

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleSidebar);
</button>



                <!-- Right items -->
                <div class="flex items-center gap-5 ml-auto h-full">
                    
                    <!-- Notifications -->
                    <div class="relative" x-data="{ 
                        open: false, 
                        notifications: {{ auth()->user()->unreadNotifications->toJson() }},
                        get unreadCount() {
                            return this.notifications.length;
                        },
                        init() {
                            const setupEcho = () => {
                                if(window.Echo) {
                                    window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                                        .notification((notification) => {
                                            this.notifications.unshift({
                                                id: notification.id,
                                                data: notification,
                                                created_at: new Date().toISOString()
                                            });
                                        });
                                } else {
                                    setTimeout(setupEcho, 200);
                                }
                            };
                            setupEcho();
                        },
                        markAllAsRead() {
                            fetch('{{ route('admin.notifications.read') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => {
                                this.notifications = [];
                                this.open = false;
                            });
                        },
                        markAsRead(id, link) {
                            fetch('/admin/notifications/mark-as-read/' + id, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => {
                                this.notifications = this.notifications.filter(n => n.id !== id);
                                if(link) {
                                    window.location.href = link;
                                }
                            });
                        }
                    }">
                        <button @click="open = !open" @click.away="open = false" class="relative p-2 text-slate-500 hover:text-slate-700 transition-colors">
                            <i data-lucide="bell" class="w-6 h-6"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full"></span>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1">
                            
                            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                <h3 class="font-bold text-slate-800">Notifikasi</h3>
                                <button @click="markAllAsRead" x-show="notifications.length > 0" class="text-xs text-green-600 hover:text-green-700 font-medium">Tandai dibaca</button>
                            </div>
                            
                            <div class="max-h-[300px] overflow-y-auto">
                                <template x-if="notifications.length === 0">
                                    <div class="p-6 text-center text-slate-500 flex flex-col items-center">
                                        <i data-lucide="bell-off" class="w-8 h-8 mb-2 opacity-50"></i>
                                        <p class="text-sm">Tidak ada notifikasi baru</p>
                                    </div>
                                </template>
                                <template x-for="notif in notifications" :key="notif.id">
                                    <a href="#" @click.prevent="markAsRead(notif.id, notif.data.link)" class="block p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                        <div class="flex gap-3">
                                            <div class="shrink-0 mt-1">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-700 leading-tight" x-html="notif.data.message"></p>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Logout Button Form -->
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center m-0">
                        @csrf
                        <button type="submit" class="w-10 h-10 shrink-0 rounded-full border border-slate-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-100 hover:text-red-700 flex items-center justify-center transition-colors shadow-sm" title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>

                    <!-- Profile Pill & Dropdown -->
                    <a href="{{ route('admin.settings') }}" class="group relative flex items-center h-full">
                        <!-- Pill -->
                        <div class="flex items-center gap-3 cursor-pointer bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-full p-1.5 pr-5 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-[13px] font-bold text-slate-700 leading-tight">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
                                <span class="text-[10px] font-medium text-slate-400 leading-tight">Administrator</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 ml-1 transition-transform group-hover:rotate-180"></i>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="absolute top-full right-0 mt-3 w-64 bg-white border border-slate-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 flex flex-col overflow-hidden translate-y-2 group-hover:translate-y-0">
                            <div class="p-5 flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden mb-3 border-4 border-slate-50 shadow-sm flex items-center justify-center">
                                    <i data-lucide="user" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <h4 class="font-bold text-slate-900 text-lg leading-tight">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</h4>
                                <p class="text-sm text-slate-500 mb-3">{{ auth()->user()->email ?? 'admin@wilmar.com' }}</p>
                                <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 font-bold text-[10px] uppercase tracking-widest rounded-full">Administrator</span>
                            </div>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto w-full overflow-x-hidden md:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        lucide.createIcons();

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
                        
                        // For Lucide icons in admin
                        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-1 inline-block align-middle"></i> Memproses...';
                        if(window.lucide) {
                            window.lucide.createIcons();
                        }
                    }
                }, 300);
            }
        });

        // Mobile Sidebar Toggle Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        let isSidebarOpen = false;

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleSidebar);
        }
        if (backdrop) {
            backdrop.addEventListener('click', toggleSidebar);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
