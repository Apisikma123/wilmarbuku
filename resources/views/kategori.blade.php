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
    <div class="flex flex-col md:flex-row gap-10">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-5 sticky top-24">
                <h2 class="text-lg font-bold text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">filter_alt</span> Filter
                </h2>
                
                <!-- Categories -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">KATEGORI</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" checked class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">E-Book Eksklusif</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Buku Donasi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Jurnal Akademik</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Modul Kuliah</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Sains & Teknologi</span>
                        </label>
                    </div>
                </div>

                <!-- Penerbit -->
                <div>
                    <h3 class="text-xs font-bold text-primary mb-4 uppercase tracking-widest">PENERBIT</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Erlangga</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm text-on-surface-variant group-hover:text-primary transition-colors">Gramedia</span>
                        </label>
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
                    <select class="bg-white border border-outline-variant rounded-lg px-3 py-1.5 text-sm outline-none focus:border-primary">
                        <option>Terbaru</option>
                        <option>Terpopuler</option>
                        <option>Harga: Rendah ke Tinggi</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($buku as $item)
                <a href="{{ route('buku.detail', $item->id) }}" class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/20 p-3 hover:-translate-y-1 hover:shadow-[0px_8px_24px_rgba(15,23,42,0.08)] transition-all cursor-pointer flex flex-col h-full block group">
                    <div class="w-full aspect-[3/4] bg-gradient-to-br {{ $item->cover_image }} rounded-lg mb-3 flex items-center justify-center p-2 text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Detail</span>
                        </div>
                        <h4 class="text-[10px] md:text-xs font-bold uppercase leading-tight relative z-10">{!! str_replace(' ', '<br>', $item->judul_buku) !!}</h4>
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
    </div>
</div>
@endsection
