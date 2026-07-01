@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1200px] mx-auto py-12">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="/donasi" class="inline-flex items-center text-sm font-medium text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-lg mr-1">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Kiri: Identitas & Buku -->
        <div class="w-full lg:w-[60%] flex flex-col gap-6">
            
            <!-- Identitas Donatur -->
            <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6 text-[#004225]">
                    <span class="material-symbols-outlined">person</span>
                    <h2 class="text-lg font-bold">Identitas Donatur</h2>
                </div>

                <!-- Tipe Donatur Toggle -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Internal -->
                    <label class="relative flex flex-col border-2 border-[#004225] rounded-xl p-4 cursor-pointer bg-white">
                        <input type="radio" name="tipe_donatur" class="hidden" checked>
                        <span class="font-bold text-[#004225] mb-1">Internal Kampus</span>
                        <span class="text-xs text-on-surface-variant">Mahasiswa / Dosen WBI</span>
                    </label>
                    <!-- Eksternal -->
                    <label class="relative flex flex-col border border-outline-variant/50 rounded-xl p-4 cursor-pointer hover:border-[#004225]/50 transition-colors">
                        <input type="radio" name="tipe_donatur" class="hidden">
                        <span class="font-bold text-on-surface mb-1">Publik / Umum</span>
                        <span class="text-xs text-on-surface-variant">Donatur Eksternal</span>
                    </label>
                </div>

                <!-- Form Fields -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-1">Nomor Induk Mahasiswa (NIM) <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg focus:border-[#004225] focus:ring-1 focus:ring-[#004225] outline-none transition-colors text-sm" placeholder="Masukkan NIM Anda" required>
                        <div class="flex items-center gap-1 mt-1.5 text-on-surface-variant text-[11px]">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            <span>Diperlukan untuk syarat kelulusan perpustakaan.</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-on-surface mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg focus:border-[#004225] focus:ring-1 focus:ring-[#004225] outline-none transition-colors text-sm" placeholder="Nama sesuai identitas" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-on-surface mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg focus:border-[#004225] focus:ring-1 focus:ring-[#004225] outline-none transition-colors text-sm" placeholder="alamat@email.com" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Donasi -->
            <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6 text-[#004225]">
                    <span class="material-symbols-outlined">menu_book</span>
                    <h2 class="text-lg font-bold">Buku Donasi</h2>
                </div>

                <div class="flex flex-col sm:flex-row gap-6 mb-6">
                    <!-- Book Cover -->
                    <div class="w-24 aspect-[2/3] rounded-lg bg-gradient-to-br from-[#003215] to-[#004b23] flex-shrink-0 flex flex-col items-center justify-center p-3 text-center text-white border border-black/5 shadow-md">
                        <span class="material-symbols-outlined text-xl opacity-80 mb-2">account_balance</span>
                        <h4 class="text-[9px] font-bold uppercase leading-tight mb-1">Manajemen<br>Modern</h4>
                        <div class="w-6 h-[1px] bg-[#fdc34d] mb-1"></div>
                        <span class="text-[5px] uppercase tracking-wider opacity-80">Dr. Hendra Saputra</span>
                    </div>

                    <!-- Book Info -->
                    <div class="flex flex-col justify-center">
                        <h3 class="font-bold text-lg text-on-surface leading-tight mb-1">Manajemen Modern & Strategi Inovasi</h3>
                        <p class="text-sm text-on-surface-variant mb-4">Oleh: Dr. Hendra Saputra, M.B.A.</p>
                        <div class="flex gap-2">
                            <span class="bg-[#f1f5f9] text-[#475569] text-[11px] font-bold px-3 py-1.5 rounded-md">Bisnis</span>
                            <span class="bg-[#f1f5f9] text-[#475569] text-[11px] font-bold px-3 py-1.5 rounded-md">Edisi 2024</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-end border-t border-outline-variant/30 pt-6 mt-2">
                    <span class="text-sm font-medium text-on-surface-variant">Harga Buku:</span>
                    <span class="text-xl font-bold text-on-surface">Rp 450.000</span>
                </div>
            </div>
        </div>

        <!-- Kanan: Ringkasan & Pembayaran -->
        <div class="w-full lg:w-[40%] flex flex-col gap-6">
            
            <!-- Ringkasan Donasi -->
            <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden sticky top-24">
                
                <div class="bg-[#f8fafc] p-6 border-b border-outline-variant/30">
                    <h2 class="text-sm font-bold text-[#004225]">Ringkasan Donasi</h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Subtotal (1 Buku)</span>
                            <span class="font-medium text-on-surface">Rp 450.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Biaya Platform</span>
                            <span class="font-medium text-on-surface">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Pajak (Termasuk)</span>
                            <span class="font-medium text-on-surface">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center border-t border-outline-variant/30 pt-6 mb-8">
                        <span class="font-bold text-on-surface text-sm">Total Pembayaran</span>
                        <span class="font-bold text-2xl text-[#004225]">Rp 450.000</span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-on-surface mb-4">Metode Pembayaran</h3>
                        
                        <div class="space-y-3">
                            <!-- VA -->
                            <label class="flex items-center justify-between border border-outline-variant/50 rounded-xl p-4 cursor-pointer hover:border-[#004225]/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" class="text-[#004225] focus:ring-[#004225] w-4 h-4" checked>
                                    <span class="text-sm font-medium text-on-surface">Virtual Account (BNI, Mandiri, BCA)</span>
                                </div>
                                <span class="material-symbols-outlined text-outline-variant">account_balance</span>
                            </label>
                            
                            <!-- QRIS -->
                            <label class="flex items-center justify-between border border-outline-variant/50 rounded-xl p-4 cursor-pointer hover:border-[#004225]/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" class="text-[#004225] focus:ring-[#004225] w-4 h-4">
                                    <span class="text-sm font-medium text-on-surface">QRIS</span>
                                </div>
                                <span class="material-symbols-outlined text-outline-variant">qr_code_scanner</span>
                            </label>
                            
                            <!-- Kartu -->
                            <label class="flex items-center justify-between border border-outline-variant/50 rounded-xl p-4 cursor-pointer hover:border-[#004225]/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" class="text-[#004225] focus:ring-[#004225] w-4 h-4">
                                    <span class="text-sm font-medium text-on-surface">Kartu Kredit / Debit</span>
                                </div>
                                <span class="material-symbols-outlined text-outline-variant">credit_card</span>
                            </label>
                        </div>
                    </div>

                    <button class="w-full bg-[#004225] text-white font-bold text-sm px-6 py-4 rounded-xl hover:bg-primary transition-colors shadow-md flex justify-center items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-lg">lock</span>
                        Bayar Sekarang
                    </button>
                    
                    <div class="flex items-center justify-center gap-1.5 text-[11px] text-on-surface-variant">
                        <span class="material-symbols-outlined text-[14px]">verified_user</span>
                        <span>Pembayaran aman & terverifikasi oleh Midtrans</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
