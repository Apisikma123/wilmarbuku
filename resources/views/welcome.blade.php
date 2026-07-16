@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<section class="bg-primary relative px-6 md:px-12 py-12 md:py-24 overflow-hidden flex items-center min-h-[500px] md:min-h-[700px]">
<!-- Background Image with Overlay -->
<div class="absolute inset-0 z-0">
<img alt="Wilmar Building" class="w-full h-full object-cover object-center" src="{{ asset('images/landing.jpeg') }}"/>
<div class="absolute inset-0 bg-gradient-to-r from-primary/90 via-primary/70 to-transparent"></div>
</div>
<div class="relative z-10 max-w-7xl mx-auto w-full grid md:grid-cols-2 gap-12 items-center">
<div class="space-y-8">
<h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight tracking-tight">Donasikan Buku,<br/>Kembangkan Literasi Di Wilmar</h1>
<p class="text-lg md:text-xl text-white/90 max-w-lg leading-relaxed font-light">
        Pilih buku dari katalog, bayar online, dan buku langsung dikirim ke perpustakaan kampus WBI. Donasi Anda jadi referensi belajar mahasiswa — bukan cuma angka di laporan.
      </p>
<div class="flex flex-wrap gap-4 pt-4">
@if(!auth()->check() || auth()->user()->role !== 'admin')
<a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="bg-secondary text-on-secondary font-semibold px-8 py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg inline-flex items-center gap-2 justify-center">
          <span class="material-symbols-outlined">volunteer_activism</span>
          Donasi Sekarang
        </a>
<a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="border border-white/30 text-white font-semibold px-8 py-4 rounded-md hover:bg-white/10 transition-colors backdrop-blur-sm inline-flex items-center gap-2 justify-center">
          <span class="material-symbols-outlined">library_books</span>
          Pilih Buku Donasi
        </a>
@endif
</div>
</div>
<div class="hidden md:block"></div>
</div>
</section>
<!-- Impact Stats -->
<section class="bg-surface py-10 md:py-16 border-b border-outline-variant/30">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="grid grid-cols-3 gap-2 md:gap-8 divide-x divide-outline-variant/30">
<div class="py-4 md:py-0 px-2 md:px-6 flex flex-col md:flex-row items-center justify-center md:justify-start text-center md:text-left gap-2 md:gap-6">
<div class="w-10 h-10 md:w-16 md:h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-xl md:text-3xl text-primary">menu_book</span>
</div>
<div>
<p class="text-xl sm:text-2xl md:text-4xl font-bold text-primary mb-0 md:mb-1 tracking-tight">{{ number_format($global_total_buku, 0, ',', '.') }}+</p>
<p class="text-[9px] sm:text-[10px] md:text-sm font-medium text-on-surface-variant uppercase tracking-wider leading-tight">Buku Terkumpul</p>
</div>
</div>
<div class="py-4 md:py-0 px-2 md:px-6 flex flex-col md:flex-row items-center justify-center md:justify-start text-center md:text-left gap-2 md:gap-6">
<div class="w-10 h-10 md:w-16 md:h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-xl md:text-3xl text-primary">volunteer_activism</span>
</div>
<div>
<p class="text-xl sm:text-2xl md:text-4xl font-bold text-primary mb-0 md:mb-1 tracking-tight">{{ number_format($global_donatur_aktif, 0, ',', '.') }}+</p>
<p class="text-[9px] sm:text-[10px] md:text-sm font-medium text-on-surface-variant uppercase tracking-wider leading-tight">Donatur Aktif</p>
</div>
</div>
<div class="py-4 md:py-0 px-2 md:px-6 flex flex-col md:flex-row items-center justify-center md:justify-start text-center md:text-left gap-2 md:gap-6">
<div class="w-10 h-10 md:w-16 md:h-16 bg-surface-container-low rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-xl md:text-3xl text-primary">verified_user</span>
</div>
<div>
<p class="text-xl sm:text-2xl md:text-4xl font-bold text-primary mb-0 md:mb-1 tracking-tight">100%</p>
<p class="text-[9px] sm:text-[10px] md:text-sm font-medium text-on-surface-variant uppercase tracking-wider leading-tight">Transparansi Laporan</p>
</div>
</div>
</div>
</div>
</section>
<!-- About/Vision -->
<section class="px-6 md:px-12 max-w-7xl mx-auto py-12 md:py-24">
<div class="grid md:grid-cols-2 gap-10 md:gap-20 items-center">
<div class="order-2 md:order-1 relative rounded-xl overflow-hidden aspect-[4/3] max-w-xl mx-auto w-full shadow-2xl shadow-primary/10">
<div class="bg-cover bg-center w-full h-full" data-alt="A close-up shot of hands exchanging a stack of high-quality academic and business books. The lighting is warm and inviting, highlighting the crisp pages and professional covers. The setting feels like a modern academic institution with subtle forest green branding in the background. The mood is collaborative and empowering." style="background-image: url('{{ asset('images/perpus.png') }}')"></div>
</div>
<div class="order-1 md:order-2 space-y-8">
<h2 class="text-4xl md:text-5xl font-bold text-primary leading-tight tracking-tight">Nurturing Entrepreneurs through Literacy</h2>
<div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
<p class="">
                        Perpustakaan WBI melayani 300+ mahasiswa aktif, tapi koleksi bukunya belum memadai. Donasi Anda langsung mengisi rak yang kosong — buku bisnis, teknologi, sampai sastra.
                    </p>
