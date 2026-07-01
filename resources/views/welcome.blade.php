<!DOCTYPE html>

<html lang="id" style=""><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Wilmar Literacy Hub</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">tailwind.config = {darkMode: "class", theme: {extend: {colors: {"on-tertiary": "#ffffff", "tertiary-fixed-dim": "#69d9c0", "surface-bright": "#f8f9ff", "outline-variant": "#c0c9be", "on-secondary-fixed": "#271900", "on-surface": "#121c29", "surface-dim": "#d0dbed", primary: "#003215", "on-tertiary-fixed-variant": "#005143", "tertiary-fixed": "#87f6dc", "on-primary-fixed-variant": "#0b5229", "inverse-surface": "#27313f", "error-container": "#ffdad6", error: "#ba1a1a", "primary-fixed": "#aef2bb", surface: "#f8f9ff", "on-surface-variant": "#404941", "on-secondary-container": "#715000", "surface-tint": "#2a6a3f", "surface-container-low": "#eff4ff", "surface-container": "#e6eeff", outline: "#707970", "tertiary-container": "#00493d", "secondary-container": "#fdc34d", "on-primary-container": "#79bb87", "surface-container-highest": "#d9e3f6", "on-error": "#ffffff", "secondary-fixed-dim": "#f7bd48", "on-background": "#121c29", "surface-container-high": "#dfe9fb", "surface-container-lowest": "#ffffff", background: "#f8f9ff", secondary: "#7b5800", "on-primary-fixed": "#00210c", "surface-variant": "#d9e3f6", "on-tertiary-container": "#4bbea5", "on-secondary-fixed-variant": "#5d4200", "primary-container": "#004b23", "on-primary": "#ffffff", tertiary: "#003128", "primary-fixed-dim": "#93d6a0", "on-error-container": "#93000a", "inverse-primary": "#93d6a0", "secondary-fixed": "#ffdea6", "on-secondary": "#ffffff", "inverse-on-surface": "#eaf1ff", "on-tertiary-fixed": "#00201a"}, borderRadius: {DEFAULT: "0.5rem", lg: "1rem", xl: "1.5rem", full: "9999px"}, spacing: {}, fontFamily: {headline: ["Poppins"], display: ["Poppins"], body: ["Poppins"], label: ["Poppins"]}, fontSize: {}}}};</script>
<style>
        body { font-family: 'Poppins', sans-serif; }
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px -4px rgba(0, 50, 21, 0.1);
        }
        .book-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 10px 0px 15px -3px rgba(0,0,0,0.1) inset;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col">
<!-- Navigation -->
<header class="bg-surface/90 backdrop-blur-md border-b border-outline-variant/30 fixed top-0 left-0 w-full z-50">
<div class="flex justify-between items-center px-6 md:px-12 xl:px-24 h-20 w-full">
<div class="flex items-center gap-4">
<img alt="Wilmar Logo" class="h-10 object-contain" src="{{ asset('images/wil.png') }}"/>
</div>
<nav class="hidden md:flex gap-8">
<a class="text-on-surface-variant font-medium hover:text-primary transition-colors text-sm uppercase tracking-wider" href="#">Katalog</a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-colors text-sm uppercase tracking-wider" href="#">Donasi</a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-colors text-sm uppercase tracking-wider" href="#">Lacak Status</a>
</nav>
<div class="flex items-center gap-4">
<button class="hidden md:block bg-primary text-on-primary text-sm font-semibold px-6 py-2.5 rounded-md hover:bg-primary-container transition-colors shadow-sm">Donasi Sekarang</button>
</div>
</div>
</header>
<!-- Main Content -->
<main class="flex-grow pt-20">
<!-- Hero Section -->
<section class="bg-primary relative px-6 md:px-12 py-24 md:py-32 overflow-hidden flex items-center min-h-[819px]">
<!-- Background Image with Overlay -->
<div class="absolute inset-0 z-0">
<img alt="Wilmar Building" class="w-full h-full object-cover object-center" src="{{ asset('images/landing.jpeg') }}"/>
<div class="absolute inset-0 bg-gradient-to-r from-primary/90 via-primary/70 to-transparent"></div>
</div>
<div class="relative z-10 max-w-7xl mx-auto w-full grid md:grid-cols-2 gap-12 items-center">
<div class="space-y-8">
<h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight tracking-tight">Transformasi Literasi,<br/>Berdayakan Bangsa</h1>
<p class="text-lg md:text-xl text-white/90 max-w-lg leading-relaxed font-light">
        Bergabunglah dalam gerakan mencerdaskan kehidupan bangsa melalui donasi buku. Bersama Wilmar Business Indonesia Polytechnic, kita bangun ekosistem wirausaha yang berbasis literasi yang kuat.
      </p>
