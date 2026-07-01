@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">User Management</h2>
            <p class="text-slate-500 text-sm mt-1">Manage administrator access levels and internal literacy stakeholders.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Invite New Admin
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-700 shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Users</p>
                <h3 class="text-2xl font-bold text-slate-900">1,284</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Internal (NIM/NIDN)</p>
                <h3 class="text-2xl font-bold text-slate-900">842</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-700 shrink-0">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Admins</p>
                <h3 class="text-2xl font-bold text-slate-900">12</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-700 shrink-0">
                <i data-lucide="user-minus" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Pending Revoke</p>
                <h3 class="text-2xl font-bold text-slate-900">3</h3>
            </div>
        </div>
    </div>

    <!-- Users Table Area -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        
        <!-- Table Toolbar -->
        <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            
            <!-- Tabs -->
            <div class="flex items-center bg-slate-100 rounded-lg p-1">
                <button class="px-4 py-1.5 text-sm font-bold bg-white text-slate-900 rounded shadow-sm">Internal Users</button>
                <button class="px-4 py-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 rounded transition-colors">External Users</button>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 text-slate-600 bg-white rounded-lg text-xs font-bold shadow-sm hover:bg-slate-50 transition-colors">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    Filter By Role
                </button>
                <button class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 text-slate-600 bg-white rounded-lg text-xs font-bold shadow-sm hover:bg-slate-50 transition-colors">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    Export CSV
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 font-black uppercase tracking-widest bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Identity (NIM/NIDN)</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm shrink-0">BS</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">Bambang<br>Sugiharto</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Joined Jan 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">b.sugiharto@wilmar.ac.id</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider whitespace-nowrap bg-amber-100 text-amber-700">Super Admin</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 tracking-wide text-sm leading-tight">198204122005011003</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-bold text-slate-700">Active</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 shrink-0 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">Siti<br>Aminah</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Joined Mar 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">siti.aminah@wilmar.ac.id</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider whitespace-nowrap bg-green-900 text-white">Admin</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 tracking-wide text-sm">20210084001</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-bold text-slate-700">Active</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">RD</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">Rian Dwi</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Joined Feb 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">rian.dwi@student.ac.id</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider whitespace-nowrap bg-blue-100 text-blue-700">User Internal</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 tracking-wide text-sm">20231010045</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-bold text-slate-700">Active</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold text-sm shrink-0">JD</div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">John Doe</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Joined Apr 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">john.doe@gmail.com</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider whitespace-nowrap bg-slate-200 text-slate-600">User External</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="italic font-bold text-slate-400 text-sm">Not Applicable</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                                <span class="text-sm font-bold text-slate-700">Inactive</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-slate-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between bg-white">
            <span class="text-xs font-medium text-slate-400">Showing 4 of 1,284 users</span>
            <div class="flex gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-500 rounded bg-white hover:bg-slate-50 transition-colors"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                <button class="w-8 h-8 flex items-center justify-center border border-transparent bg-green-900 text-white font-bold rounded shadow-sm text-xs">1</button>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-600 font-medium rounded hover:bg-slate-50 transition-colors text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-600 font-medium rounded hover:bg-slate-50 transition-colors text-xs">3</button>
                <button class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-500 rounded bg-white hover:bg-slate-50 transition-colors"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
            </div>
        </div>
    </div>

</div>
@endsection