<p class="">
                        Bonus: mahasiswa WBI wajib donasi 1 buku sebagai syarat lulus. Jadi kontribusi Anda juga menginspirasi mereka untuk memberi balik.
                    </p>
</div>
</div>
</div>
</section>
<!-- Featured Catalog -->
<section id="buku-donasi" class="bg-surface-container-low py-12 md:py-24 border-y border-outline-variant/30">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-4 md:gap-6">
<div>
<h2 class="text-2xl md:text-4xl font-bold text-primary mb-2 md:mb-4 tracking-tight">Pilihan Buku Donasi</h2>
<p class="text-sm md:text-lg text-on-surface-variant">Sedang dibutuhkan perpustakaan kampus.</p>
</div>
<div class="flex flex-wrap items-center gap-4 w-full md:w-auto justify-between md:justify-end">
<a class="text-primary font-semibold hover:text-primary-container transition-colors flex items-center gap-2 group" href="{{ route('kategori') }}">
                Lihat Semua Buku 
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
</div>
<div id="buku-carousel" class="flex items-stretch overflow-x-auto pb-8 -mx-6 px-6 snap-x snap-mandatory scroll-smooth gap-6 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
@foreach($buku as $item)
<div class="w-[85vw] max-w-[280px] sm:w-[280px] sm:max-w-none flex-shrink-0 snap-start bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col p-4 group h-full">
<a href="{{ route('buku.detail', $item->id) }}" class="flex flex-col flex-grow">
<div class="w-full aspect-[2/3] mb-4 relative overflow-hidden rounded-[4px] @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-br {{ $item->cover_image }} @endif flex flex-col p-6 text-white border border-black/5 shadow-[inset_4px_0_12px_rgba(0,0,0,0.2)]">
@if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
<img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover z-0">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4 relative z-20">
<h3 class="font-bold text-xl leading-snug tracking-tight font-display text-transparent text-shadow-sm">{{ $item->judul_buku }}</h3>
</div>
<div class="mt-auto text-center opacity-90 font-medium text-[10px] tracking-widest uppercase relative z-20">{{ $item->pengarang }}</div>
@else
<div class="flex-grow flex flex-col justify-center items-center text-center space-y-4 relative z-20 pointer-events-none">
<span class="material-symbols-outlined text-4xl opacity-80 font-light">account_balance</span>
<h3 class="font-bold text-xl leading-snug tracking-tight font-display uppercase">{!! str_replace(' ', '<br/>', $item->judul_buku) !!}</h3>
<div class="w-12 h-[2px] bg-white/50 mx-auto mt-2 rounded-full"></div>
</div>
<div class="mt-auto text-center opacity-70 text-[10px] tracking-widest uppercase relative z-20 pointer-events-none">{{ $item->pengarang }}</div>
@endif
@if($item->stok_dibutuhkan <= 0)
<div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-30 flex items-center justify-center pointer-events-none">
<span class="bg-primary text-white text-[12px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-md">Terpenuhi</span>
</div>
@endif
</div>
<div class="mb-3">
<span class="inline-block bg-[#EDF6EE] text-primary rounded-full px-3 py-1 text-[11px] font-bold tracking-wider uppercase">{{ $item->kategori }}</span>
</div>
<h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary transition-colors min-h-[3.5rem]">{{ $item->judul_buku }}</h3>
<p class="text-primary font-bold text-lg mb-4 mt-auto">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
</a>
<div class="mt-auto pt-4">
@if($item->stok_dibutuhkan <= 0)
<button disabled class="w-full bg-surface-variant text-on-surface-variant font-semibold py-2.5 rounded-[8px] text-sm flex items-center justify-center gap-2 cursor-not-allowed">Target Terpenuhi</button>
@elseif(Auth::check() && isset(Auth::user()->cart_data[$item->id]) && Auth::user()->cart_data[$item->id]['qty'] >= $item->stok_dibutuhkan)
<button disabled class="w-full bg-surface-variant text-on-surface-variant font-semibold py-2.5 rounded-[8px] text-sm flex items-center justify-center gap-2 cursor-not-allowed">Maksimal di Keranjang</button>
@else
@if(auth()->check() && auth()->user()->role === 'admin')
<button disabled class="w-full bg-surface-variant text-on-surface-variant font-semibold py-2.5 rounded-[8px] text-sm flex items-center justify-center gap-2 cursor-not-allowed">Admin Tidak Dapat Membeli</button>
@else
@if(Auth::check())
<form class="ajax-cart-form" action="{{ route('cart.add', $item->id) }}" method="POST">
    @csrf
    <button type="button" class="add-cart-btn w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</button>
