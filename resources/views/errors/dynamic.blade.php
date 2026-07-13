@extends('layouts.user')
@section('hide_header', true)

@section('content')
<div class="relative w-full min-h-[80vh] flex flex-col items-center justify-center py-16 px-4 bg-white">

    @php
        $code = $ERROR_CODE ?? (isset($exception) ? $exception->getStatusCode() : 500);
        $message = $ERROR_DESCRIPTION ?? (isset($exception) ? $exception->getMessage() : null);
        
        $errorMap = [
            401 => [
                'title' => 'Sesi Berakhir',
                'desc' => 'Silakan masuk ke akun Anda terlebih dahulu untuk mengakses halaman ini.',
                'icon' => 'login',
                'severity' => 'warning',
            ],
            403 => [
                'title' => 'Akses Ditolak',
                'desc' => 'Anda tidak memiliki izin (hak akses) untuk membuka halaman ini.',
                'icon' => 'lock',
                'severity' => 'danger',
            ],
            404 => [
                'title' => 'Halaman Tidak Ditemukan',
                'desc' => 'Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan ke URL lain.',
                'icon' => 'explore_off',
                'severity' => 'warning',
            ],
            419 => [
                'title' => 'Sesi Halaman Kedaluwarsa',
                'desc' => 'Sesi keamanan halaman telah habis. Silakan segarkan halaman dan coba lagi.',
                'icon' => 'update',
                'severity' => 'warning',
            ],
            429 => [
                'title' => 'Terlalu Banyak Permintaan',
                'desc' => 'Sistem menerima terlalu banyak permintaan dari perangkat Anda. Silakan tunggu beberapa saat.',
                'icon' => 'hourglass_empty',
                'severity' => 'warning',
            ],
            500 => [
                'title' => 'Kesalahan Server Internal',
                'desc' => 'Terjadi kendala teknis pada sistem kami. Tim kami sedang berusaha memperbaikinya secepat mungkin.',
                'icon' => 'dns',
                'severity' => 'danger',
            ],
            503 => [
                'title' => 'Layanan Sedang Dimaintain',
                'desc' => 'Platform sedang dalam masa pemeliharaan berkala untuk peningkatan performa. Silakan kembali lagi nanti.',
                'icon' => 'construction',
                'severity' => 'info',
            ],
        ];

        $mapped = $errorMap[$code] ?? [
            'title' => 'Terjadi Kesalahan',
            'desc' => 'Sistem mendeteksi kesalahan yang tidak terduga.',
            'icon' => 'warning',
            'severity' => 'danger',
        ];

        $title = $ERROR_TITLE ?? $mapped['title'];
        $desc = $message ?: ($ERROR_DESCRIPTION ?? $mapped['desc']);
        $icon = $mapped['icon'];
        $severity = $mapped['severity'];

        if ($severity === 'danger') {
            $iconBg = 'bg-[#ffdad6]';
            $iconColorClass = 'text-[#ba1a1a]';
            $badgeText = 'Critical';
            $badgeClass = 'bg-[#ffdad6] text-[#93000a]';
            $ringColor = 'ring-[#ba1a1a]/15';
        } elseif ($severity === 'warning') {
            $iconBg = 'bg-[#ffdea6]';
            $iconColorClass = 'text-[#7b5800]';
            $badgeText = 'Warning';
            $badgeClass = 'bg-[#ffdea6] text-[#715000]';
            $ringColor = 'ring-[#7b5800]/15';
        } else {
            $iconBg = 'bg-[#eff4ff]';
            $iconColorClass = 'text-[#003215]';
            $badgeText = 'System Info';
            $badgeClass = 'bg-[#eff4ff] text-[#00210c]';
            $ringColor = 'ring-[#003215]/15';
        }
    @endphp

    <div class="w-full max-w-2xl text-center flex flex-col items-center relative z-10">
        
        <!-- Giant Status Code (Background) -->
        <div class="text-[120px] md:text-[180px] font-extrabold leading-none tracking-tighter text-[#003215]/5 select-none absolute -top-10 left-1/2 -translate-x-1/2 z-0 font-display pointer-events-none">
            {{ $code }}
        </div>

        <div class="relative z-10 flex flex-col items-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }} mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                {{ $badgeText }}
            </div>

            <!-- Icon container -->
            <div class="mb-8">
                <div class="w-24 h-24 {{ $iconBg }} rounded-full flex items-center justify-center border border-white/50 shadow-sm relative ring-8 {{ $ringColor }}">
                    <span class="material-symbols-outlined text-5xl {{ $iconColorClass }}">{{ $icon }}</span>
                </div>
            </div>

            <!-- Error Heading -->
            <h1 class="text-3xl md:text-4xl font-bold text-[#003215] mb-4 tracking-tight font-display leading-tight">
                {{ $title }}
            </h1>
            <p class="text-[15px] md:text-[17px] text-[#404941] mb-10 max-w-lg leading-relaxed">
                {{ $desc }}
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full px-4 sm:px-0">
                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-[#003215] text-white font-semibold text-[15px] px-8 py-3.5 rounded-[8px] hover:bg-[#004b23] hover:shadow-md transition-all w-full sm:w-auto h-12">
                    <span class="material-symbols-outlined text-[20px]">home</span>
                    Kembali ke Beranda
                </a>
                
                <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-[#7b5800] text-[#7b5800] font-semibold text-[15px] px-8 py-3.5 rounded-[8px] hover:bg-[#7b5800]/5 hover:shadow-sm transition-all w-full sm:w-auto h-12">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Halaman Sebelumnya
                </a>
            </div>


        </div>
    </div>
</div>
@endsection
