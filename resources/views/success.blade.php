@extends('layouts.user')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 font-poppins bg-[#f8f9ff]">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.06)] border border-outline-variant/30 overflow-hidden relative">
        <!-- Decorative Header Background -->
        <div class="h-32 bg-gradient-to-r from-primary to-primary-container relative">
            <!-- Abstract pattern/overlay -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        </div>
        
        <!-- Icon -->
        <div class="absolute top-16 left-1/2 -translate-x-1/2 z-10">
            <div class="w-24 h-24 bg-white rounded-full p-2.5 shadow-lg flex items-center justify-center border border-outline-variant/10 success-pulse">
                <div class="w-full h-full bg-[#E5ECE7] rounded-full flex items-center justify-center text-primary">
                    <svg class="checkmark w-14 h-14" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 56 56">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-dasharray="166" stroke-dashoffset="166"/>
                        <path class="checkmark__check" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-dasharray="48" stroke-dashoffset="48" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
            </div>
        </div>

        <style>
            .checkmark__circle {
                animation: checkmark-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
            }
            .checkmark__check {
                animation: checkmark-stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
            }
            @keyframes checkmark-stroke {
                100% { stroke-dashoffset: 0; }
            }
            .success-pulse {
                animation: success-pulse 2.5s infinite 1s;
            }
            @keyframes success-pulse {
                0% { box-shadow: 0 0 0 0 rgba(0, 50, 21, 0.15); }
                70% { box-shadow: 0 0 0 25px rgba(0, 50, 21, 0); }
                100% { box-shadow: 0 0 0 0 rgba(0, 50, 21, 0); }
            }
        </style>

        <div class="pt-20 pb-10 px-6 sm:px-10 md:px-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-on-surface mb-3 tracking-tight">Bukti Pembayaran Terkirim!</h1>
            <p class="text-on-surface-variant text-base leading-relaxed mb-8 max-w-lg mx-auto">
                Terima kasih sudah berdonasi, donasi anda sedang dikonfirmasi admin. <br>
                Nomor pelacakan (resi) akan dikirimkan ke <b>Kotak Masuk</b> Anda setelah pembayaran berhasil diverifikasi.
            </p>

            <!-- Receipt Info -->
            <div class="bg-white rounded-lg p-5 mb-10 border border-outline-variant/40 text-left shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-medium text-on-surface-variant">Item Donasi</span>
                    <span class="text-sm font-semibold text-on-surface text-right">{{ $detail ? $detail->buku->judul_buku : 'Paket Buku' }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-medium text-on-surface-variant">Total Tagihan</span>
                    <span class="text-sm font-bold text-on-surface">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center border-t border-outline-variant/30 pt-4">
                    <span class="text-xs font-medium text-on-surface-variant">Metode Pembayaran</span>
                    <span class="text-xs font-medium text-on-surface">Transfer Rekening</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs font-medium text-on-surface-variant">Waktu Transaksi</span>
                    <span class="text-xs font-medium text-on-surface">{{ $transaksi->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-center w-full">
                <a href="/dashboard" class="w-full sm:w-auto bg-primary text-white font-semibold py-4 px-8 rounded-lg hover:bg-primary/90 transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">home</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