<div class="flex flex-wrap gap-4 pt-4">
<button class="bg-secondary text-on-secondary font-semibold px-8 py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg">
          Donasi Sekarang
        </button>
<button class="border border-white/30 text-white font-semibold px-8 py-4 rounded-md hover:bg-white/10 transition-colors backdrop-blur-sm">
          Lihat Katalog
        </button>
</div>
</div>
<div class="hidden md:block"></div>
</div>
</section>
<!-- Impact Stats -->
<section class="bg-surface py-16 border-b border-outline-variant/30">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-outline-variant/30">
<div class="py-6 md:py-0 px-6 text-center md:text-left flex items-center gap-6">
<div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-3xl text-primary">menu_book</span>
</div>
<div>
<p class="text-4xl font-bold text-primary mb-1 tracking-tight">2,450+</p>
<p class="text-sm font-medium text-on-surface-variant uppercase tracking-wider">Buku Terkumpul</p>
</div>
</div>
<div class="py-6 md:py-0 px-6 text-center md:text-left flex items-center gap-6">
<div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-3xl text-primary">volunteer_activism</span>
</div>
<div>
<p class="text-4xl font-bold text-primary mb-1 tracking-tight">845+</p>
<p class="text-sm font-medium text-on-surface-variant uppercase tracking-wider">Donatur Aktif</p>
</div>
</div>
<div class="py-6 md:py-0 px-6 text-center md:text-left flex items-center gap-6">
<div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-3xl text-primary">verified_user</span>
</div>
<div>
<p class="text-4xl font-bold text-primary mb-1 tracking-tight">100%</p>
<p class="text-sm font-medium text-on-surface-variant uppercase tracking-wider">Transparansi Laporan</p>
</div>
</div>
</div>
</div>
</section>
<!-- About/Vision -->
<section class="px-6 md:px-12 max-w-7xl mx-auto py-32">
<div class="grid md:grid-cols-2 gap-20 items-center">
<div class="order-2 md:order-1 relative rounded-xl overflow-hidden aspect-[4/3] max-w-xl mx-auto w-full shadow-2xl shadow-primary/10">
<div class="bg-cover bg-center w-full h-full" data-alt="A close-up shot of hands exchanging a stack of high-quality academic and business books. The lighting is warm and inviting, highlighting the crisp pages and professional covers. The setting feels like a modern academic institution with subtle forest green branding in the background. The mood is collaborative and empowering." style="background-image: url('{{ asset('images/perpus.png') }}')"></div>
</div>
<div class="order-1 md:order-2 space-y-8">
<h2 class="text-4xl md:text-5xl font-bold text-primary leading-tight tracking-tight">Nurturing Entrepreneurs through Literacy</h2>
<div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
<p class="">
                        Kami percaya bahwa literasi adalah fondasi utama dalam membangun jiwa kewirausahaan. Setiap buku yang Anda donasikan tidak hanya menambah koleksi perpustakaan, tetapi juga membuka peluang baru bagi mahasiswa untuk mengeksplorasi ide, strategi, dan inovasi bisnis.
                    </p>
<p class="">
                        Dengan akses ke sumber daya berkualitas, kita memberdayakan generasi penerus untuk menjadi pemimpin dan inovator masa depan.
                    </p>
