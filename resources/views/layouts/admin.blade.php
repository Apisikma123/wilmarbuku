<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.14/dist/dotlottie-wc.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    Catalog
                </a>
                <a href="{{ route('admin.transactions') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.transactions') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                    Transactions
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.users') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Users
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-6 py-2.5 border-l-4 font-medium transition-colors {{ request()->routeIs('admin.reports') ? 'bg-green-50 text-green-800 border-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    Reports
                </a>
                

            </nav>

            <!-- Bottom actions -->
            <div class="p-6 pb-8 flex flex-col gap-1">
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.settings') ? 'text-slate-900 bg-slate-50' : 'text-slate-600 hover:text-slate-900' }} font-medium transition-colors">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Settings
                </a>
                <a href="{{ route('admin.support') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.support') ? 'text-slate-900 bg-slate-50' : 'text-slate-600 hover:text-slate-900' }} font-medium transition-colors">
                    <i data-lucide="life-buoy" class="w-5 h-5"></i>
                    Support
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
                            <div class="w-9 h-9 rounded-full bg-slate-200 overflow-hidden shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_lengkap ?? 'Admin') }}&background=0D8ABC&color=fff" alt="Admin" class="w-full h-full object-cover">
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
                                <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden mb-3 border-4 border-slate-50 shadow-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_lengkap ?? 'Admin') }}&background=0D8ABC&color=fff" alt="Admin" class="w-full h-full object-cover">
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
            <main class="flex-1 overflow-y-auto p-4 md:p-8 w-full overflow-x-hidden">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        lucide.createIcons();



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
</body>
</html>
