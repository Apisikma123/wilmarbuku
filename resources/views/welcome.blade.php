@extends('layouts.main')

@section('content')
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
<a href="/login" class="bg-secondary text-on-secondary font-semibold px-8 py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg inline-block text-center">
          Donasi Sekarang
        </a>
<button class="border border-white/30 text-white font-semibold px-8 py-4 rounded-md hover:bg-white/10 transition-colors backdrop-blur-sm">
          Pilih Buku Donasi
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
<h2 class="text-3xl md:text-4xl font-bold text-primary mb-4 tracking-tight">Pilihan Buku Donasi</h2>
<p class="text-lg text-on-surface-variant">Buku-buku terbaru yang siap menginspirasi.</p>
</div>
<a class="text-primary font-semibold hover:text-primary-container transition-colors flex items-center gap-2 group" href="#">
                Lihat Semua Buku 
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
<!-- Book 1 -->
<div class="bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-[4px] bg-gradient-to-br from-[#003215] to-[#004b23] flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
<span class="material-symbols-outlined text-4xl opacity-80 font-light">account_balance</span>
<h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Manajemen<br/>Strategis</h3>
<div class="w-12 h-[2px] bg-[#fdc34d] mx-auto mt-2 rounded-full"></div>
</div>
<div class="mt-auto text-center opacity-70 text-[10px] tracking-widest uppercase">Prof. Dr. Budi Santoso</div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Bisnis &amp; Manajemen</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Manajemen Strategis</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 150.000</p>
<div class="mt-auto pt-4">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 2 -->
<div class="bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-[4px] bg-gradient-to-br from-slate-800 to-slate-900 flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)] relative before:absolute before:inset-0 before:bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] before:from-blue-500/20 before:to-transparent">
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4 relative z-10">
<span class="material-symbols-outlined text-4xl text-cyan-300 opacity-80 font-light">terminal</span>
<h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Dasar<br/>Pemrograman</h3>
<div class="w-12 h-[2px] bg-cyan-400 mx-auto mt-2 rounded-full"></div>
</div>
<div class="mt-auto text-center opacity-70 text-[10px] tracking-widest uppercase relative z-10">Andreas Setiawan</div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Teknologi</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Dasar Pemrograman</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 125.000</p>
<div class="mt-auto pt-4">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 3 -->
<div class="bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-[4px] bg-gradient-to-br from-amber-700 to-orange-950 flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
<span class="material-symbols-outlined text-4xl opacity-80 font-light">location_city</span>
<h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Senja di<br/>Jakarta</h3>
<div class="w-12 h-[2px] bg-amber-200 mx-auto mt-2 rounded-full"></div>
</div>
<div class="mt-auto text-center opacity-70 text-[10px] tracking-widest uppercase">Mochtar Lubis</div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Sastra</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Senja di Jakarta</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 85.000</p>
<div class="mt-auto pt-4">
<button class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</div>
</div>
<!-- Book 4 -->
<div class="bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-[4px] bg-gradient-to-br from-teal-800 to-[#003128] flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4">
<span class="material-symbols-outlined text-4xl text-yellow-400 opacity-90 font-light">emoji_events</span>
<h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">Kisah Sukses<br/>Pengusaha Muda</h3>
<div class="w-12 h-[2px] bg-yellow-400 mx-auto mt-2 rounded-full"></div>
</div>
<div class="mt-auto text-center opacity-70 text-[10px] tracking-widest uppercase">Ahmad Setiawan &amp; Tim</div>
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">Motivasi</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors">Kisah Sukses Pengusaha Muda</h3>
<p class="text-primary font-bold text-lg mb-4">Rp 110.000</p>
<div class="mt-auto pt-4">
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
<div class="bg-primary rounded-2xl p-16 md:p-24 shadow-2xl relative">
<div class="absolute inset-0 overflow-hidden rounded-2xl">
<!-- Decorative element -->
<div class="absolute -right-20 -bottom-20 opacity-5 pointer-events-none">
<span class="material-symbols-outlined text-[400px] text-white">auto_stories</span>
</div>
</div>
<div class="relative z-10">
<h2 class="text-4xl md:text-5xl font-bold text-white mb-6 tracking-tight">Mulai Berdampak Hari Ini</h2>
<p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-10 font-light">Satu buku yang Anda berikan bisa menjadi awal dari seribu ide besar. Mari wujudkan ekosistem literasi yang kuat bersama kami.</p>
<a href="/login" class="bg-secondary text-on-secondary font-bold px-10 py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg text-lg inline-block text-center">
                        Donasi Sekarang
                    </a>
</div>
</div>
</section>
@endsection
