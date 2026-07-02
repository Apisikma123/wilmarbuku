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
            <h1 class="text-3xl md:text-4xl font-bold text-on-surface mb-3 tracking-tight">Pembayaran Berhasil!</h1>
            <p class="text-on-surface-variant text-base leading-relaxed mb-8 max-w-lg mx-auto">
                Terima kasih atas partisipasi Anda dalam program donasi literasi Wilmar Business Indonesia Polytechnic.
            </p>

            <!-- Tracking Code Box -->
            <div class="bg-[#f8f9ff] rounded-xl border border-outline-variant/50 p-6 mb-8 text-left relative overflow-hidden shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-10 -mt-10 pointer-events-none"></div>
                
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">KODE TRACKING ANDA</p>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <p class="text-3xl font-black text-primary tracking-tight" id="tracking-code">WLH-202607-001</p>
                    <button class="shrink-0 bg-white border border-outline-variant/50 hover:bg-surface-variant text-on-surface-variant hover:text-primary text-sm font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors shadow-sm" onclick="navigator.clipboard.writeText(document.getElementById('tracking-code').innerText); Swal.fire({ title: 'Berhasil!', text: 'Kode Tracking telah disalin ke clipboard.', icon: 'success', confirmButtonText: 'Tutup' })">
                        <span class="material-symbols-outlined text-[18px]">content_copy</span> Salin Kode
                    </button>
                </div>
                <div class="mt-5 pt-4 border-t border-outline-variant/30 flex items-start gap-3">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">workspace_premium</span>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Gunakan kode ini untuk melacak status pengadaan buku. Khusus <span class="font-bold">pengguna internal</span>, kode ini juga digunakan untuk memvalidasi syarat Surat Keterangan Bebas Pustaka.
                    </p>
                </div>
            </div>

            <!-- Receipt Info -->
            <div class="bg-white rounded-lg p-5 mb-10 border border-outline-variant/40 text-left shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-medium text-on-surface-variant">Donasi Buku</span>
                    <span class="text-sm font-semibold text-on-surface text-right">Manajemen Modern & Strategi Inovasi</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-medium text-on-surface-variant">Total Pembayaran</span>
                    <span class="text-sm font-bold text-on-surface">Rp 150.000</span>
                </div>
                <div class="flex justify-between items-center border-t border-outline-variant/30 pt-4">
                    <span class="text-xs font-medium text-on-surface-variant">Metode Pembayaran</span>
                    <span class="text-xs font-medium text-on-surface">Virtual Account BNI</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs font-medium text-on-surface-variant">Waktu Transaksi</span>
                    <span class="text-xs font-medium text-on-surface">02 Juli 2026, 09:30 WIB</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center w-full">
                <a href="/track" class="w-full sm:w-auto bg-primary text-white font-semibold py-4 px-8 rounded-lg hover:bg-primary-container transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">location_on</span>
                    Lacak Donasi
                </a>
                <a href="/dashboard" class="w-full sm:w-auto bg-white border border-primary text-primary font-semibold py-4 px-8 rounded-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">home</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