</div>
</div>
</div>
</section>
<!-- Featured Catalog -->
<section class="bg-surface-container-low py-32 border-y border-outline-variant/30">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
<div>
<h2 class="text-3xl md:text-4xl font-bold text-primary mb-4 tracking-tight">Koleksi Pilihan</h2>
<p class="text-lg text-on-surface-variant">Buku-buku terbaru yang siap menginspirasi.</p>
</div>
<a class="text-primary font-semibold hover:text-primary-container transition-colors flex items-center gap-2 group" href="#">
                Lihat Semua Katalog 
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
<!-- Book 1 -->
<div class="bg-white rounded-[8px] border border-gray-200 shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] bg-gray-100 mb-4 relative overflow-hidden rounded-[4px] book-shadow">
<div class="bg-cover bg-center w-full h-full absolute inset-0" data-alt="Cover of a professional business strategy book titled 'Manajemen Strategis'. The design is modern and clean, utilizing a corporate aesthetic with geometric shapes in forest green and gold. The book is presented in a well-lit studio environment." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBdaUQ7L4Mr5iixZL3uW6VXBXFpbAGehotGSUrpvBFIOD-8a_TmyzZcq3h4ACCk0zUNqdKLTZOmQlqOqKPlWavSW2CV_W6mEsoyZe63nItZ-vhtAds-Pmo9xaLJvyARWqD0gGfFV_cV8efE-dldmOX6LDl4i2bfqqPvVVhsnFi2X_ifPANgF_fmPToPTvT4DDRxKVCU2tCGiEqB2v-mMZ5ec_H-nrDg_blYk0AbwbmDWbkYQLjty7QgrcsNiGwmgz-374-OuAkpsb0')"></div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Bisnis &amp; Manajemen</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Manajemen Strategis</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 150.000</p>
<div class="mt-auto pt-4 border-t border-gray-100">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 2 -->
<div class="bg-white rounded-[8px] border border-gray-200 shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] bg-gray-100 mb-4 relative overflow-hidden rounded-[4px] book-shadow">
<div class="bg-cover bg-center w-full h-full absolute inset-0" data-alt="Cover of a technical programming book titled 'Dasar Pemrograman'. The design features sleek, tech-inspired abstract graphics in dark blue and green tones. The book is presented professionally with a soft shadow." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBoVwRsCaz9oy9Y913JgCusXJU_d1bGkJBXljcl5N8iO-TdiZd_ypf8mGWS2fiF7CtKfNE60m4CHNivHyYdDKt02WdKNSH6rKkBoTJ-5lnVosXLQMd5fEQrAhgazDfUGX8Di68JwfDq-DT0N3kNyyxIqPpgyAV-ItKWHkU8vYrXM55SKL4G-2RiH1J7Sf0Kd43i5cV55n9w_8_j7_Or6A3gSPgbHKcv8zb_oUUqkr2AfT3haUQLiBqBydrCasdo7mPkOpEHQTZqbnQ')"></div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Teknologi</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Dasar Pemrograman</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 125.000</p>
<div class="mt-auto pt-4 border-t border-gray-100">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 3 -->
<div class="bg-white rounded-[8px] border border-gray-200 shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] bg-gray-100 mb-4 relative overflow-hidden rounded-[4px] book-shadow">
<div class="bg-cover bg-center w-full h-full absolute inset-0" data-alt="Cover of a classic Indonesian literature book titled 'Senja di Jakarta'. The artwork is evocative and slightly melancholic, depicting a stylized sunset over a cityscape. The aesthetic is artistic and refined." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDp2oit0-2rGwp_D06OJ28SmaalBc9oYK18hMvz4YLX3WOqpAm-DGThkOcxj2fIhLbjrfFeb4aA7v_I-CQ0g-2HNFYWRuMcuP3G1HYcZ6yqqUBppMmKoEqh4YgUSMyo4tItRvnWY-lbU6tbEdhpJNW04X4w2JvQtPDib-jgnEf9NDW5rJI9Mrg36cOxlUV5SfGq5PmsU7SBOmfZlMhRbd3dKa5c-T4V7jnN23EqniQqgGfSqJ0sQVDNC8qr2YFodtAXX9m8bno0h-E')"></div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Sastra</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Senja di Jakarta</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 85.000</p>
<div class="mt-auto pt-4 border-t border-gray-100">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 4 -->
<div class="bg-white rounded-[8px] border border-gray-200 shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] bg-gray-100 mb-4 relative overflow-hidden rounded-[4px] book-shadow">
<div class="bg-cover bg-center w-full h-full absolute inset-0" data-alt="Cover of an entrepreneurial success story book titled 'Kisah Sukses Pengusaha Muda'. The design is bold and motivational, featuring dynamic typography and gold accents on a deep green background." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCuxfxL8fI_UEvD11E2WeYCtpt00cnQB2jxJZEt0spvfN80nGisNAY_bvcjQ8YlH3lEH59ocPOpZi3Xz23d5UDRp3NK60jyrIogXmBr4CUZ0oXqrR3cWSmxxNzWft_Q9glvc4NEYbfdEJdZo1-jTQCXc9Owzi8U6OdjlEIA37IH7sLQG4hSjnt8e0HP0Sh9gwc676ZUjYitVMxfztbSrvXp50JtdBGA8fknL_OEYFuLWDeozQvZbQZ1UsUHEHCzJyx1uJAMWFUBvx0')"></div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Motivasi</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Kisah Sukses Pengusaha Muda</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 110.000</p>
<div class="mt-auto pt-4 border-t border-gray-100">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
</div>
</div>
</section>
<!-- How It Works & Tools -->
<section class="py-32 bg-surface">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="grid lg:grid-cols-2 gap-20">
<!-- How It Works (Timeline) -->
<div>
<h2 class="text-3xl font-bold text-primary mb-12 tracking-tight">Proses Donasi</h2>
<div class="space-y-10 relative before:absolute before:inset-0 before:ml-[1.125rem] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-outline-variant before:to-transparent">
<!-- Step 1 -->
<div class="relative flex items-start gap-6">
<div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary text-on-primary ring-4 ring-surface shrink-0 z-10 shadow-md">
<span class="material-symbols-outlined text-lg">shopping_cart</span>
</div>
<div class="pt-1">
<h3 class="text-xl font-bold text-on-surface mb-2">1. Pilih Buku</h3>
<p class="text-on-surface-variant leading-relaxed">Pilih buku yang dibutuhkan perpustakaan dari katalog dan lakukan checkout.</p>
</div>
</div>
<!-- Step 2 -->
<div class="relative flex items-start gap-6">
<div class="flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-primary ring-4 ring-surface shrink-0 z-10 border border-outline-variant shadow-sm">
<span class="material-symbols-outlined text-lg">payments</span>
</div>
<div class="pt-1">
<h3 class="text-xl font-bold text-on-surface mb-2">2. Pembayaran Otomatis</h3>
<p class="text-on-surface-variant leading-relaxed">Lakukan pembayaran secara instan dan aman melalui Payment Gateway terintegrasi.</p>
</div>
</div>
<!-- Step 3 -->
<div class="relative flex items-start gap-6">
<div class="flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-primary ring-4 ring-surface shrink-0 z-10 border border-outline-variant shadow-sm">
<span class="material-symbols-outlined text-lg">track_changes</span>
</div>
<div class="pt-1">
<h3 class="text-xl font-bold text-on-surface mb-2">3. Lacak Pesanan</h3>
<p class="text-on-surface-variant leading-relaxed">Dapatkan Kode Tracking untuk memantau status pesanan hingga buku tiba di rak perpustakaan.</p>
</div>
</div>
<!-- Step 4 -->
<div class="relative flex items-start gap-6">
<div class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary text-on-secondary ring-4 ring-surface shrink-0 z-10 shadow-md">
<span class="material-symbols-outlined text-lg">workspace_premium</span>
</div>
<div class="pt-1">
<h3 class="text-xl font-bold text-on-surface mb-2">4. E-Sertifikat &amp; Kelulusan</h3>
<p class="text-on-surface-variant leading-relaxed">Unduh e-sertifikat sebagai bukti donasi atau validasi syarat kelulusan (khusus mahasiswa).</p>
</div>
</div>
</div>
</div>
<!-- Tracking Utility -->
<div class="bg-surface-container-lowest p-8 md:p-12 rounded-2xl shadow-xl shadow-primary/5 border border-outline-variant/20 flex flex-col justify-center">
<div class="mb-8">
<div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-2xl">troubleshoot</span>
</div>
<h2 class="text-2xl font-bold text-primary mb-3">Lacak Status Donasi</h2>
<p class="text-on-surface-variant">Masukkan ID Donasi atau Nomor Resi pengiriman Anda untuk melihat status terkini dari donasi buku Anda.</p>
</div>
<div class="space-y-4">
<div>
<label class="block text-sm font-semibold text-on-surface mb-2" for="tracking-id">ID Donasi / Nomor Resi</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant">tag</span>
<input class="w-full pl-12 pr-4 py-4 bg-surface-bright border border-outline-variant rounded-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-on-surface" id="tracking-id" placeholder="Misal: DON-2024-892" type="text"/>
</div>
</div>
<button class="w-full bg-primary text-on-primary font-semibold py-4 rounded-md hover:bg-primary-container transition-colors shadow-sm">
                        Cek Status
                    </button>
