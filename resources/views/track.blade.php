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
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-[20px]">tag</span>
                    <input type="text" placeholder="Masukkan Kode Tracking (ex: WLH-202607-001)" class="w-full bg-surface-bright border border-outline-variant/50 rounded-xl py-4 pl-12 pr-4 text-sm text-on-surface font-medium focus:ring-primary focus:border-primary shadow-sm transition-shadow">
                </div>
                <button class="bg-primary text-white font-bold py-4 px-8 rounded-xl hover:bg-primary-container transition-colors shadow-sm flex items-center justify-center gap-2 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">travel_explore</span> Lacak
                </button>
            </div>
        </div>

        <!-- Tracking Result (Example) -->
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-primary-container p-6 text-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <p class="text-white/70 text-xs uppercase tracking-wider font-bold mb-1">Kode Tracking</p>
                        <h2 class="text-2xl font-bold tracking-tight">WLH-202607-001</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#005143] bg-[#87f6dc] px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Masuk Rak
                    </span>
                </div>
            </div>

            <!-- Book Info -->
            <div class="p-6 border-b border-outline-variant/30">
                <div class="flex gap-5">
                    <img src="/images/manajemen_strategis.png" alt="Buku" class="w-16 h-24 rounded-lg object-cover shadow-sm shrink-0">
                    <div>
                        <h3 class="font-bold text-on-surface text-lg mb-1">Manajemen Strategis & Inovasi</h3>
                        <p class="text-sm text-on-surface-variant mb-1">Oleh: Dr. Wira Santoso</p>
                        <p class="text-sm font-bold text-primary">Rp 150.000</p>
                    </div>
                </div>
            </div>

            <!-- Tracking Steps -->
            <div class="p-6">
                <h3 class="font-bold text-on-surface text-sm mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">timeline</span> Status Penyaluran
                </h3>
                <div class="space-y-0">
                    <!-- Step 1 -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="w-0.5 h-8 bg-primary"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-on-surface text-sm">Menunggu Pembayaran</p>
                            <p class="text-xs text-on-surface-variant">25 Juni 2026, 14:30 WIB</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="w-0.5 h-8 bg-primary"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-on-surface text-sm">Dana Diterima</p>
                            <p class="text-xs text-on-surface-variant">25 Juni 2026, 14:32 WIB</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="w-0.5 h-8 bg-primary"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-on-surface text-sm">Dipesan Admin</p>
                            <p class="text-xs text-on-surface-variant">26 Juni 2026, 10:00 WIB</p>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="w-0.5 h-8 bg-primary"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-on-surface text-sm">Dikirim ke Perpustakaan</p>
                            <p class="text-xs text-on-surface-variant">28 Juni 2026, 15:45 WIB</p>
                        </div>
                    </div>
                    <!-- Step 5 (Final) -->
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center shrink-0 shadow-md">
                                <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            </div>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface text-sm">Masuk Katalog Perpustakaan</p>
                            <p class="text-xs text-on-surface-variant">30 Juni 2026, 09:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="p-6 bg-surface-bright border-t border-outline-variant/30 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-on-surface-variant">Buku Anda telah tersedia di rak perpustakaan kampus.</p>
                <button class="px-5 py-2.5 text-sm font-bold text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors flex items-center gap-2 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">download</span> Unduh E-Sertifikat
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
