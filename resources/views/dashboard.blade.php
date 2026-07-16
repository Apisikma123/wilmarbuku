@extends('layouts.user')

@section('content')

    <!-- Banner Section -->
    <div class="relative bg-[#00391a] bg-contain md:bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/dashboard banner.png') }}')">
        <!-- Dark overlay to ensure content remains readable against the background image -->
        <div class="absolute inset-0 bg-black/20"></div>
        
        <div class="max-w-[1280px] mx-auto px-0 md:px-6 py-6 md:py-8 relative z-10">


            <div id="book-banner-slider" class="flex overflow-x-auto hide-scroll snap-x snap-mandatory gap-4 px-4 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-4">
                
                @foreach($buku->take(4) as $index => $item)
                <a href="{{ route('buku.detail', $item->id) }}" class="snap-center shrink-0 w-[85vw] sm:w-[60vw] md:w-auto md:min-w-[260px] lg:min-w-[280px] @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-b {{ $item->cover_image }} @endif rounded-lg aspect-[4/3] md:aspect-[3/4] p-4 md:p-6 flex flex-col justify-between text-white shadow-xl group cursor-pointer border border-white/10 relative overflow-hidden block">
                    @if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
                        <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover z-0">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent z-10"></div>

                    <div class="relative z-20 text-center space-y-1.5 mt-2 md:mt-4">
                        @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http')))
                            <h3 class="text-xl md:text-2xl font-bold font-display uppercase tracking-tight leading-tight">{!! str_replace(' ', '<br/>', $item->judul_buku) !!}</h3>
                        @endif
                    </div>
                    <div class="relative z-20 mt-auto text-center">
                        <span class="inline-block bg-white/10 backdrop-blur border border-white/30 text-white text-[10px] md:text-sm font-semibold px-4 md:px-6 py-1.5 md:py-2 rounded-full group-hover:bg-white group-hover:text-slate-900 transition-colors shadow-[0_4px_15px_rgba(255,255,255,0.15)]">Lihat Detail</span>
                    </div>
                </a>
                @endforeach

            </div>
        </div>
        
        <!-- Trust Bar -->
        <div class="bg-[#00210c]/40 backdrop-blur py-3 md:py-4 border-y border-white/10 overflow-x-auto hide-scroll">
            <div class="max-w-[1280px] mx-auto px-4 md:px-6 flex md:justify-center gap-6 md:gap-16 text-white/90 text-[10px] md:text-sm font-medium w-max md:w-auto">
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">verified_user</span> Transaksi Aman & Terenkripsi</div>
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">receipt_long</span> Transparansi Laporan 100%</div>
                <div class="flex items-center gap-1.5 md:gap-2 whitespace-nowrap"><span class="material-symbols-outlined text-[16px] md:text-xl text-secondary-fixed">support_agent</span> Admin Fast Respond</div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-grow max-w-[1280px] mx-auto w-full px-4 md:px-6 py-6 md:py-12 space-y-8 md:space-y-16 pb-24 md:pb-12">
        
        <!-- Quick Categories -->
        @php
            $bookIcons = ['menu_book', 'auto_stories', 'import_contacts', 'library_books', 'book', 'collections_bookmark', 'chrome_reader_mode'];
        @endphp
        <div class="grid grid-cols-4 md:grid-cols-8 gap-3 md:gap-4">
            @foreach($global_kategoris->take(7) as $index => $kategori)
            <a href="{{ route('kategori', ['kategori' => [$kategori->nama_kategori]]) }}" class="flex flex-col items-center gap-2 md:gap-3 group min-w-[72px]">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">{{ $bookIcons[$index % count($bookIcons)] }}</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight line-clamp-2">{!! str_replace(' ', '<br>', $kategori->nama_kategori) !!}</span>
            </a>
            @endforeach
            
            @if($global_kategoris->count() > 0)
            <a href="/kategori" class="flex flex-col items-center gap-2 md:gap-3 group min-w-[72px]">
                <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-surface rounded-xl md:rounded-[20px] shadow-[0px_4px_10px_rgba(15,23,42,0.03)] flex items-center justify-center border border-outline-variant/30 group-hover:border-primary transition-colors group-hover:shadow-[0px_4px_20px_rgba(15,23,42,0.05)]">
                    <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">more_horiz</span>
                </div>
                <span class="text-[9px] md:text-xs font-semibold text-on-surface-variant text-center leading-tight">Lihat<br>Semua</span>
            </a>
            @endif
        </div>

        <!-- Split Layout (Pilihan Kampus & Kategori Terpopuler) -->
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Pilihan Kampus (Left - 60%) -->
            <div class="w-full lg:w-[60%]">
                <div class="flex justify-between items-center mb-6 gap-2">
                    <h2 class="text-base md:text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">star</span> Pilihan Prioritas Kampus
                    </h2>
                    <a href="{{ route('kategori', ['sort' => 'Prioritas']) }}" class="text-xs md:text-sm text-primary font-semibold border border-primary/20 px-3 md:px-4 py-1 md:py-1.5 rounded-full hover:bg-primary/5 transition-colors whitespace-nowrap shrink-0">Lihat Semua</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($buku->where('badge', 'Prioritas Kampus')->take(4) as $item)
                    <a href="{{ route('buku.detail', $item->id) }}" class="bg-white rounded-lg shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-br {{ $item->cover_image }} @endif rounded mb-3 flex items-center justify-center p-2 text-center text-white relative group overflow-hidden">
                            @if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
                                <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <h4 class="text-[9px] font-bold uppercase leading-tight z-10">{!! str_replace(' ', '<br>', $item->judul_buku) !!}</h4>
                            @endif
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                                <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                            </div>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">{{ $item->judul_buku }}</h3>
                                <p class="text-[10px] text-on-surface-variant mb-1">{{ $item->pengarang }}</p>
                                @if($item->penerbit)
                                <p class="text-[10px] text-primary/80 flex items-center gap-1 mb-2"><span class="material-symbols-outlined text-[12px]">apartment</span> {{ $item->penerbit }}</p>
                                @else
                                <div class="mb-2"></div>
                                @endif
                            </div>
                            <p class="text-primary font-bold text-sm mt-auto">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-2 md:col-span-4 text-center text-sm text-slate-400 py-8 italic border border-dashed border-outline-variant/50 rounded-xl">
                        Belum ada buku pilihan prioritas saat ini.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Kategori Terpopuler (Right - 40%) -->
            <div class="w-full lg:w-[40%]">
                <div class="flex justify-between items-center mb-6 gap-2">
                    <h2 class="text-base md:text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">apartment</span> Partner Penerbit
                    </h2>
                    <a href="{{ route('kategori') }}" class="text-xs md:text-sm text-primary font-semibold border border-primary/20 px-3 md:px-4 py-1 md:py-1.5 rounded-full hover:bg-primary/5 transition-colors whitespace-nowrap shrink-0">Lihat Semua</a>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Publisher Brand -->
                    @forelse($global_penerbits->take(6) as $penerbit)
                    <a href="{{ route('kategori', ['penerbit' => [$penerbit->nama_penerbit]]) }}" class="bg-white rounded-xl shadow-sm border border-outline-variant/30 aspect-square flex flex-col items-center justify-center p-4 hover:border-primary transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2 transition-colors">{{ $penerbit->icon ?? 'menu_book' }}</span>
                        <span class="text-[11px] font-semibold text-center text-on-surface-variant group-hover:text-primary leading-tight line-clamp-2" title="{{ $penerbit->nama_penerbit }}">{{ $penerbit->nama_penerbit }}</span>
                    </a>
                    @empty
                    <div class="col-span-3 text-center text-sm text-slate-400 py-8 italic border border-dashed border-outline-variant/50 rounded-xl">
                        Belum ada partner penerbit
                    </div>
                    @endforelse
                </div>
            </div>
            
        </div>

        <!-- Full Width Section (Buku Resmi & Akademik) -->
        <div>
            <div class="flex justify-between items-center mb-6 gap-2">
                <div>
                    <h2 class="text-base md:text-xl font-bold flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-secondary">local_library</span> Referensi Resmi WBI
                    </h2>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-1">Daftar buku wajib untuk mahasiswa semester berjalan.</p>
                </div>
                <a href="{{ route('kategori', ['sort' => 'Rekomendasi']) }}" class="text-xs md:text-sm text-primary font-semibold border border-primary/20 px-3 md:px-4 py-1 md:py-1.5 rounded-full hover:bg-primary/5 transition-colors whitespace-nowrap shrink-0">Lihat Semua</a>
            </div>

            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/30">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @forelse($buku->where('badge', 'Rekomendasi')->take(5) as $item)
                    <a href="{{ route('buku.detail', $item->id) }}" class="bg-white rounded-lg p-3 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 hover:-translate-y-0.5 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block">
                        <div class="w-full aspect-[3/4] @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-br {{ $item->cover_image }} @endif rounded mb-3 flex items-center justify-center p-2 text-center text-white relative group overflow-hidden">
                            @if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
                                <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <h4 class="text-[9px] font-bold uppercase leading-tight">{!! str_replace(' ', '<br>', $item->judul_buku) !!}</h4>
                            @endif
                        </div>
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-xs font-bold text-on-surface line-clamp-2 leading-tight mb-1">{{ $item->judul_buku }}</h3>
                            <div class="mt-auto">
                                <p class="text-primary font-bold text-sm">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <span class="bg-primary/10 text-primary text-[9px] font-bold px-1.5 py-0.5 rounded">Dibutuhkan: {{ $item->stok_dibutuhkan }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-2 md:col-span-5 text-center text-sm text-slate-400 py-8 italic">
                        Belum ada referensi buku lainnya.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Donasi Lagi Yuk Section -->
        <div>
            <div class="flex justify-between items-center mb-6 gap-2">
                <h2 class="text-base md:text-xl font-bold flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-secondary">history</span> Donasi Lagi Yuk
                </h2>
                <a href="/transaksi?status=selesai" class="text-xs md:text-sm text-primary font-semibold border border-primary/20 px-3 md:px-4 py-1 md:py-1.5 rounded-full hover:bg-primary/5 transition-colors whitespace-nowrap shrink-0">Lihat Riwayat</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @forelse($riwayat as $trx)
                <div class="bg-white rounded-xl p-4 shadow-sm border border-outline-variant/30 flex gap-4 items-center">
                    <div class="w-12 aspect-[3/4] @if((!str_starts_with($trx->buku->cover_image, '/storage/') && !str_starts_with($trx->buku->cover_image, 'http'))) bg-gradient-to-br {{ $trx->buku->cover_image }} @endif rounded flex-shrink-0 flex items-center justify-center text-center text-white relative overflow-hidden">
                        @if((str_starts_with($trx->buku->cover_image, '/storage/') || str_starts_with($trx->buku->cover_image, 'http')))
                            <img src="{{ $trx->buku->cover_image }}" alt="{{ $trx->buku->judul_buku }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <span class="text-[6px] font-bold uppercase leading-tight">{!! str_replace(' ', '<br>', $trx->buku->judul_buku) !!}</span>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-on-surface line-clamp-1">{{ $trx->buku->judul_buku }}</h4>
                        <p class="text-[10px] text-on-surface-variant">Donasi: {{ $trx->created_at->format('d M Y') }}</p>
                        <a href="{{ route('kategori') }}" class="inline-block mt-2 text-[10px] font-bold text-primary border border-primary px-3 py-1 rounded hover:bg-primary/10 transition-colors">Donasi Lagi</a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-8 text-center text-on-surface-variant border border-dashed border-outline-variant/50 rounded-xl">
                    <p class="text-sm font-medium">Anda belum pernah melakukan donasi buku. <a href="{{ route('home') }}" class="text-primary hover:underline">Mulai sekarang!</a></p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('book-banner-slider');
        if (slider) {
            let currentIndex = 0;
            const items = slider.children;
            const totalItems = items.length;
            let isMoving = false;
            
            if (totalItems > 1) {
                // Track manual scrolls to update current index
                slider.addEventListener('scroll', () => {
                    if (isMoving) return;
                    const scrollLeft = slider.scrollLeft;
                    const itemWidth = items[0].getBoundingClientRect().width;
                    const gap = 16; // gap-4 is 16px
                    currentIndex = Math.round(scrollLeft / (itemWidth + gap));
                });

                // Auto slide every 4 seconds
                setInterval(() => {
                    // Slide only on mobile where items overflow and snap
                    if (window.innerWidth < 768) {
                        currentIndex = (currentIndex + 1) % totalItems;
                        const itemWidth = items[0].getBoundingClientRect().width;
                        const gap = 16;
                        isMoving = true;
                        slider.scrollTo({
                            left: currentIndex * (itemWidth + gap),
                            behavior: 'smooth'
                        });
                        
                        setTimeout(() => { isMoving = false; }, 600);
                    }
                }, 4000);
            }
        }
    });
    </script>
@endsection
