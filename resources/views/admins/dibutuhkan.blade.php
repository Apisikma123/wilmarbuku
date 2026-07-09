@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 p-4 md:p-0">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.catalog') }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Dibutuhkan Segera</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar buku dengan prioritas tinggi yang perlu segera diadakan.</p>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
            <h3 class="font-bold text-slate-900">Total {{ $books->count() }} Judul Buku Dibutuhkan</h3>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 font-bold text-xs rounded-full">Prioritas Tinggi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Judul Buku</th>
                        <th class="px-6 py-4 font-bold">Pengarang</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold text-center">Target Stok</th>
                        <th class="px-6 py-4 font-bold text-right">Harga Estimasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $b)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $b->judul_buku }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $b->pengarang }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 rounded-full text-xs font-medium">{{ $b->kategori }}</span></td>
                        <td class="px-6 py-4 text-center font-bold text-amber-600">{{ $b->stok_dibutuhkan }} Buku</td>
                        <td class="px-6 py-4 font-bold text-slate-900 text-right">Rp {{ number_format($b->harga_estimasi, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">Saat ini belum ada buku yang dibutuhkan segera.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $books->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
