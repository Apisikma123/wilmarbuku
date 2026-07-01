@extends('layouts.main')

@section('content')
<div class="px-6 min-h-[70vh] flex flex-col items-center justify-center text-center bg-surface">
    <div class="max-w-md mx-auto space-y-6 relative">
        <!-- Decorative Background -->
        <div class="absolute inset-0 bg-yellow-500/5 rounded-full blur-3xl -z-10 transform scale-150"></div>
        
        <h1 class="text-8xl md:text-9xl font-black text-secondary drop-shadow-md">403</h1>
        <div class="bg-secondary/10 text-secondary-fixed-variant px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest inline-block border border-secondary/20">
            Akses Ditolak
        </div>
        <p class="text-lg text-on-surface-variant leading-relaxed">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Pastikan Anda sudah masuk dengan akun yang benar.
        </p>
        <div class="pt-4 flex gap-4 justify-center">
            <a href="/" class="bg-white border border-outline-variant text-on-surface font-bold px-8 py-3.5 rounded-xl hover:bg-surface-container transition-all shadow-sm">
                Ke Beranda
            </a>
            <a href="/login" class="bg-primary text-white font-bold px-8 py-3.5 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg inline-flex items-center gap-2">
                <span class="material-symbols-outlined">login</span>
                Login
            </a>
        </div>
    </div>
</div>
@endsection
