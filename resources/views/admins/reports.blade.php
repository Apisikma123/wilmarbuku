@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Analytics & Reports</h2>
            <p class="text-slate-500 text-sm mt-1">Overview of system performance, transactions, and user engagement.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <select class="appearance-none pl-4 pr-10 py-2 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 outline-none focus:border-green-500 shadow-sm cursor-pointer">
                    <option>Last 12 Months</option>
                    <option>This Year</option>
                    <option>Last 30 Days</option>
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>
            
            <button class="flex items-center gap-2 px-5 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export Report
            </button>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md">+15.2%</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Transactions (IDR)</p>
            <h3 class="text-3xl font-bold text-slate-900">Rp 124.5M</h3>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-md">+8.4%</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Books Distributed</p>
            <h3 class="text-3xl font-bold text-slate-900">3,420</h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-md">Stable</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Active Users</p>
            <h3 class="text-3xl font-bold text-slate-900">1,284</h3>
        </div>
    </div>

    <!-- Main Overall Chart -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col h-[400px]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Overall Activity (12 Months)</h3>
                <p class="text-sm text-slate-500">Comparison of incoming funds vs distributed books.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                    <span class="w-3 h-3 rounded bg-green-900"></span> Funds (IDR)
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                    <span class="w-3 h-3 rounded bg-amber-500"></span> Books
                </div>
            </div>
        </div>

        <!-- CSS Based Bar Chart -->
        <div class="flex-1 flex items-end gap-2 sm:gap-4 px-2 mt-auto border-b border-slate-200 pb-2 relative">
            
            <!-- Grid Lines Background -->
            <div class="absolute inset-0 flex flex-col justify-between z-0 border-t border-slate-100 pointer-events-none">
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full flex-1"></div>
            </div>

            <!-- Month 1 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[40%] transition-opacity hover:opacity-80 cursor-pointer" title="Funds: High"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[30%] transition-opacity hover:opacity-80 cursor-pointer" title="Books: Medium"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Jan</span>
            </div>
            
            <!-- Month 2 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[55%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[45%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Feb</span>
            </div>

            <!-- Month 3 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[35%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[25%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Mar</span>
            </div>

            <!-- Month 4 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[65%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[60%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Apr</span>
            </div>

            <!-- Month 5 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[80%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[40%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">May</span>
            </div>

            <!-- Month 6 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[50%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[70%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Jun</span>
            </div>

            <!-- Month 7 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-green-900 rounded-t h-[90%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t h-[85%] transition-opacity hover:opacity-80 cursor-pointer"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-900 uppercase">Jul</span>
            </div>

            <!-- Month 8 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Aug</span>
            </div>

            <!-- Month 9 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Sep</span>
            </div>

            <!-- Month 10 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full hidden md:flex">
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Oct</span>
            </div>

            <!-- Month 11 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full hidden md:flex">
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Nov</span>
            </div>

            <!-- Month 12 -->
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full hidden md:flex">
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <div class="w-full max-w-[20px] bg-slate-200 rounded-t h-[10%]"></div>
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">Dec</span>
            </div>

        </div>
    </div>

    <!-- Generated Reports List -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mt-8">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-900">Previously Exported Reports</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 font-black uppercase tracking-widest bg-white border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Report Name</th>
                        <th class="px-6 py-4">Generated By</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-center">Format</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">Q2 2024 Performance Overview</td>
                        <td class="px-6 py-4 text-slate-600">Bambang Sugiharto</td>
                        <td class="px-6 py-4 text-slate-600">July 1, 2024</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-1 bg-red-100 text-red-700 font-bold text-[10px] uppercase rounded">PDF</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-green-700 hover:text-green-900 font-semibold text-sm">Download</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">User Growth & Activity - June</td>
                        <td class="px-6 py-4 text-slate-600">Siti Aminah</td>
                        <td class="px-6 py-4 text-slate-600">June 30, 2024</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-1 bg-emerald-100 text-emerald-700 font-bold text-[10px] uppercase rounded">CSV</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-green-700 hover:text-green-900 font-semibold text-sm">Download</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
