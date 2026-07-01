@extends('layouts.user')

@section('content')
    <div class="flex-grow max-w-[1280px] mx-auto w-full px-6 py-10">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-primary text-3xl">shopping_bag</span>
            <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight">Keranjang Donasi</h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Select All Row -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/40 flex justify-between items-center transition-shadow hover:shadow-md">
                    <label class="flex items-center gap-4 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" checked class="peer appearance-none w-6 h-6 border-2 border-outline-variant rounded-md checked:bg-primary checked:border-primary transition-colors cursor-pointer">
                            <span class="material-symbols-outlined absolute text-white text-sm opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity font-bold">check</span>
                        </div>
                        <span class="font-semibold text-on-surface text-base group-hover:text-primary transition-colors">Pilih Semua Buku</span>
                    </label>
                    <button class="text-sm font-semibold text-error hover:bg-error/10 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">delete</span> Hapus
                    </button>
                </div>

                <!-- Cart Item 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all group">
                    <div class="flex gap-5">
                        <div class="relative flex items-start justify-center pt-2">
                            <input type="checkbox" checked class="peer appearance-none w-6 h-6 border-2 border-outline-variant rounded-md checked:bg-primary checked:border-primary transition-colors cursor-pointer">
                            <span class="material-symbols-outlined absolute text-white text-sm opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity font-bold top-[13px]">check</span>
                        </div>
                        <div class="flex-grow">
                            <!-- Header Info -->
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-5">
                                <div class="flex gap-5">
                                    <div class="w-24 h-36 rounded-xl shadow-md flex-shrink-0 relative overflow-hidden group-hover:shadow-lg transition-shadow">
                                        <img src="/images/manajemen_strategis.png" alt="Book Cover" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    </div>
                                    <div class="flex flex-col justify-between py-1">
                                        <div>
                                            <span class="inline-block px-2.5 py-1 bg-surface-container-low text-primary text-[10px] font-bold rounded-md mb-2 uppercase tracking-wider">Bisnis & Ekonomi</span>
                                            <h3 class="font-bold text-on-surface leading-tight text-xl mb-1 group-hover:text-primary transition-colors line-clamp-2">Manajemen Strategis & Inovasi</h3>
                                            <p class="text-sm text-on-surface-variant font-medium">Oleh: Dr. Wira Santoso</p>
                                        </div>
                                        <p class="font-bold text-primary text-2xl mt-4">Rp 150.000</p>
                                    </div>
                                </div>
                                <div class="shrink-0 pt-1">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005143] bg-[#87f6dc]/30 px-3 py-1.5 rounded-full border border-[#87f6dc]/50 shadow-sm">
                                        <span class="material-symbols-outlined text-[16px]">verified</span> Terverifikasi WBI
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Informasi Pesanan -->
                            <div class="bg-surface-bright rounded-xl p-5 border border-outline-variant/30">
                                <h4 class="text-sm font-bold text-on-surface flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary text-[18px]">edit_note</span> Detail Penyaluran
                                </h4>
                                <div class="space-y-5">
                                    <div class="w-full relative">
                                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Pesan Dukungan (Opsional)</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[18px]">chat</span>
                                            <input type="text" placeholder="Tulis semangat untuk penerima..." class="w-full bg-white border border-outline-variant/50 rounded-lg py-2.5 pl-10 pr-4 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm transition-shadow focus:shadow-md">
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-5 pt-2 border-t border-outline-variant/30">
                                        <div class="flex gap-2">
                                            <button class="w-9 h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Pindahkan ke Wishlist"><span class="material-symbols-outlined text-[20px]">favorite</span></button>
                                            <button class="w-9 h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                        </div>
                                        <div class="h-6 w-px bg-outline-variant/40"></div>
                                        <div class="flex items-center gap-1 bg-white border border-outline-variant/50 rounded-lg p-1 shadow-sm">
                                            <button class="w-7 h-7 rounded-md bg-surface-bright text-on-surface flex items-center justify-center hover:bg-outline-variant/20 transition-colors"><span class="material-symbols-outlined text-[18px]">remove</span></button>
                                            <span class="font-bold text-sm w-8 text-center text-on-surface">1</span>
                                            <button class="w-7 h-7 rounded-md bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><span class="material-symbols-outlined text-[18px]">add</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all group">
                    <div class="flex gap-5">
                        <div class="relative flex items-start justify-center pt-2">
                            <input type="checkbox" checked class="peer appearance-none w-6 h-6 border-2 border-outline-variant rounded-md checked:bg-primary checked:border-primary transition-colors cursor-pointer">
                            <span class="material-symbols-outlined absolute text-white text-sm opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity font-bold top-[13px]">check</span>
                        </div>
                        <div class="flex-grow">
                            <!-- Header Info -->
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-5">
                                <div class="flex gap-5">
                                    <div class="w-24 h-36 rounded-xl shadow-md flex-shrink-0 relative overflow-hidden group-hover:shadow-lg transition-shadow">
                                        <img src="/images/dasar_pemrograman.png" alt="Book Cover" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    </div>
                                    <div class="flex flex-col justify-between py-1">
                                        <div>
                                            <span class="inline-block px-2.5 py-1 bg-surface-container-low text-primary text-[10px] font-bold rounded-md mb-2 uppercase tracking-wider">IT & Komputer</span>
                                            <h3 class="font-bold text-on-surface leading-tight text-xl mb-1 group-hover:text-primary transition-colors line-clamp-2">Dasar Pemrograman Web</h3>
                                            <p class="text-sm text-on-surface-variant font-medium">Oleh: Budi Raharjo</p>
                                        </div>
                                        <p class="font-bold text-primary text-2xl mt-4">Rp 125.000</p>
                                    </div>
                                </div>
                                <div class="shrink-0 pt-1">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005143] bg-[#87f6dc]/30 px-3 py-1.5 rounded-full border border-[#87f6dc]/50 shadow-sm">
                                        <span class="material-symbols-outlined text-[16px]">verified</span> Terverifikasi WBI
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Informasi Pesanan -->
                            <div class="bg-surface-bright rounded-xl p-5 border border-outline-variant/30">
                                <h4 class="text-sm font-bold text-on-surface flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary text-[18px]">edit_note</span> Detail Penyaluran
                                </h4>
                                <div class="space-y-5">
                                    <div class="w-full relative">
                                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Pesan Dukungan (Opsional)</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[18px]">chat</span>
                                            <input type="text" placeholder="Tulis semangat untuk penerima..." class="w-full bg-white border border-outline-variant/50 rounded-lg py-2.5 pl-10 pr-4 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm transition-shadow focus:shadow-md">
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-5 pt-2 border-t border-outline-variant/30">
                                        <div class="flex gap-2">
                                            <button class="w-9 h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Pindahkan ke Wishlist"><span class="material-symbols-outlined text-[20px]">favorite</span></button>
                                            <button class="w-9 h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                        </div>
                                        <div class="h-6 w-px bg-outline-variant/40"></div>
                                        <div class="flex items-center gap-1 bg-white border border-outline-variant/50 rounded-lg p-1 shadow-sm">
                                            <button class="w-7 h-7 rounded-md bg-surface-bright text-on-surface flex items-center justify-center hover:bg-outline-variant/20 transition-colors"><span class="material-symbols-outlined text-[18px]">remove</span></button>
                                            <span class="font-bold text-sm w-8 text-center text-on-surface">1</span>
                                            <button class="w-7 h-7 rounded-md bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><span class="material-symbols-outlined text-[18px]">add</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Right Column: Summary -->
            <div class="lg:col-span-4 relative">
                <div class="bg-white rounded-2xl shadow-lg border border-outline-variant/20 p-7 sticky top-28">
                    <h3 class="font-bold text-on-surface text-xl mb-6 pb-4 border-b border-outline-variant/40 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">receipt_long</span> Ringkasan Donasi
                    </h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Total Harga (2 Buku)</span>
                            <span class="font-bold text-on-surface">Rp 275.000</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Biaya Penyaluran</span>
                            <span class="font-bold text-primary">Gratis</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mb-8 pt-4 border-t border-outline-variant/40">
                        <div>
                            <p class="text-sm text-on-surface-variant font-medium mb-1">Total Pembayaran</p>
                            <p class="text-[10px] text-on-surface-variant/80">Termasuk pajak & biaya admin</p>
                        </div>
                        <p class="text-2xl font-black text-primary tracking-tight">Rp 275.000</p>
                    </div>
                    
                    <a href="/checkout" class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined">payments</span> Donasikan Sekarang
                    </a>
                    
                    <div class="mt-5 flex items-center justify-center gap-2 text-xs text-on-surface-variant font-medium bg-surface-container-low py-2 rounded-lg">
                        <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span> Transaksi Aman & Transparan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