</div>
</div>
</div>
</div>
</section>
<!-- Final CTA -->
<section class="px-6 md:px-12 max-w-7xl mx-auto py-24 text-center">
<div class="bg-primary rounded-2xl p-16 md:p-24 shadow-2xl relative overflow-hidden">
<div class="relative z-10">
<h2 class="text-4xl md:text-5xl font-bold text-white mb-6 tracking-tight">Mulai Berdampak Hari Ini</h2>
<p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-10 font-light">Satu buku yang Anda berikan bisa menjadi awal dari seribu ide besar. Mari wujudkan ekosistem literasi yang kuat bersama kami.</p>
<button class="bg-secondary text-on-secondary font-bold px-10 py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg text-lg">
                        Donasi Sekarang
                    </button>
</div>
<!-- Decorative element -->
<div class="absolute -right-20 -bottom-20 opacity-5 pointer-events-none">
<span class="material-symbols-outlined text-[400px] text-white">auto_stories</span>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="bg-primary-container text-white w-full py-20 px-6 md:px-12 mt-auto border-t border-white/10">
<div class="max-w-7xl mx-auto">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
<!-- Column 1: Brand Info -->
<div class="space-y-6">
<div class="flex items-center gap-3">
<span class="text-xl font-bold tracking-tight">Wilmar Literacy Hub</span>
</div>
<p class="text-white/80 text-sm leading-relaxed">
          Platform donasi buku resmi Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs through literacy and accessible education.
        </p>
