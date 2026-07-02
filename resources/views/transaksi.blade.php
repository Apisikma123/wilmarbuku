@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <div class="mb-10">
        <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Riwayat & Pelacakan</h1>
        <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Pantau status donasi buku Anda dan unduh e-sertifikat kelulusan (jika telah memenuhi syarat).</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Lacak Donasi -->
        <div class="lg:col-span-1">
            <div class="bg-surface-bright rounded-2xl p-6 shadow-sm border border-outline-variant/30 sticky top-28">
                <h2 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">search</span>
                    Lacak Kode Tracking
                </h2>
                <div class="flex flex-col gap-3">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[18px]">tag</span>
                        <input type="text" placeholder="Masukkan Kode (ex: WLH-001)" class="w-full bg-white border border-outline-variant/50 rounded-lg py-3 pl-10 pr-4 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm transition-shadow">
                    </div>
                    <button class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary-container transition-colors shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">travel_explore</span> Lacak Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Transaksi 1 (Berhasil) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4 pb-4 border-b border-outline-variant/30">
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-[#005143] bg-[#87f6dc]/30 px-2.5 py-1 rounded-full border border-[#87f6dc]/50 uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span> Masuk Rak
                        </span>
                        <h3 class="font-bold text-on-surface text-lg">WLH-202607-001</h3>
                        <p class="text-xs text-on-surface-variant">25 Juni 2026, 14:30 WIB</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-medium text-on-surface-variant">Total Donasi</p>
                        <p class="font-bold text-primary text-xl">Rp 150.000</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-5 mb-5">
                    <img src="/images/manajemen_strategis.png" alt="Buku" class="w-16 h-24 rounded-lg object-cover shadow-sm">
                    <div class="flex-grow">
                        <h4 class="font-bold text-on-surface line-clamp-1 mb-1">Manajemen Strategis & Inovasi</h4>
                        <p class="text-xs text-on-surface-variant mb-2">Oleh: Dr. Wira Santoso</p>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            <span class="font-semibold text-on-surface">Distribusi:</span> Perpustakaan Kampus Utama WBI
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/30">
                    <button class="px-4 py-2 text-sm font-bold text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">download</span> E-Sertifikat Kelulusan
                    </button>
                </div>
            </div>

            <!-- Transaksi 2 (Menunggu Pembayaran) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4 pb-4 border-b border-outline-variant/30">
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-[#715000] bg-[#fdc34d]/30 px-2.5 py-1 rounded-full border border-[#fdc34d]/50 uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[14px]">schedule</span> Menunggu Pembayaran
                        </span>
                        <h3 class="font-bold text-on-surface text-lg">WLH-202607-002</h3>
                        <p class="text-xs text-on-surface-variant">1 Juli 2026, 09:15 WIB</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-medium text-on-surface-variant">Total Donasi</p>
                        <p class="font-bold text-primary text-xl">Rp 125.000</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-5 mb-5">
                    <img src="/images/dasar_pemrograman.png" alt="Buku" class="w-16 h-24 rounded-lg object-cover shadow-sm">
                    <div class="flex-grow">
                        <h4 class="font-bold text-on-surface line-clamp-1 mb-1">Dasar Pemrograman Web</h4>
                        <p class="text-xs text-on-surface-variant mb-2">Oleh: Budi Raharjo</p>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            <span class="font-semibold text-on-surface">Distribusi:</span> Panti Asuhan & Sekolah Binaan
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/30">
                    <button class="px-4 py-2 text-sm font-bold text-white bg-primary hover:bg-primary-container rounded-lg transition-colors flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">payments</span> Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
