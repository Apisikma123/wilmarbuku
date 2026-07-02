@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Wishlist Katalog</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar buku yang diajukan untuk penambahan koleksi perpustakaan.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="plus-square" class="w-4 h-4"></i>
                Add New Wishlist
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                <i data-lucide="book" class="w-6 h-6 fill-slate-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900">124 Judul</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <a href="{{ route('admin.dibutuhkan') }}" class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6 hover:shadow-md hover:border-amber-300 transition-all cursor-pointer group">
            <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center text-amber-700 shrink-0 group-hover:bg-amber-100 transition-colors">
                <i data-lucide="more-horizontal" class="w-6 h-6 fill-amber-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-amber-700 transition-colors">Dibutuhkan Segera</p>
                <h3 class="text-3xl font-bold text-slate-900">18 Judul</h3>
            </div>
        </a>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6 fill-emerald-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Berhasil Tersedia</p>
                <h3 class="text-3xl font-bold text-slate-900">86 Judul</h3>
            </div>
        </div>
    </div>

    <!-- Wishlist Detail Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">WISHLIST DETAIL</h3>
            <div class="flex gap-4 text-slate-500">
                <button class="hover:text-slate-900 transition-colors"><i data-lucide="filter" class="w-4 h-4"></i></button>
                <button class="hover:text-slate-900 transition-colors"><i data-lucide="download" class="w-4 h-4"></i></button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">ID</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Book Title</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Author</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Est. Price</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-001</td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-slate-600">The Literacy Crisis in Modern<br>Education</div>
                        </td>
                        <td class="px-6 py-5 text-slate-500">Dr. Elizabeth Vance</td>
                        <td class="px-6 py-5 font-medium text-slate-700 text-right">Rp 245.000</td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Dibutuhkan</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3 text-slate-400">
                                <button class="hover:text-slate-700"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                <button class="hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-002</td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-slate-600">Pedagogi Kreatif Untuk Anak<br>Usia Dini</div>
                        </td>
                        <td class="px-6 py-5 text-slate-500">Ahmad Subagio,<br>M.Pd</td>
                        <td class="px-6 py-5 font-medium text-slate-700 text-right">Rp 128.500</td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Tersedia</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3 text-slate-400">
                                <button class="hover:text-slate-700"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                <button class="hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-003</td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-slate-600">Global Literacy Standards<br>2024</div>
                        </td>
                        <td class="px-6 py-5 text-slate-500">UNESCO Press</td>
                        <td class="px-6 py-5 font-medium text-slate-700 text-right">Rp 512.000</td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Dibutuhkan</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3 text-slate-400">
                                <button class="hover:text-slate-700"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                <button class="hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-004</td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-slate-600">Storytelling for Social Change</div>
                        </td>
                        <td class="px-6 py-5 text-slate-500">Maya Angelou<br>Institute</td>
                        <td class="px-6 py-5 font-medium text-slate-700 text-right">Rp 310.000</td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Tersedia</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3 text-slate-400">
                                <button class="hover:text-slate-700"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                <button class="hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-005</td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-slate-600">Digital Archive Management</div>
                        </td>
                        <td class="px-6 py-5 text-slate-500">Tech Librarian<br>Collective</td>
                        <td class="px-6 py-5 font-medium text-slate-700 text-right">Rp 195.000</td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Dibutuhkan</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3 text-slate-400">
                                <button class="hover:text-slate-700"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                <button class="hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between bg-slate-50/30">
            <span class="text-xs text-slate-500">Showing 1-5 of 124 entries</span>
            <div class="flex gap-1">
                <button class="px-3 py-1 border border-slate-200 text-slate-500 text-xs font-medium rounded hover:bg-slate-100 transition-colors">Previous</button>
                <button class="px-3 py-1 border border-transparent bg-green-900 text-white text-xs font-medium rounded shadow-sm">1</button>
                <button class="px-3 py-1 border border-slate-200 text-slate-700 text-xs font-medium rounded hover:bg-slate-100 transition-colors">2</button>
                <button class="px-3 py-1 border border-slate-200 text-slate-700 text-xs font-medium rounded hover:bg-slate-100 transition-colors">3</button>
                <button class="px-3 py-1 border border-slate-200 text-slate-700 text-xs font-medium rounded hover:bg-slate-100 transition-colors">Next</button>
            </div>
        </div>
    </div>



</div>
@endsection