</form>
@else
<a href="{{ route('login') }}" class="w-full bg-primary text-white font-semibold py-2.5 rounded-[8px] hover:bg-primary-container transition-colors text-sm flex items-center justify-center gap-2">Belikan Buku Ini</a>
@endif
@endif
@endif
</div>
</div>
@endforeach
</div>
<div class="mt-12 flex justify-center">
    <a href="{{ route('kategori') }}" class="inline-flex items-center gap-2 bg-white border-2 border-primary text-primary font-bold px-8 py-3.5 rounded-lg hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow-md group">
        <span>Lihat Lebih Banyak</span>
        <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
    </a>
</div>
</div>
</section>
<!-- How It Works & Tools -->
<section class="py-12 md:py-24 bg-surface">
<div class="px-6 md:px-12 max-w-7xl mx-auto">
<div class="grid lg:grid-cols-2 gap-12 lg:gap-20">
<!-- How It Works (Timeline) -->
<div>
<h2 class="text-3xl font-bold text-primary mb-8 md:mb-12 tracking-tight">Proses Donasi</h2>
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
<form action="{{ url('/track') }}" method="GET" class="space-y-4">
<div>
<label class="block text-sm font-semibold text-on-surface mb-2" for="tracking-id">ID Donasi / Nomor Resi</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant">tag</span>
<input name="kode" class="w-full pl-12 pr-4 py-4 bg-surface-bright border border-outline-variant rounded-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-on-surface" id="tracking-id" placeholder="Misal: DON-2024-892" type="text" required/>
</div>
</div>
<button type="submit" class="block text-center w-full bg-primary text-on-primary font-semibold py-4 rounded-md hover:bg-primary-container transition-colors shadow-sm">
                        Cek Status
                    </button>
</form>
</div>
</div>
</div>
</section>
<!-- Final CTA -->
<section class="px-4 md:px-12 max-w-7xl mx-auto py-8 md:py-16 text-center">
<div class="relative rounded-[2rem] px-6 py-10 md:p-20 shadow-2xl overflow-hidden group">
<!-- Background Image with Overlay -->
<div class="absolute inset-0 z-0 bg-primary">
<img src="{{ asset('images/Banner.png') }}" alt="Ayo Donasi" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-1000 ease-out opacity-70">
<div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-primary/70 to-transparent"></div>
<!-- Decorative blur blobs -->
<div class="absolute -left-20 -bottom-20 w-64 h-64 bg-secondary/30 blur-[80px] rounded-full mix-blend-screen hidden md:block"></div>
<div class="absolute -right-20 -top-20 w-64 h-64 bg-primary-container/30 blur-[80px] rounded-full mix-blend-screen hidden md:block"></div>
</div>

