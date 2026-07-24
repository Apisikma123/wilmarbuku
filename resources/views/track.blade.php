@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <div class="mb-10">
        <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Lacak Donasi</h1>
        <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Masukkan kode tracking Anda untuk melihat status penyaluran buku donasi secara real-time.</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <!-- Search Box -->
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-outline-variant/30 mb-8">
            <form action="/track" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-[20px]">tag</span>
                    <input type="text" name="kode" value="{{ $kode ?? '' }}" placeholder="Masukkan Kode Tracking (ex: WB...)" required class="w-full bg-surface-bright border border-outline-variant/50 rounded-xl py-4 pl-12 pr-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary shadow-sm transition-shadow">
                </div>
                <button type="submit" class="bg-primary text-white font-bold py-4 px-8 rounded-xl hover:bg-primary-container transition-colors shadow-sm flex items-center justify-center gap-2 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">travel_explore</span> Lacak
                </button>
            </form>
        </div>

        @if($kode && !$transaksi)
            <div class="bg-error-container text-error rounded-2xl p-6 text-center shadow-sm">
                <span class="material-symbols-outlined text-4xl mb-2">error</span>
                <p class="font-bold">Kode Tracking tidak ditemukan.</p>
                <p class="text-sm">Pastikan Anda memasukkan kode yang benar (ex: WB2026892).</p>
            </div>
        @elseif($transaksi)
        <!-- Tracking Result -->
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-primary-container p-6 text-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <p class="text-white/70 text-xs uppercase tracking-wider font-bold mb-1">Kode Tracking</p>
                        <h2 class="text-2xl font-bold tracking-tight">{{ $transaksi->kode_tracking }}</h2>
                    </div>
                    @if($transaksi->status_pembayaran == 'Paid')
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#005143] bg-[#87f6dc] px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Lunas
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#715000] bg-[#fdc34d] px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">schedule</span> Menunggu Pembayaran
                    </span>
                    @endif
                </div>
            </div>

            <!-- Book Info -->
            <div class="p-6 border-b border-outline-variant/30 divide-y divide-outline-variant/30">
                @foreach($transaksi->details as $detail)
                <div class="flex gap-5 py-4 first:pt-0 last:pb-0">
                    <div class="w-16 h-24 rounded-lg flex items-center justify-center shrink-0 shadow-sm text-center overflow-hidden relative bg-slate-900">
                        <img src="{{ (str_starts_with($detail->buku->cover_image ?? '', '/storage/') || str_starts_with($detail->buku->cover_image ?? '', 'http')) ? $detail->buku->cover_image : asset('images/default-cover.png') }}" alt="{{ $detail->buku->judul_buku }}" class="w-full h-full object-cover absolute inset-0 z-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/40 z-10 pointer-events-none"></div>
                        @if((!str_starts_with($detail->buku->cover_image ?? '', '/storage/') && !str_starts_with($detail->buku->cover_image ?? '', 'http')))
                            <span class="text-[6px] font-bold uppercase leading-tight relative z-20 text-white p-2">{!! str_replace(' ', '<br>', e($detail->buku->judul_buku)) !!}</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface text-lg mb-1">{{ $detail->buku->judul_buku }} (x{{ $detail->qty }})</h3>
                        <p class="text-sm text-on-surface-variant mb-1">Oleh: {{ $detail->buku->pengarang }}</p>
                        <p class="text-sm font-bold text-primary">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tracking Steps -->
            <div class="p-6">
                <h3 class="font-bold text-on-surface text-sm mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">timeline</span> Status Penyaluran
                </h3>
                <div class="space-y-0">
                    <!-- Step 1: Pesanan Dibuat -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="w-0.5 h-8 {{ $transaksi->status_pembayaran == 'Paid' ? 'bg-primary' : 'bg-outline-variant/30' }}"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-on-surface text-sm">Pesanan Dibuat</p>
                            <p class="text-xs text-on-surface-variant">{{ $transaksi->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Step 2: Pembayaran Diterima -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            @if($transaksi->status_pembayaran == 'Paid')
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            @else
                            <div class="w-8 h-8 rounded-full bg-outline-variant/30 text-outline flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">payments</span>
                            </div>
                            @endif
                            <div class="w-0.5 h-8 {{ in_array($transaksi->status_tracking, ['Dalam Pengiriman', 'Selesai']) ? 'bg-primary' : 'bg-outline-variant/30' }}"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold {{ $transaksi->status_pembayaran == 'Paid' ? 'text-on-surface' : 'text-on-surface-variant' }} text-sm">Pembayaran Diterima</p>
                            @if($transaksi->status_pembayaran == 'Paid')
                            <p class="text-xs text-on-surface-variant">{{ $transaksi->updated_at->format('d M Y, H:i') }} WIB</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: Dalam Perjalanan -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            @if(in_array($transaksi->status_tracking, ['Dalam Pengiriman', 'Selesai']))
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                            </div>
                            @else
                            <div class="w-8 h-8 rounded-full bg-outline-variant/30 text-outline flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                            </div>
                            @endif
                            <div class="w-0.5 h-8 {{ $transaksi->status_tracking == 'Selesai' ? 'bg-primary' : 'bg-outline-variant/30' }}"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold {{ in_array($transaksi->status_tracking, ['Dalam Pengiriman', 'Selesai']) ? 'text-on-surface' : 'text-on-surface-variant' }} text-sm">Dalam Perjalanan</p>
                            @if(in_array($transaksi->status_tracking, ['Dalam Pengiriman', 'Selesai']))
                            <p class="text-xs text-on-surface-variant">{{ $transaksi->updated_at->format('d M Y, H:i') }} WIB</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 4: Sampai Ke Perpus -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            @if($transaksi->status_tracking == 'Selesai')
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            </div>
                            @else
                            <div class="w-8 h-8 rounded-full bg-outline-variant/30 text-outline flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">store</span>
                            </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold {{ $transaksi->status_tracking == 'Selesai' ? 'text-on-surface' : 'text-on-surface-variant' }} text-sm">Sampai Ke Perpus</p>
                            @if($transaksi->status_tracking == 'Selesai')
                            <p class="text-xs text-on-surface-variant">{{ $transaksi->updated_at->format('d M Y, H:i') }} WIB</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="p-6 bg-surface-bright border-t border-outline-variant/30 flex flex-col sm:flex-row justify-between items-center gap-4">
                @if($transaksi->status_pembayaran == 'Paid')
                <p class="text-xs text-on-surface-variant">Buku Anda sedang diproses untuk masuk ke rak perpustakaan kampus.</p>
                @else
                <p class="text-xs text-on-surface-variant">Silakan selesaikan pembayaran agar buku Anda dapat segera diproses.</p>
                <a href="{{ route('success', ['kode' => $transaksi->kode_tracking]) }}" class="px-5 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-container rounded-lg transition-colors flex items-center gap-2 shadow-sm shrink-0">
                    <span class="material-symbols-outlined text-[18px]">payments</span> Bayar Sekarang
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
