@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <div class="mb-10">
        <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Pesan Masuk</h1>
        <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Notifikasi dan pembaruan penting terkait status donasi dan akun Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden min-h-[500px]">
        <!-- List Header -->
        <div class="bg-surface-bright px-6 py-4 border-b border-outline-variant/30 flex justify-between items-center">
            <h2 class="font-bold text-on-surface">Terbaru ({{ $pesan->where('is_read', false)->count() }})</h2>
        </div>

        <!-- Messages List -->
        <div class="divide-y divide-outline-variant/20">
            @forelse($pesan as $p)
            <div class="p-6 transition-colors cursor-pointer relative {{ $p->is_read ? 'hover:bg-surface-container-low' : 'bg-primary/5 hover:bg-primary/10' }}">
                @if(!$p->is_read)
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                @endif
                <div class="flex items-start gap-4">
                    @php
                        $icon = 'waving_hand';
                        $bgColor = 'bg-surface-container-high';
                        $iconColor = 'text-on-surface-variant';

                        if($p->jenis == 'tracking') {
                            $icon = 'local_shipping';
                            $bgColor = 'bg-primary';
                            $iconColor = 'text-white';
                        } elseif($p->jenis == 'pembayaran') {
                            $icon = 'payments';
                            $bgColor = 'bg-secondary';
                            $iconColor = 'text-white';
                        }
                    @endphp
                    
                    <div class="w-12 h-12 rounded-full {{ $bgColor }} {{ $iconColor }} flex items-center justify-center shrink-0 shadow-sm mt-1">
                        <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                    </div>
                    
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 mb-1">
                            <h3 class="{{ $p->is_read ? 'font-semibold text-on-surface-variant' : 'font-bold text-on-surface' }} text-base">{{ $p->judul }}</h3>
                            @if(!$p->is_read)
                            <span class="text-[11px] font-bold text-primary bg-white px-2 py-0.5 rounded-full border border-primary/20 shrink-0">{{ $p->created_at->diffForHumans() }}</span>
                            @else
                            <span class="text-[11px] font-medium text-on-surface-variant shrink-0">{{ $p->created_at->format('d M Y') }}</span>
                            @endif
                        </div>
                        <p class="text-sm {{ $p->is_read ? 'text-on-surface-variant/80' : 'text-on-surface-variant' }} leading-relaxed">
                            {!! strip_tags($p->isi_pesan, '<br><b><i><strong><em><p><span>') !!}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-3">inbox</span>
                <p class="font-medium">Belum ada pesan masuk.</p>
            </div>
            @endforelse
        </div>
        
    </div>
</div>
@endsection
