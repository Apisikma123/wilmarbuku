@extends('layouts.user')

<style>
@media (max-width: 767px) {
    header { display: none !important; }
}
</style>

@section('content')
<div class="relative bg-[#00391a] bg-contain md:bg-cover bg-center bg-no-repeat text-white py-12 md:py-20 hidden md:block" style="background-image: url('{{ asset('images/dashboard banner.png') }}')">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-5xl font-bold font-display uppercase tracking-tight mb-4">Jelajahi Kategori</h1>
        <p class="text-white/80 max-w-xl mx-auto text-sm md:text-base">Temukan ratusan buku menarik dari berbagai kategori untuk mendukung literasi dan perkuliahan Anda.</p>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-0 md:px-6 py-0 md:py-12">
    <!-- Filters & Results -->
    <form id="filterForm" action="{{ route('kategori') }}" method="GET" class="flex flex-col md:flex-row gap-0 md:gap-10">
        <input type="hidden" name="sort" id="hidden-sort" value="{{ request('sort', 'Terbaru') }}">
        
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
                    <select class="bg-white border border-gray-200 rounded text-xs pl-2 pr-8 py-1.5 text-gray-600 focus:outline-none shrink-0 min-w-[210px] sort-select-display">
                        <option value="Terbaru" @if(request('sort') == 'Terbaru') selected @endif>Sortir: Terbaru</option>
                        <option value="Terpopuler" @if(request('sort') == 'Terpopuler') selected @endif>Sortir: Terpopuler</option>
                        <option value="Harga: Rendah ke Tinggi" @if(request('sort') == 'Harga: Rendah ke Tinggi') selected @endif>Harga: Rendah ke Tinggi</option>
                        <option value="Harga: Tinggi ke Rendah" @if(request('sort') == 'Harga: Tinggi ke Rendah') selected @endif>Harga: Tinggi ke Rendah</option>
                        <option disabled>--- Label / Badge ---</option>
                        <option value="Trending" @if(request('sort') == 'Trending') selected @endif>Trending</option>
                        <option value="Prioritas" @if(request('sort') == 'Prioritas') selected @endif>Prioritas</option>
                        <option value="Rekomendasi" @if(request('sort') == 'Rekomendasi') selected @endif>Rekomendasi</option>
                        <option value="Pilihan Utama" @if(request('sort') == 'Pilihan Utama') selected @endif>Pilihan Utama</option>
                    </select>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button id="mobile-sort-toggle-btn" type="button" class="border border-gray-200 p-1.5 rounded text-gray-600 flex items-center justify-center bg-white" title="Urutkan Harga"><span class="material-symbols-outlined text-[16px]">swap_vert</span></button>
                    <button id="mobile-filter-btn" type="button" class="border border-gray-200 p-1.5 rounded text-gray-600 flex items-center justify-center bg-white" title="Filter"><span class="material-symbols-outlined text-[16px]">filter_alt</span></button>
                </div>
            </div>
            
            <div class="px-4 py-2 bg-slate-50 border-t border-gray-100 text-[10px] text-gray-500 flex justify-between items-center">
                <span id="mobile-product-count">Hasil pencarian ditemukan: <strong>{{ $buku->total() }} produk</strong></span>
            </div>
        </div>
        
        <!-- Sidebar Drawer Backdrop (Mobile only) -->
        <div id="filter-backdrop" class="fixed inset-0 bg-black/50 z-[190] opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>

        <!-- Sidebar -->
        <aside id="filter-sidebar" class="fixed inset-y-0 right-0 z-[200] w-[80%] max-w-[320px] bg-white transform translate-x-full transition-transform duration-300 ease-in-out p-6 overflow-y-auto md:static md:w-64 md:translate-x-0 md:z-auto md:bg-transparent md:p-0 md:overflow-visible flex-shrink-0">
            <div class="md:bg-white md:rounded-xl md:shadow-sm md:border border-outline-variant/30 md:p-5 sticky md:top-24">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">filter_alt</span> Filter
                    </h2>
                    <div class="flex items-center gap-3">
                        <div id="reset-filter-container">
                            @if(!empty(request('kategori')) || !empty(request('penerbit')) || !empty(request('search')) || !empty(request('pengarang')))
                                <a href="{{ route('kategori') }}" class="text-xs text-red-500 hover:underline">Reset</a>
                            @endif
                        </div>
                        <button type="button" id="close-filter-btn" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
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
                    <select class="bg-white border border-outline-variant rounded-lg pl-3 pr-10 py-1.5 text-sm outline-none focus:border-primary min-w-[210px] sort-select-display">
                        <option value="Terbaru" @if(request('sort') == 'Terbaru') selected @endif>Terbaru</option>
                        <option value="Terpopuler" @if(request('sort') == 'Terpopuler') selected @endif>Terpopuler</option>
                        <option value="Harga: Rendah ke Tinggi" @if(request('sort') == 'Harga: Rendah ke Tinggi') selected @endif>Harga: Rendah ke Tinggi</option>
                        <option value="Harga: Tinggi ke Rendah" @if(request('sort') == 'Harga: Tinggi ke Rendah') selected @endif>Harga: Tinggi ke Rendah</option>
                        <option disabled>--- Label / Badge ---</option>
                        <option value="Trending" @if(request('sort') == 'Trending') selected @endif>Trending</option>
                        <option value="Prioritas" @if(request('sort') == 'Prioritas') selected @endif>Prioritas</option>
                        <option value="Rekomendasi" @if(request('sort') == 'Rekomendasi') selected @endif>Rekomendasi</option>
                        <option value="Pilihan Utama" @if(request('sort') == 'Pilihan Utama') selected @endif>Pilihan Utama</option>
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
                                <div class="flex items-center justify-between gap-1">
                                    <p class="text-primary font-bold text-[13px] md:text-base whitespace-nowrap">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                                    @if($item->badge)
                                        @php
                                            $badgeColor = match($item->badge) {
                                                'Prioritas' => 'bg-red-50 text-red-600 border border-red-200',
                                                'Rekomendasi' => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                                                'Trending' => 'bg-orange-50 text-orange-600 border border-orange-200',
                                                'Pilihan Utama' => 'bg-blue-50 text-blue-600 border border-blue-200',
                                                default => 'bg-slate-50 text-slate-600 border border-slate-200',
                                            };
                                        @endphp
                                        <span class="px-1.5 py-0.5 text-[8px] md:text-[9px] font-bold rounded {{ $badgeColor }} whitespace-nowrap shadow-sm">
                                            {{ strtoupper($item->badge) }}
                                        </span>
                                    @endif
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
            if(e.target.name === 'kategori[]') {
                syncMobileChips();
            }
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
        if(e.target.classList.contains('mobile-cat-radio')) {
            const val = e.target.value;
            // Uncheck all desktop category checkboxes first
            document.querySelectorAll('input[name="kategori[]"][type="checkbox"]').forEach(cb => {
                cb.checked = (cb.value === val);
            });

            // Update active state for mobile chips
            document.querySelectorAll('.mobile-chip').forEach(chip => {
                chip.classList.remove('border-primary', 'text-primary', 'bg-primary/10');
                chip.classList.add('border-gray-200', 'text-gray-600');
            });
            const activeChip = e.target.nextElementSibling;
            activeChip.classList.remove('border-gray-200', 'text-gray-600');
            activeChip.classList.add('border-primary', 'text-primary', 'bg-primary/10');
            
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
        if(e.target.classList.contains('sort-select-display')) {
            const val = e.target.value;
            document.getElementById('hidden-sort').value = val;
            document.querySelectorAll('.sort-select-display').forEach(sel => {
                sel.value = val;
            });
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        }
    });

    // Toggle sorting asc/desc on swap_vert click
    const swapVertBtn = document.getElementById('mobile-sort-toggle-btn');
    if(swapVertBtn) {
        swapVertBtn.addEventListener('click', function() {
            const hiddenSort = document.getElementById('hidden-sort');
            let currentVal = hiddenSort.value;
            let newVal = 'Harga: Rendah ke Tinggi';
            if (currentVal === 'Harga: Rendah ke Tinggi') {
                newVal = 'Harga: Tinggi ke Rendah';
            } else if (currentVal === 'Harga: Tinggi ke Rendah') {
                newVal = 'Harga: Rendah ke Tinggi';
            }
            hiddenSort.value = newVal;
            document.querySelectorAll('.sort-select-display').forEach(sel => {
                sel.value = newVal;
            });
            fetchResults(new URLSearchParams(new FormData(form)).toString());
        });
    }

    // Mobile filter drawer toggle
    const filterBtn = document.getElementById('mobile-filter-btn');
    const closeFilterBtn = document.getElementById('close-filter-btn');
    const filterSidebar = document.getElementById('filter-sidebar');
    const filterBackdrop = document.getElementById('filter-backdrop');

    if(filterBtn && filterSidebar && filterBackdrop) {
        filterBtn.addEventListener('click', function() {
            filterSidebar.classList.remove('translate-x-full');
            filterSidebar.classList.add('translate-x-0');
            filterBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            filterBackdrop.classList.add('opacity-100', 'pointer-events-auto');
            document.body.classList.add('overflow-hidden'); // Prevent background scrolling
        });
    }

    function closeFilterDrawer() {
        if(filterSidebar && filterBackdrop) {
            filterSidebar.classList.remove('translate-x-0');
            filterSidebar.classList.add('translate-x-full');
            filterBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
            filterBackdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }

    if(closeFilterBtn) {
        closeFilterBtn.addEventListener('click', closeFilterDrawer);
    }
    if(filterBackdrop) {
        filterBackdrop.addEventListener('click', closeFilterDrawer);
    }

    function syncMobileChips() {
        const checkedCats = Array.from(document.querySelectorAll('input[name="kategori[]"][type="checkbox"]:checked')).map(cb => cb.value);
        
        // Reset all chips style
        document.querySelectorAll('.mobile-chip').forEach(chip => {
            chip.classList.remove('border-primary', 'text-primary', 'bg-primary/10');
            chip.classList.add('border-gray-200', 'text-gray-600');
        });

        let targetVal = null;
        if (checkedCats.length === 1) {
            targetVal = checkedCats[0];
        } else if (checkedCats.length === 0) {
            targetVal = "";
        }

        // Find the radio input with the target value
        const radios = document.querySelectorAll('.mobile-cat-radio');
        radios.forEach(radio => {
            if (radio.value === targetVal) {
                radio.checked = true;
                const chipDiv = radio.nextElementSibling;
                chipDiv.classList.remove('border-gray-200', 'text-gray-600');
                chipDiv.classList.add('border-primary', 'text-primary', 'bg-primary/10');
            } else {
                radio.checked = false;
            }
        });
    }

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
        window.history.replaceState({}, '', url);

        const mainContent = document.getElementById('main-content-area');
        if(mainContent) {
            mainContent.style.transition = 'opacity 0.2s ease-in-out';
            mainContent.style.opacity = '0.8';
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
            // Update mobile product count if it exists
            const newMobileCount = doc.getElementById('mobile-product-count');
            const currentMobileCount = document.getElementById('mobile-product-count');
            if (newMobileCount && currentMobileCount) {
                currentMobileCount.innerHTML = newMobileCount.innerHTML;
            }
            // Update reset button container if it exists
            const newResetContainer = doc.getElementById('reset-filter-container');
            const currentResetContainer = document.getElementById('reset-filter-container');
            if (newResetContainer && currentResetContainer) {
                currentResetContainer.innerHTML = newResetContainer.innerHTML;
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
