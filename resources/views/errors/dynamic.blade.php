<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error {{ $ERROR_CODE ?? 'Oops' }} - WilmarBuku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#121c29] antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Decoration -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#004b23] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute top-20 -right-20 w-72 h-72 bg-[#1b9c85] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-40 left-20 w-80 h-80 bg-[#b8860b] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 max-w-2xl px-6 py-12 mx-auto text-center">
        <!-- Icon/Illustration -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-[#EDF6EE] rounded-full flex items-center justify-center border border-[#004b23]/10 shadow-sm relative">
                @if(($ERROR_CODE ?? 500) == 404)
                    <span class="material-symbols-outlined text-5xl text-[#004b23]">explore_off</span>
                @elseif(($ERROR_CODE ?? 500) == 403 || ($ERROR_CODE ?? 500) == 401)
                    <span class="material-symbols-outlined text-5xl text-[#ba1a1a]">lock</span>
                @elseif(($ERROR_CODE ?? 500) >= 500)
                    <span class="material-symbols-outlined text-5xl text-[#ba1a1a]">dns</span>
                @else
                    <span class="material-symbols-outlined text-5xl text-[#004b23]">error</span>
                @endif
                <!-- Ping Animation -->
                <div class="absolute inset-0 rounded-full border-2 border-[#004b23]/20 animate-ping opacity-75"></div>
            </div>
        </div>

        <!-- Typography Code -->
        <h1 class="text-[120px] md:text-[150px] font-bold leading-none tracking-tighter text-[#003215] drop-shadow-sm mb-2" style="text-shadow: 4px 4px 0px rgba(0, 50, 21, 0.05);">
            {{ $ERROR_CODE ?? '500' }}
        </h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl md:text-4xl font-bold text-[#004b23] mb-4">{{ $ERROR_TITLE ?? 'Server Error' }}</h2>
        
        <!-- Error Description -->
        <p class="text-lg text-[#404941] mb-10 max-w-lg mx-auto leading-relaxed">
            {{ $ERROR_DESCRIPTION ?? 'Terjadi kesalahan pada server kami. Silakan coba beberapa saat lagi.' }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-[#004b23] text-white font-semibold px-8 py-3.5 rounded-lg hover:bg-[#003215] hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto justify-center">
                <span class="material-symbols-outlined text-[20px]">home</span>
                Kembali ke Beranda
            </a>
            
            <a href="javascript:history.back()" class="inline-flex items-center gap-2 bg-white border border-[#c0c9be] text-[#404941] font-semibold px-8 py-3.5 rounded-lg hover:bg-[#f8f9ff] hover:text-[#121c29] transition-all w-full sm:w-auto justify-center">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