</div>
<!-- Column 2: Tautan Cepat -->
<div>
<h3 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">TAUTAN CEPAT</h3>
<ul class="space-y-4">
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">Tentang Kami</a></li>
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">Panduan Donasi</a></li>
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">Katalog Buku</a></li>
</ul>
</div>
<!-- Column 3: Informasi -->
<div>
<h3 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">INFORMASI</h3>
<ul class="space-y-4">
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">Kebijakan Privasi</a></li>
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">Kontak</a></li>
<li class=""><a class="text-white/70 hover:text-secondary-fixed transition-colors text-sm" href="#">FAQ</a></li>
</ul>
</div>
<!-- Column 4: Social/Contact -->
<div>
<h3 class="text-sm font-bold text-secondary-fixed mb-6 uppercase tracking-widest">HUBUNGI KAMI</h3>
<div class="flex gap-4 mb-6">
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-fixed hover:text-primary transition-all" href="#"><span class="material-symbols-outlined text-xl">language</span></a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-fixed hover:text-primary transition-all" href="#"><span class="material-symbols-outlined text-xl">mail</span></a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-fixed hover:text-primary transition-all" href="#"><span class="material-symbols-outlined text-xl">share</span></a>
</div>
<p class="text-white/60 text-xs italic">Nurturing Entrepreneurs</p>
</div>
</div>
<div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
<p class="text-xs text-white/50">© {{ date('Y') }} Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.</p>
<div class="flex gap-8 text-xs text-white/50">
<a class="hover:text-white transition-colors" href="#">Terms of Service</a>
<a class="hover:text-white transition-colors" href="#">Cookie Policy</a>
</div>
</div>
</div>
</footer>
</body></html>