<div class="relative z-10 max-w-2xl mx-auto flex flex-col items-center">
<h2 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-3 md:mb-5 tracking-tight">
Masih Ada Ruang untuk Kebaikan Anda
</h2>
<p class="text-sm md:text-lg text-white/90 mb-8 md:mb-10 font-light leading-relaxed">
Perpustakaan kampus butuh buku baru tiap semester. Satu donasi Anda bisa dibaca puluhan mahasiswa selama bertahun-tahun.
</p>
@if(!auth()->check() || auth()->user()->role !== 'admin')
<a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="bg-secondary text-on-secondary font-bold px-8 py-3 md:px-10 md:py-4 rounded-md hover:bg-secondary-fixed transition-colors shadow-lg text-sm md:text-lg inline-block text-center">
Donasi Sekarang
</a>
@endif
</div>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartForms = document.querySelectorAll('.ajax-cart-form');
    cartForms.forEach(form => {
        const btn = form.querySelector('.add-cart-btn');
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Fly animation specific to homepage cards
            const card = form.closest('.group');
            const productImg = card.querySelector('.aspect-\\[2\\/3\\] img') || card.querySelector('.aspect-\\[2\\/3\\]');
            const cartBtns = document.querySelectorAll('a[href="/cart"]');
            let cartBtn = null;
            cartBtns.forEach(b => { if(b.offsetParent !== null) cartBtn = b; });
            
            if (productImg && cartBtn) {
                const imgClone = productImg.cloneNode(true);
                const rect = productImg.getBoundingClientRect();
                const cartRect = cartBtn.getBoundingClientRect();
                
                imgClone.style.position = 'fixed';
                imgClone.style.top = rect.top + 'px';
                imgClone.style.left = rect.left + 'px';
                imgClone.style.width = rect.width + 'px';
                imgClone.style.height = rect.height + 'px';
                imgClone.style.zIndex = '9999';
                imgClone.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                imgClone.style.borderRadius = '4px';
                imgClone.style.opacity = '0.9';
                imgClone.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
                if(imgClone.tagName !== 'IMG') {
                    imgClone.style.background = getComputedStyle(productImg).background;
                }
                
                document.body.appendChild(imgClone);
                
                setTimeout(() => {
                    imgClone.style.top = cartRect.top + 'px';
                    imgClone.style.left = cartRect.left + 'px';
                    imgClone.style.width = '20px';
                    imgClone.style.height = '20px';
                    imgClone.style.opacity = '0.1';
                    imgClone.style.transform = 'scale(0.1)';
                }, 20);
                
                setTimeout(() => {
                    imgClone.remove();
                    cartBtn.style.transition = 'transform 0.2s ease';
                    cartBtn.style.transform = 'scale(1.3)';
                    setTimeout(() => cartBtn.style.transform = 'scale(1)', 200);
                }, 400);
            }
            
            // Save original content and show loading state
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[16px]">progress_activity</span> <span class="tracking-wider">Memproses...</span>';
            btn.classList.add('opacity-80', 'cursor-not-allowed', 'scale-95');
            
            // Submit form via AJAX
            const formData = new FormData(form);
            formData.append('qty', 1);
            formData.append('action', 'cart');
            
            // OPTIMISTIC UI UPDATE
            let originalBadgeCounts = [];
            const badges = document.querySelectorAll('.bg-secondary.text-white.text-\\[9px\\]');
            badges.forEach((badge, i) => {
                originalBadgeCounts[i] = parseInt(badge.innerText) || 0;
                badge.innerText = originalBadgeCounts[i] + 1;
                badge.classList.remove('animate-bounce');
                void badge.offsetWidth; // trigger reflow
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
            });

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Restore button state
                btn.disabled = false;
                btn.innerHTML = originalContent;
                btn.classList.remove('opacity-80', 'cursor-not-allowed', 'scale-95');

                if(data.success) {
                    // Update to server's true count
                    if(badges.length > 0) {
                        badges.forEach(badge => {
                            badge.innerText = data.cart_count;
                        });
                    } else if(cartBtn) {
                        // Create badge if it didn't exist
                        const badgeHtml = `<span class="absolute -top-1.5 -right-1.5 bg-secondary text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-sm md:top-[-6px] md:right-[-6px]">${data.cart_count}</span>`;
                        cartBtn.insertAdjacentHTML('beforeend', badgeHtml);
                    }

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                } else {
                    // Revert Optimistic UI on failure
                    badges.forEach((badge, i) => {
                        badge.innerText = originalBadgeCounts[i] > 0 ? originalBadgeCounts[i] : '';
                    });

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }).catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                btn.classList.remove('opacity-80', 'cursor-not-allowed', 'scale-95');
                form.submit();
            });
        });
    });

    // Carousel Logic
    const carousel = document.getElementById('buku-carousel');

    if (carousel) {
        const scrollAmount = 300;
        
        const scrollNext = () => {
            // Check if reached the end
            if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 10) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' }); // Rewind
            } else {
                carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        };

        // Autoplay logic
        let autoplayInterval = setInterval(scrollNext, 3000);

        // Pause autoplay on hover/touch
        const pauseAutoplay = () => clearInterval(autoplayInterval);
        const resumeAutoplay = () => {
            clearInterval(autoplayInterval);
            autoplayInterval = setInterval(scrollNext, 3000);
        };

        carousel.addEventListener('mouseenter', pauseAutoplay);
        carousel.addEventListener('mouseleave', resumeAutoplay);
        carousel.addEventListener('touchstart', pauseAutoplay, {passive: true});
        carousel.addEventListener('touchend', resumeAutoplay);
    }
});
</script>
@endsection
