@extends('layouts.main')

@section('content')
<div class="px-6 min-h-[70vh] flex flex-col items-center justify-center text-center bg-surface">
    <div class="max-w-md mx-auto space-y-6 relative">
        <!-- Decorative Background -->
        <div class="absolute inset-0 bg-red-500/5 rounded-full blur-3xl -z-10 transform scale-150"></div>
        
        <h1 class="text-8xl md:text-9xl font-black text-error drop-shadow-md">500</h1>
        <div class="bg-error/10 text-error px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest inline-block border border-error/20">
            Kesalahan Server
        </div>
        <p class="text-lg text-on-surface-variant leading-relaxed">
            Ada yang salah di server kami. Coba lagi dalam beberapa menit.
        </p>
        <div class="pt-4 flex gap-4 justify-center">
            <button onclick="window.location.reload()" class="bg-primary text-white font-bold px-8 py-3.5 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg inline-flex items-center gap-2">
                <span class="material-symbols-outlined">refresh</span>
                Coba Lagi
            </button>
            <a href="/" class="bg-white border border-outline-variant text-on-surface font-bold px-8 py-3.5 rounded-xl hover:bg-surface-container transition-all shadow-sm">
                Ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
