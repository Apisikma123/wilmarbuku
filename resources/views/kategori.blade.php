@extends('layouts.user')

<style>
@media (max-width: 767px) {
    header { display: none !important; }
}
</style>

@section('content')
<div class="bg-gradient-to-b from-primary to-[#004b23] relative text-white py-12 md:py-20 hidden md:block">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-5xl font-bold font-display uppercase tracking-tight mb-4">Jelajahi Kategori</h1>
        <p class="text-white/80 max-w-xl mx-auto text-sm md:text-base">Temukan ratusan buku menarik dari berbagai kategori untuk mendukung literasi dan perkuliahan Anda.</p>
    </div>
</div>



<div class="max-w-[1280px] mx-auto px-0 md:px-6 py-0 md:py-12">
    <!-- Filters & Results -->
    <form id="filterForm" action="{{ route('kategori') }}" method="GET" class="flex flex-col md:flex-row gap-0 md:gap-10">
        
        <!-- Mobile Header (Only visible on mobile) -->
        <div class="md:hidden sticky top-0 z-[100] bg-white border-b border-gray-100 pb-2 shadow-sm w-full">
            <!-- Top Row: Back, Search, Home, Cart -->
            <div class="flex items-center gap-2 px-3 py-2">
                <a href="javascript:history.back()" class="text-gray-600 p-1"><span class="material-symbols-outlined">arrow_back</span></a>
                
                <div class="flex-grow relative flex items-center">
                    <span class="material-symbols-outlined absolute left-2 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full pl-8 pr-8 py-1.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    @if(request('search'))
                    <a href="{{ route('kategori') }}" class="absolute right-2 text-gray-400"><span class="material-symbols-outlined text-[16px]">close</span></a>
                    @endif
                </div>

                <a href="/dashboard" class="text-gray-600 p-1"><span class="material-symbols-outlined">home</span></a>
                <a href="/cart" class="text-gray-600 p-1 relative">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    @php
                        $cartQty = 0;
                        if(Auth::check() && Auth::user()->cart_data) {
                            $cartData = is_string(Auth::user()->cart_data) ? json_decode(Auth::user()->cart_data, true) : Auth::user()->cart_data;
                            $cartQty = is_array($cartData) ? count($cartData) : 0;
                        }
                    @endphp
                    @if($cartQty > 0)
                        <span class="absolute -top-0 -right-0 bg-red-500 text-white text-[9px] rounded-full w-3.5 h-3.5 flex items-center justify-center font-bold">{{ $cartQty }}</span>
                    @endif
                </a>
            </div>

            @if(request('search'))
            <div class="px-4 py-1">
                <h2 class="text-[13px] font-bold text-gray-800">Hasil Pencarian "{{ request('search') }}"</h2>
            </div>
            @endif

            <!-- Category Chips -->
            <div class="flex overflow-x-auto gap-3 px-4 py-3 scrollbar-hide hide-scroll items-center border-b border-gray-50">
                <label class="shrink-0">
                    <input type="radio" name="kategori[]" value="" class="hidden mobile-cat-radio" @if(empty(request('kategori'))) checked @endif>
                    <div class="px-4 py-2 border rounded-xl text-sm font-semibold cursor-pointer transition-colors mobile-chip @if(empty(request('kategori'))) border-primary text-primary bg-primary/10 @else border-gray-200 text-gray-600 @endif">
                        Semua Kategori
                    </div>
                </label>
                @foreach($global_kategoris as $cat)
                <label class="shrink-0">
                    <input type="radio" name="kategori[]" value="{{ $cat->nama_kategori }}" class="hidden mobile-cat-radio" @if(in_array($cat->nama_kategori, request('kategori', []))) checked @endif>
                    <div class="flex items-center gap-2 px-4 py-2 border rounded-xl text-sm font-semibold cursor-pointer transition-colors mobile-chip @if(in_array($cat->nama_kategori, request('kategori', []))) border-primary text-primary bg-primary/10 @else border-gray-200 text-gray-600 @endif">
                        @if($cat->icon)<span class="material-symbols-outlined text-[16px]">{{ $cat->icon }}</span>@endif
                        {{ $cat->nama_kategori }}
                    </div>
                </label>
                @endforeach
            </div>

            <!-- Sorting & Filters -->
            <div class="flex items-center gap-2 px-4 py-2 justify-between">
                <div class="flex gap-2 flex-grow overflow-x-auto hide-scroll">
                    <select name="sort" class="bg-white border border-gray-200 rounded text-xs px-2 py-1.5 text-gray-600 focus:outline-none shrink-0 sort-select">
                        <option value="Terbaru" @if(request('sort') == 'Terbaru') selected @endif>Sortir: Terbaru</option>
                        <option value="Terpopuler" @if(request('sort') == 'Terpopuler') selected @endif>Sortir: Terpopuler</option>
                        <option value="Harga: Rendah ke Tinggi" @if(request('sort') == 'Harga: Rendah ke Tinggi') selected @endif>Harga: Rendah ke Tinggi</option>
                        <option value="Harga: Tinggi ke Rendah" @if(request('sort') == 'Harga: Tinggi ke Rendah') selected @endif>Harga: Tinggi ke Rendah</option>
                    </select>
                    <select class="bg-white border border-gray-200 rounded text-xs px-2 py-1.5 text-gray-600 focus:outline-none shrink-0">
                        <option>Garansi Pengiriman</option>
                    </select>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" class="border border-gray-200 p-1.5 rounded text-gray-600 flex items-center justify-center bg-white"><span class="material-symbols-outlined text-[16px]">swap_vert</span></button>
                    <button type="button" class="border border-gray-200 p-1.5 rounded text-gray-600 flex items-center justify-center bg-white"><span class="material-symbols-outlined text-[16px]">filter_alt</span></button>
                </div>
            </div>
            
            <div class="px-4 py-2 bg-slate-50 border-t border-gray-100 text-[10px] text-gray-500 flex justify-between items-center">
                <span>Hasil pencarian ditemukan: <strong>{{ $buku->total() }} produk</strong></span>
            </div>
        </div>
        
        <!-- Sidebar -->
        <aside class="hidden md:block w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-5 sticky top-24">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">filter_alt</span> Filter
                    </h2>
                    @if(request()->has('kategori') || request()->has('penerbit') || request()->has('search'))
                        <a href="{{ route('kategori') }}" class="text-xs text-red-500 hover:underline">Reset</a>
                    @endif
                </div>
                
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                
                <!-- Categories -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">KATEGORI</h3>
                    <div class="space-y-3">
                        @php
                            $selectedCategories = request('kategori', []);
                        @endphp
                        @forelse($global_kategoris as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="kategori[]" value="{{ $cat->nama_kategori }}" @if(in_array($cat->nama_kategori, $selectedCategories)) checked @endif class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">{{ $cat->nama_kategori }}</span>
                        </label>
                        @empty
                        <span class="text-xs text-slate-400 italic">Belum ada kategori</span>
                        @endforelse
                    </div>
                </div>

                <!-- Penerbit -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">PENERBIT</h3>
                    <div class="space-y-3">
                        @php
                            $selectedPenerbit = request('penerbit', []);
                        @endphp
                        @forelse($global_penerbits as $pub)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="penerbit[]" value="{{ $pub->nama_penerbit }}" @if(in_array($pub->nama_penerbit, $selectedPenerbit)) checked @endif class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors line-clamp-1" title="{{ $pub->nama_penerbit }}">{{ $pub->nama_penerbit }}</span>
                        </label>
                        @empty
                        <span class="text-xs text-slate-400 italic">Belum ada penerbit</span>
                        @endforelse
                    </div>
                </div>

                <!-- Penerbit / Pengarang -->
                <div>
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">PENGARANG</h3>
                    <div class="space-y-3">
                        @php
                            $dbPengarang = \App\Models\KatalogBuku::select('pengarang')->whereNotNull('pengarang')->where('pengarang', '!=', '')->distinct()->pluck('pengarang');
                            $selectedPengarang = request('pengarang', []);
                        @endphp
                        @foreach($dbPengarang as $pen)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="pengarang[]" value="{{ $pen }}" @if(in_array($pen, $selectedPengarang)) checked @endif class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors line-clamp-1" title="{{ $pen }}">{{ $pen }}</span>
                        </label>
                        @endforeach
                        @if($dbPengarang->isEmpty())
                            <span class="text-xs text-slate-400 italic">Belum ada data</span>
                        @endif
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow px-4 md:px-0 py-4 md:py-0 bg-slate-50 md:bg-transparent min-h-screen" id="main-content-area">
            <div class="hidden md:flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-primary mb-1">Hasil Pencarian</h2>
                    <p class="text-sm text-on-surface-variant">Menampilkan {{ $buku->firstItem() ?? 0 }}-{{ $buku->lastItem() ?? 0 }} dari {{ $buku->total() }} buku.</p>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <label class="text-sm text-on-surface-variant">Urutkan:</label>
                    <select name="sort" class="bg-white border border-outline-variant rounded-lg px-3 py-1.5 text-sm outline-none focus:border-primary sort-select">
                        <option value="Terbaru" @if(request('sort') == 'Terbaru') selected @endif>Terbaru</option>
                        <option value="Terpopuler" @if(request('sort') == 'Terpopuler') selected @endif>Terpopuler</option>
                        <option value="Harga: Rendah ke Tinggi" @if(request('sort') == 'Harga: Rendah ke Tinggi') selected @endif>Harga: Rendah ke Tinggi</option>
                        <option value="Harga: Tinggi ke Rendah" @if(request('sort') == 'Harga: Tinggi ke Rendah') selected @endif>Harga: Tinggi ke Rendah</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 relative" id="buku-grid">
                @forelse($buku as $item)
                <a href="{{ route('buku.detail', $item->id) }}" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-br {{ $item->cover_image }} @endif rounded-lg mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                        @if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
                            <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight relative z-10">{!! str_replace(' ', '<br>', $item->judul_buku) !!}</h4>
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                        @if($item->stok_dibutuhkan <= 0)
                            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-30 flex items-center justify-center pointer-events-none">
                                <span class="bg-primary text-white text-[12px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-md">Terpenuhi</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-gray-400 text-[9px] md:text-xs font-medium mb-1 inline-block">{{ $item->kategori }}</span>
                            <h3 class="text-xs md:text-sm font-semibold text-on-surface line-clamp-2 leading-tight mb-2 group-hover:text-primary transition-colors">{{ $item->judul_buku }}</h3>
                            <p class="hidden md:block text-[10px] text-on-surface-variant mb-2">{{ $item->pengarang }}</p>
                        </div>
                            <div class="flex flex-col gap-1 mt-auto pt-2">
                                <div>
                                    <p class="text-primary font-bold text-[13px] md:text-base whitespace-nowrap">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                                </div>
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="bg-surface-variant text-on-surface-variant w-6 h-6 md:w-8 md:h-8 rounded-full flex items-center justify-center cursor-not-allowed self-end mt-1" title="Admin Tidak Dapat Membeli">
                                    <span class="material-symbols-outlined text-[14px] md:text-[18px]">block</span>
                                </div>
                                @else
                                <div class="flex items-center gap-1.5 text-[10px] text-gray-500 mt-1">
                                    <span>{{ $item->stok_dibutuhkan }} dibutuhkan</span>
                                </div>
                                @endif
                            </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl mb-3">search_off</span>
                    <p class="font-medium">Tidak ada buku yang sesuai dengan pencarian Anda.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12" id="pagination-container">
                {{ $buku->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    
    // Gunakan event delegation agar tidak hilang saat main-content-area diganti
    form.addEventListener('change', function(e) {
        if(e.target.tagName === 'INPUT' && e.target.type === 'checkbox') {
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
        if(e.target.classList.contains('mobile-cat-radio')) {
            // Update active state for mobile chips
            document.querySelectorAll('.mobile-chip').forEach(chip => {
                chip.classList.remove('border-blue-500', 'text-blue-500', 'bg-blue-50');
                chip.classList.add('border-gray-200', 'text-gray-600');
            });
            const activeChip = e.target.nextElementSibling;
            activeChip.classList.remove('border-gray-200', 'text-gray-600');
            activeChip.classList.add('border-blue-500', 'text-blue-500', 'bg-blue-50');
            
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
        if(e.target.classList.contains('sort-select')) {
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
    });

    // Handle pagination links
    document.addEventListener('click', function(e) {
        let link = e.target.closest('#pagination-container a');
        if(link) {
            e.preventDefault();
            fetchResults(link.href.split('?')[1] || '');
        }
    });

    function fetchResults(queryString) {
        const url = '{{ route("kategori") }}?' + queryString;
        window.history.pushState({}, '', url);

        const mainContent = document.getElementById('main-content-area');
        if(mainContent) {
            mainContent.style.transition = 'opacity 0.2s ease-in-out';
            mainContent.style.opacity = '0.8'; // Sangat tipis agar tidak terasa seperti loading lama
        }

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('main-content-area');
            if(newContent) {
                const currentContent = document.getElementById('main-content-area');
                currentContent.innerHTML = newContent.innerHTML;
                currentContent.style.opacity = '1';
            }
        }).catch(err => {
            console.error(err);
            window.location.href = url;
        });
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        window.location.reload();
    });
});
</script>
@endsection
