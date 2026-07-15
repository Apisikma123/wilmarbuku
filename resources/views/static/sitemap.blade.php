@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-2">Peta Situs (Sitemap)</h1>
    <p class="text-on-surface-variant mb-12">Temukan seluruh halaman yang tersedia di WilmarBOOKS.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Utama -->
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-0.5 transition-transform duration-300">
            <h2 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">explore</span> Utama
            </h2>
            <ul class="space-y-4">
                <li><a href="/" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Beranda</a></li>
                <li><a href="/kategori" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Katalog Buku</a></li>
                <li><a href="/search" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Cari Buku</a></li>
                <li><a href="/#buku-donasi" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Buku Pilihan</a></li>
            </ul>
        </div>

        <!-- Layanan -->
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-0.5 transition-transform duration-300">
            <h2 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">apps</span> Layanan Pengguna
            </h2>
            <ul class="space-y-4">
                <li><a href="/dashboard" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Dashboard</a></li>
                <li><a href="/cart" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Keranjang</a></li>
                <li><a href="/transaksi" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Riwayat Transaksi</a></li>
                <li><a href="/track" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Lacak Donasi</a></li>
                <li><a href="/pesan-masuk" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Pesan Masuk</a></li>
                <li><a href="/akun" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Pengaturan Akun</a></li>
            </ul>
        </div>

        <!-- Informasi -->
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-0.5 transition-transform duration-300">
            <h2 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">info</span> Informasi
            </h2>
            <ul class="space-y-4">
                <li><a href="/tentang-kami" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Tentang Kami</a></li>
                <li><a href="/panduan-donasi" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Panduan Donasi</a></li>
                <li><a href="/faq" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> FAQ</a></li>
                <li><a href="/support" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Dukungan (Support)</a></li>
            </ul>
        </div>
        
        <!-- Legal & Keamanan -->
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-0.5 transition-transform duration-300">
            <h2 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">gavel</span> Legal & Privasi
            </h2>
            <ul class="space-y-4">
                <li><a href="/kebijakan-privasi" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Kebijakan Privasi</a></li>
                <li><a href="/terms" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Syarat & Ketentuan</a></li>
                <li><a href="/cookie-policy" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Kebijakan Cookie</a></li>
            </ul>
        </div>
        
        <!-- Autentikasi -->
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-0.5 transition-transform duration-300">
            <h2 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">lock</span> Akun & Akses
            </h2>
            <ul class="space-y-4">
                <li><a href="/login" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Masuk (Login)</a></li>
                <li><a href="/register" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Daftar Akun</a></li>
                <li><a href="/forgot-password" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-secondary/70"></span> Lupa Password</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
