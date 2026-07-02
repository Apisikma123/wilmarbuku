@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
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
    
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-12 text-center">
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-amber-100 shadow-sm">
            <i data-lucide="alert-circle" class="w-10 h-10 text-amber-500"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">Halaman Dibutuhkan Segera</h3>
        <p class="text-slate-500 max-w-md mx-auto">
            Di sini Anda dapat melihat daftar buku yang sangat dibutuhkan. Saat ini terdapat <strong>18 Judul</strong> buku yang masuk dalam kategori prioritas ini.
        </p>
    </div>
</div>
@endsection
