@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Overview Dashboard</h2>
            <p class="text-slate-500 text-sm mt-1">Welcome back. Here is what's happening with the hub today.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition-colors">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                This Month
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export Data
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <a href="{{ route('admin.transactions') }}" class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition-all cursor-pointer group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-700 group-hover:bg-green-100 transition-colors">
                    <i data-lucide="hand-coins" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> +12%
                </span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-slate-700 transition-colors">Total Donations</p>
                <h3 class="text-3xl font-bold text-slate-900">Rp 42.850.000</h3>
            </div>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('admin.dibutuhkan') }}" class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-amber-300 transition-all cursor-pointer group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors">
                    <i data-lucide="book-copy" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold">
                    ! 14 Urgent
                </span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-amber-700 transition-colors">Books Needed</p>
                <h3 class="text-3xl font-bold text-slate-900">312</h3>
            </div>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('admin.catalog') }}" class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-blue-300 transition-all cursor-pointer group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-semibold">
                    Processing
                </span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-blue-700 transition-colors">Books In Process</p>
                <h3 class="text-3xl font-bold text-slate-900">85</h3>
            </div>
        </a>

        <!-- Card 4 -->
        <a href="{{ route('admin.users') }}" class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all cursor-pointer group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> +4%
                </span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-emerald-700 transition-colors">Total Users</p>
                <h3 class="text-3xl font-bold text-slate-900">1,240</h3>
            </div>
        </a>
    </div>

    <!-- Charts & Highlight Section -->
    <div class="mb-6">
        <!-- Donation Trends Chart (Mocked UI) -->
        <div class="w-full bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-900">Donation Trends</h3>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="w-3 h-3 rounded-full bg-green-900"></span> Total Funds
                </div>
            </div>
            
            <div class="flex-1 flex items-end gap-2 sm:gap-4 lg:gap-8 h-48 mt-auto px-2">
                <!-- Bar 1 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-blue-100 rounded-t-sm h-[40%] transition-colors group-hover:bg-blue-200"></div>
                    <span class="text-xs text-slate-400 font-medium">Jan</span>
                </div>
                <!-- Bar 2 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-green-900 rounded-t-sm h-[60%] transition-opacity group-hover:opacity-90"></div>
                    <span class="text-xs text-slate-400 font-medium">Feb</span>
                </div>
                <!-- Bar 3 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-blue-100 rounded-t-sm h-[30%] transition-colors group-hover:bg-blue-200"></div>
                    <span class="text-xs text-slate-400 font-medium">Mar</span>
                </div>
                <!-- Bar 4 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-blue-100 rounded-t-sm h-[45%] transition-colors group-hover:bg-blue-200"></div>
                    <span class="text-xs text-slate-400 font-medium">Apr</span>
                </div>
                <!-- Bar 5 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-green-900 rounded-t-sm h-[70%] transition-opacity group-hover:opacity-90"></div>
                    <span class="text-xs text-slate-400 font-medium">May</span>
                </div>
                <!-- Bar 6 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-blue-100 rounded-t-sm h-[50%] transition-colors group-hover:bg-blue-200"></div>
                    <span class="text-xs text-slate-400 font-medium">Jun</span>
                </div>
                <!-- Bar 7 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-green-900 rounded-t-sm h-[85%] transition-opacity group-hover:opacity-90"></div>
                    <span class="text-xs text-slate-400 font-medium">Jul</span>
                </div>
                <!-- Bar 8 -->
                <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                    <div class="w-full bg-blue-100 rounded-t-sm h-[40%] transition-colors group-hover:bg-blue-200"></div>
                    <span class="text-xs text-slate-400 font-medium">Aug</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-900">Recent Transactions</h3>
            <a href="#" class="text-sm font-semibold text-slate-500 hover:text-green-700 transition-colors">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-xs text-slate-500 uppercase bg-white border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Transaction ID</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Donatur / User</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Judul Buku</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Nominal</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">WLH-202310-001</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs shrink-0">AS</div>
                                <div>
                                    <div class="font-bold text-slate-900">Alice Smith</div>
                                    <div class="text-xs text-slate-500">asmith@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">Manajemen Modern & Strategi</td>
                        <td class="px-6 py-4 text-slate-600">24 Okt 2024</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp 150.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wide">Selesai</span>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">WLH-202310-002</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs shrink-0">RJ</div>
                                <div>
                                    <div class="font-bold text-slate-900">Robert Jones</div>
                                    <div class="text-xs text-slate-500">rjones@hub.org</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">Senja di Jakarta Klasik</td>
                        <td class="px-6 py-4 text-slate-600">23 Okt 2024</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp 85.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wide">Diproses</span>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">WLH-202310-003</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shrink-0">EL</div>
                                <div>
                                    <div class="font-bold text-slate-900">Elena Lopez</div>
                                    <div class="text-xs text-slate-500">elena@school.edu</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">Pengantar Kecerdasan Buatan</td>
                        <td class="px-6 py-4 text-slate-600">22 Okt 2024</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp 125.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide">Pending</span>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">WLH-202310-004</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs shrink-0">MK</div>
                                <div>
                                    <div class="font-bold text-slate-900">Michael Kim</div>
                                    <div class="text-xs text-slate-500">mkim@nonprofit.org</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">Dasar Kewirausahaan Berkelanjutan</td>
                        <td class="px-6 py-4 text-slate-600">21 Okt 2024</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp 95.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wide">Selesai</span>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">WLH-202310-005</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold text-xs shrink-0">SW</div>
                                <div>
                                    <div class="font-bold text-slate-900">Sarah White</div>
                                    <div class="text-xs text-slate-500">swhite@donor.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">Start-Up Playbook</td>
                        <td class="px-6 py-4 text-slate-600">20 Okt 2024</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp 200.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wide">Dibatalkan</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
