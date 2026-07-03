@extends('layouts.user')

@section('content')
<div class="bg-gradient-to-b from-primary to-[#004b23] relative text-white py-12 md:py-20">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-5xl font-bold font-display uppercase tracking-tight mb-4">Jelajahi Kategori</h1>
        <p class="text-white/80 max-w-xl mx-auto text-sm md:text-base">Temukan ratusan buku menarik dari berbagai kategori untuk mendukung literasi dan perkuliahan Anda.</p>
    </div>
</div>



<div class="max-w-[1280px] mx-auto px-4 md:px-6 py-12">
    <!-- Filters & Results -->
    <form id="filterForm" action="{{ route('kategori') }}" method="GET" class="flex flex-col md:flex-row gap-10">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 flex-shrink-0">
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
                            $dbCategories = ['Teknologi & Informasi', 'Ekonomi & Bisnis', 'Sains & Matematika', 'Sosial & Budaya', 'Pengembangan Diri', 'Fiksi & Sastra', 'Umum'];
                            $selectedCategories = request('kategori', []);
                        @endphp
                        @foreach($dbCategories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="kategori[]" value="{{ $cat }}" onchange="document.getElementById('filterForm').submit()" @if(in_array($cat, $selectedCategories)) checked @endif class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">{{ $cat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Penerbit / Pengarang -->
                <div>
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">PENGARANG</h3>
                    <div class="space-y-3">
                        @php
                            $dbPenerbit = \App\Models\KatalogBuku::select('pengarang')->whereNotNull('pengarang')->where('pengarang', '!=', '')->distinct()->pluck('pengarang');
                            $selectedPenerbit = request('penerbit', []);
                        @endphp
                        @foreach($dbPenerbit as $pen)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="penerbit[]" value="{{ $pen }}" onchange="document.getElementById('filterForm').submit()" @if(in_array($pen, $selectedPenerbit)) checked @endif class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors line-clamp-1" title="{{ $pen }}">{{ $pen }}</span>
                        </label>
                        @endforeach
                        @if($dbPenerbit->isEmpty())
                            <span class="text-xs text-slate-400 italic">Belum ada data</span>
                        @endif
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-primary mb-1">Hasil Pencarian</h2>
                    <p class="text-sm text-on-surface-variant">Menampilkan {{ $buku->firstItem() ?? 0 }}-{{ $buku->lastItem() ?? 0 }} dari {{ $buku->total() }} buku.</p>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <label class="text-sm text-on-surface-variant">Urutkan:</label>
                    <select name="sort" onchange="document.getElementById('filterForm').submit()" class="bg-white border border-outline-variant rounded-lg px-3 py-1.5 text-sm outline-none focus:border-primary">
                        <option value="Terbaru" @if(request('sort') == 'Terbaru') selected @endif>Terbaru</option>
                        <option value="Terpopuler" @if(request('sort') == 'Terpopuler') selected @endif>Terpopuler</option>
                        <option value="Harga: Rendah ke Tinggi" @if(request('sort') == 'Harga: Rendah ke Tinggi') selected @endif>Harga: Rendah ke Tinggi</option>
                        <option value="Harga: Tinggi ke Rendah" @if(request('sort') == 'Harga: Tinggi ke Rendah') selected @endif>Harga: Tinggi ke Rendah</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($buku as $item)
                <a href="{{ route('buku.detail', $item->id) }}" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] @if(!str_starts_with($item->cover_image, '/storage/')) bg-gradient-to-br {{ $item->cover_image }} @endif rounded-lg mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                        @if(str_starts_with($item->cover_image, '/storage/'))
                            <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight relative z-10">{!! str_replace(' ', '<br>', $item->judul_buku) !!}</h4>
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                    </div>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="bg-secondary/10 text-secondary text-[9px] font-bold px-1.5 py-0.5 rounded uppercase mb-1.5 inline-block">{{ $item->kategori }}</span>
                            <h3 class="text-xs md:text-sm font-bold text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">{{ $item->judul_buku }}</h3>
                            <p class="text-[10px] text-on-surface-variant mb-2">{{ $item->pengarang }}</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto pt-3 border-t border-outline-variant/20">
                            <div>
                                <p class="text-primary font-bold text-sm md:text-base">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                            </button>
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
            <div class="mt-12">
                {{ $buku->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </form>
</div>
@endsection
