@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Metrics Section -->
    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Moved Action Cards -->
        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Batch Processing Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm flex flex-col justify-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-slate-900 mb-1 text-[13px]">Graduation Batch</h3>
                    <p class="text-[11px] text-slate-500 mb-3 leading-relaxed max-w-[200px]">Validate and approve multiple students who have completed checkouts.</p>
                    <button class="px-4 py-2 bg-green-900 text-white rounded-lg text-xs font-bold shadow-sm hover:bg-green-800 transition-colors">
                        Batch Validate (15)
                    </button>
                </div>
                <div class="absolute right-3 bottom-3 z-10 opacity-40 hidden sm:block">
                    <i data-lucide="graduation-cap" class="w-16 h-16 text-green-900"></i>
                </div>
                <!-- decorative bg -->
                <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-green-50 rounded-full blur-xl"></div>
            </div>

            <!-- Payment Distribution Chart -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm flex flex-col">
                <h3 class="font-bold text-slate-900 mb-4 text-[13px]">Payment Distribution</h3>
                
                <div class="flex-1 flex items-end justify-between gap-3 h-16 px-1 mt-auto">
                    <div class="w-full flex flex-col items-center gap-2">
                        <div class="w-full bg-[#cbd5e1] rounded-t-[4px] h-[40%] transition-colors hover:bg-opacity-80"></div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Mon</span>
                    </div>
                    <div class="w-full flex flex-col items-center gap-2">
                        <div class="w-full bg-[#94a3b8] rounded-t-[4px] h-[55%] transition-colors hover:bg-opacity-80"></div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Tue</span>
                    </div>
                    <div class="w-full flex flex-col items-center gap-2">
                        <div class="w-full bg-[#064e3b] rounded-t-[4px] h-[85%] transition-colors hover:bg-opacity-80"></div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Wed</span>
                    </div>
                    <div class="w-full flex flex-col items-center gap-2">
                        <div class="w-full bg-[#b45309] rounded-t-[4px] h-[35%] transition-colors hover:bg-opacity-80"></div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Thu</span>
                    </div>
                    <div class="w-full flex flex-col items-center gap-2">
                        <div class="w-full bg-[#022c22] rounded-t-[4px] h-[65%] transition-colors hover:bg-opacity-80"></div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Fri</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 sm:gap-6 shrink-0">
            <!-- Pending Payments Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center w-28 sm:w-36">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                        <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-[11px] font-bold text-slate-500 mb-1 leading-tight">Pending<br>Payments</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900">24</h3>
            </div>
            
            <!-- Ready for Grad Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center w-28 sm:w-36">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i data-lucide="badge-check" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-[11px] font-bold text-slate-500 mb-1 leading-tight">Ready for<br>Grad</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900">156</h3>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex flex-wrap items-end gap-4">
        <div class="flex flex-col gap-1.5 flex-1 min-w-[150px]">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Tracking Status</label>
            <select class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-slate-50 outline-none focus:border-green-500 transition-colors">
                <option>All Statuses</option>
                <option>Masuk Katalog</option>
                <option>Menunggu Pembayaran</option>
                <option>Dikirim</option>
                <option>Dana Diterima</option>
            </select>
        </div>
        
        <div class="flex flex-col gap-1.5 flex-1 min-w-[150px]">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Role</label>
            <select class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-slate-50 outline-none focus:border-green-500 transition-colors">
                <option>All Roles</option>
                <option>Student</option>
                <option>Educator</option>
                <option>Donor</option>
            </select>
        </div>
        
        <div class="flex flex-col gap-1.5 flex-[1.5] min-w-[200px]">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Date Range</label>
            <div class="relative relative">
                <i data-lucide="calendar" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" value="Oct 1 - Oct 31, 2023" class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-green-500 transition-colors cursor-pointer" readonly>
            </div>
        </div>
        
        <div class="flex gap-3 mt-4 lg:mt-0">
            <button class="px-5 py-2 border border-slate-200 text-slate-700 bg-white rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors">
                Export CSV
            </button>
            <button class="px-5 py-2 bg-green-900 text-white rounded-lg text-sm font-bold shadow-sm hover:bg-green-800 transition-colors">
                Apply Filters
            </button>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 font-black uppercase tracking-widest bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Tracking Code</th>
                        <th class="px-6 py-4">User Name</th>
                        <th class="px-6 py-4">Book Name</th>
                        <th class="px-6 py-4 text-center">Payment</th>
                        <th class="px-6 py-4">Tracking Status</th>
                        <th class="px-6 py-4 text-center">Graduation</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900 leading-snug">WLH-202310-001</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-[10px] shrink-0">JD</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[13px]">Jane Doe</div>
                                    <div class="text-[10px] text-slate-400">Student (Lvl 3)</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-normal max-w-[160px]">
                            <div class="font-medium text-slate-600 text-[13px] leading-tight">The Great Gatsby (Classic Collection)</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700">Paid</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-medium text-emerald-600">Masuk Katalog</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="inline-flex w-5 h-5 bg-green-900 text-white rounded-[4px] items-center justify-center">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900 leading-snug">WLH-202310-002</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px] shrink-0">BS</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[13px]">Budi Santoso</div>
                                    <div class="text-[10px] text-slate-400">Educator</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-normal max-w-[160px]">
                            <div class="font-medium text-slate-600 text-[13px] leading-tight">Advanced Literacy Pedagogy</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700">Unpaid</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                <span class="text-sm font-medium text-amber-600">Menunggu Pembayaran</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="inline-flex w-5 h-5 border-2 border-slate-200 rounded-[4px]"></div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900 leading-snug">WLH-202310-003</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-[10px] shrink-0">AW</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[13px]">Alice Wong</div>
                                    <div class="text-[10px] text-slate-400">Donor</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-normal max-w-[160px]">
                            <div class="font-medium text-slate-600 text-[13px] leading-tight">Kids Literacy Workbook Vol 2</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700">Paid</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>
                                <span class="text-sm font-medium text-teal-600">Dikirim</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="inline-flex w-5 h-5 bg-green-900 text-white rounded-[4px] items-center justify-center">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900 leading-snug">WLH-202310-004</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px] shrink-0">RM</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[13px]">Robert Miller</div>
                                    <div class="text-[10px] text-slate-400">Student</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-normal max-w-[160px]">
                            <div class="font-medium text-slate-600 text-[13px] leading-tight">Essential English Grammar</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-red-100 text-red-600">Failed</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                <span class="text-sm font-medium text-slate-500">Dana Diterima</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="inline-flex w-5 h-5 border-2 border-slate-200 rounded-[4px]"></div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between bg-white">
            <span class="text-xs font-medium text-slate-400">Showing 1 to 4 of 128 results</span>
            <div class="flex gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-500 rounded bg-white hover:bg-slate-50 transition-colors"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                <button class="w-8 h-8 flex items-center justify-center border border-transparent bg-green-900 text-white font-bold rounded shadow-sm text-xs">1</button>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-600 font-medium rounded hover:bg-slate-50 transition-colors text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-600 font-medium rounded hover:bg-slate-50 transition-colors text-xs">3</button>
                <span class="w-8 h-8 flex items-center justify-center text-slate-400 text-xs">...</span>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-500 rounded bg-white hover:bg-slate-50 transition-colors"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
            </div>
        </div>
    </div>



</div>
@endsection
