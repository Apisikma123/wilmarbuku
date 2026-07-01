@extends('layouts.main')

@section('content')
<div class="px-6 min-h-[70vh] flex flex-col items-center justify-center text-center bg-surface">
    <div class="max-w-md mx-auto space-y-6 relative">
        <!-- Decorative Background -->
        <div class="absolute inset-0 bg-primary/5 rounded-full blur-3xl -z-10 transform scale-150"></div>
        
        <h1 class="text-8xl md:text-9xl font-black text-primary drop-shadow-md">404</h1>
        <div class="bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest inline-block border border-primary/20">
            Halaman Tidak Ditemukan
        </div>
        <p class="text-lg text-on-surface-variant leading-relaxed">
            Halaman yang Anda cari tidak ada atau sudah dipindahkan. Cek kembali URL-nya atau kembali ke beranda.
        </p>
        <div class="pt-4">
            <a href="/" class="bg-primary text-white font-bold px-8 py-3.5 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg inline-flex items-center gap-2">
                <span class="material-symbols-outlined">home</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
