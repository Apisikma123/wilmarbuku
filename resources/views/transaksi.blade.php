@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <div class="mb-10 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Riwayat Transaksi</h1>
            <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Pantau status donasi buku Anda.</p>
        </div>

        <div class="flex overflow-x-auto hide-scroll gap-2 pb-2 -mb-2 lg:pb-0 lg:mb-0">
            <a href="?status=menunggu_konfirmasi" class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold border transition-colors {{ $filter == 'menunggu_konfirmasi' ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-outline-variant/40 hover:bg-surface-variant/50' }}">Menunggu Konfirmasi</a>
            <a href="?status=dana_diterima" class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold border transition-colors {{ $filter == 'dana_diterima' ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-outline-variant/40 hover:bg-surface-variant/50' }}">Dana Diterima</a>
            <a href="?status=sedang_dikirim" class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold border transition-colors {{ $filter == 'sedang_dikirim' ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-outline-variant/40 hover:bg-surface-variant/50' }}">Sedang Dikirim</a>
            <a href="?status=selesai" class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold border transition-colors {{ $filter == 'selesai' ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-outline-variant/40 hover:bg-surface-variant/50' }}">Selesai</a>
            <a href="?status=dibatalkan" class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold border transition-colors {{ $filter == 'dibatalkan' ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-outline-variant/40 hover:bg-surface-variant/50' }}">Dibatalkan</a>
        </div>
    </div>

    <div class="w-full">
        <!-- Riwayat Transaksi -->
        <div id="user-transactions-container" class="space-y-6">
            @forelse($transaksi as $trx)
            <!-- Loop Transaksi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4 pb-4 border-b border-outline-variant/30">
                    <div>
                        @php
                            $badgeColor = '';
                            $badgeIcon = '';
                            if ($trx->status_tracking == 'Menunggu Pembayaran') {
                                $badgeColor = 'text-[#715000] bg-[#fdc34d]/30 border-[#fdc34d]/50';
                                $badgeIcon = 'schedule';
                            } elseif (in_array($trx->status_tracking, ['Menunggu Konfirmasi', 'Dana Diterima'])) {
                                $badgeColor = 'text-[#005143] bg-[#87f6dc]/30 border-[#87f6dc]/50';
                                $badgeIcon = 'pending_actions';
                            } elseif ($trx->status_tracking == 'Dalam Pengiriman') {
                                $badgeColor = 'text-blue-800 bg-blue-100 border-blue-200';
                                $badgeIcon = 'local_shipping';
                            } elseif ($trx->status_tracking == 'Selesai') {
                                $badgeColor = 'text-green-800 bg-green-100 border-green-200';
                                $badgeIcon = 'check_circle';
                            } else {
                                $badgeColor = 'text-red-800 bg-red-100 border-red-200';
                                $badgeIcon = 'cancel';
                            }
                        @endphp
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold {{ $badgeColor }} px-2.5 py-1 rounded-full border uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[14px]">{{ $badgeIcon }}</span> 
                            {{ $trx->status_tracking == 'Menunggu Konfirmasi' ? 'Menunggu Konfirmasi Admin' : $trx->status_tracking }}
                        </span>
                        
                        @if($filter == 'menunggu_konfirmasi')
                            <h3 class="font-bold text-on-surface text-lg text-on-surface-variant/60 italic">Nomor Resi Belum Diterbitkan</h3>
                        @else
                            <h3 class="font-bold text-on-surface text-lg">{{ $trx->kode_tracking }}</h3>
                        @endif
                        
                        <p class="text-xs text-on-surface-variant">{{ $trx->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-medium text-on-surface-variant">Total Donasi</p>
                        <p class="font-bold text-primary text-xl">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                @foreach($trx->details as $detail)
                <div class="flex flex-col sm:flex-row gap-5 mb-5">
                    <div class="w-16 h-24 rounded-lg flex items-center justify-center shrink-0 shadow-sm text-center p-2 text-white overflow-hidden relative bg-slate-900">
                        <img src="{{ (str_starts_with($detail->buku->cover_image ?? '', '/storage/') || str_starts_with($detail->buku->cover_image ?? '', 'http')) ? $detail->buku->cover_image : asset('images/default-cover.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/40 z-10 pointer-events-none"></div>
                        @if((!str_starts_with($detail->buku->cover_image ?? '', '/storage/') && !str_starts_with($detail->buku->cover_image ?? '', 'http')))
                            <span class="text-[6px] font-bold uppercase leading-tight relative z-20">{!! str_replace(' ', '<br>', $detail->buku->judul_buku) !!}</span>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-bold text-on-surface line-clamp-1 mb-1">{{ $detail->buku->judul_buku }} (x{{ $detail->qty }})</h4>
                        <p class="text-xs text-on-surface-variant mb-2">Oleh: {{ $detail->buku->pengarang }}</p>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            <span class="font-semibold text-on-surface">Distribusi:</span> Perpustakaan Kampus Utama WBI
                        </p>
                    </div>
                </div>
                @endforeach

                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/30">
                    @if($filter == 'sedang_dikirim')
                    <a href="/track?kode={{ $trx->kode_tracking }}" class="px-4 py-2 text-sm font-bold text-on-surface-variant bg-surface-bright border border-outline-variant/50 hover:bg-surface-variant rounded-lg transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">location_on</span> Lacak Status
                    </a>
                    @endif
                    
                    @if($trx->status_pembayaran != 'Paid' && $filter == 'menunggu_konfirmasi' && !$trx->bukti_pembayaran)
                    <form action="{{ route('payment') }}" method="GET" class="inline">
                        <input type="hidden" name="kode" value="{{ $trx->kode_tracking }}">
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-primary hover:bg-primary-container rounded-lg transition-colors flex items-center gap-2 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">payments</span> Bayar / Unggah Bukti
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-outline-variant/40">
                <span class="material-symbols-outlined text-5xl text-outline-variant mb-4">receipt_long</span>
                <p class="text-on-surface-variant font-medium">Anda belum memiliki riwayat transaksi donasi.</p>
                <a href="/" class="inline-block mt-4 text-primary font-bold hover:underline">Mulai Donasi Sekarang</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const setupUserEcho = () => {
        if(window.Echo) {
            window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                .listen('.pesan.baru', (e) => {
                    fetch(window.location.href)
                        .then(res => res.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            const newContainer = doc.getElementById('user-transactions-container');
                            const currentContainer = document.getElementById('user-transactions-container');
                            if(newContainer && currentContainer) {
                                currentContainer.innerHTML = newContainer.innerHTML;
                            }
                        });
                });
        } else {
            setTimeout(setupUserEcho, 500);
        }
    };
    setupUserEcho();
});
</script>
@endsection
