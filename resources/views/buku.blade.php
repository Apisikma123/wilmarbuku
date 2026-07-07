@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10 font-poppins">
    
    <nav class="flex items-center gap-2 text-sm font-medium text-on-surface-variant mb-10 overflow-x-auto whitespace-nowrap hide-scroll">
        <a href="/dashboard" class="hover:text-primary transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a href="#" class="hover:text-primary transition-colors">Katalog Buku</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="hover:text-primary transition-colors cursor-pointer">{{ $buku->kategori }}</span>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface font-semibold">{{ $buku->judul_buku }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        <div class="lg:col-span-4 lg:col-start-1 flex flex-col gap-6">
            <div class="rounded-lg p-4 md:p-8 flex items-center justify-center">
                <div class="w-full max-w-[260px] aspect-[3/4] rounded-lg shadow-lg flex items-center justify-center p-6 text-center text-white border border-black/5 relative overflow-hidden @if((!str_starts_with($buku->cover_image, '/storage/') && !str_starts_with($buku->cover_image, 'http'))) bg-gradient-to-br {{ $buku->cover_image }} @endif">
                    @if((str_starts_with($buku->cover_image, '/storage/') || str_starts_with($buku->cover_image, 'http')))
                        <img src="{{ $buku->cover_image }}" alt="{{ $buku->judul_buku }}" class="absolute inset-0 w-full h-full object-cover z-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>
                    @else
                        <div class="relative z-20">
                            <h4 class="text-xl md:text-2xl font-bold uppercase leading-tight mb-2 tracking-tight">{!! str_replace(' ', '<br/>', $buku->judul_buku) !!}</h4>
                            <p class="text-xs text-white border-t border-white/30 pt-2 mt-2 font-medium">Edisi Terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-5 flex flex-col items-center justify-center text-center gap-2 border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)]">
                    <span class="material-symbols-outlined text-primary text-[28px]">import_contacts</span>
                    <div>
                        <span class="block text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Halaman</span>
                        <span class="block text-sm font-semibold text-on-surface">{{ $buku->jumlah_halaman }}</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-5 flex flex-col items-center justify-center text-center gap-2 border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)]">
                    <span class="material-symbols-outlined text-primary text-[28px]">inventory_2</span>
                    <div>
                        <span class="block text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Dibutuhkan</span>
                        <span class="block text-sm font-semibold text-on-surface">{{ $buku->stok_dibutuhkan }} Buku</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#EDF6EE] rounded-lg p-5 border border-primary/20 flex items-start gap-4">
                <div class="bg-primary text-white p-2 rounded-full flex-shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-primary mb-1">Syarat Kelulusan</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Donasi buku ini valid sebagai syarat Surat Keterangan Bebas Pustaka bagi mahasiswa tingkat akhir.</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 flex flex-col">
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5 flex-wrap">
                    <span class="bg-[#EDF6EE] text-primary text-[12px] font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-primary/20">{{ $buku->kategori }}</span>
                    @if($buku->badge)
                    <span class="inline-flex bg-[#FFF9E6] text-[#996B00] text-[12px] font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-[#996B00]/20 items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">verified</span> <span>{{ $buku->badge }}</span>
                    </span>
                    @endif
                </div>
                
                <h1 class="text-3xl md:text-[36px] lg:text-[44px] font-bold text-on-surface tracking-tight mb-4 leading-[1.2]">{{ $buku->judul_buku }}</h1>
                <p class="text-lg text-on-surface-variant font-medium mb-8">Oleh <span class="text-on-surface font-semibold">{{ $buku->pengarang }}</span></p>
                
                <div class="flex items-baseline gap-3 mb-2 bg-surface-bright p-5 rounded-lg border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)] inline-block">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">Estimasi Harga Donasi</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl lg:text-[36px] font-bold text-primary tracking-tight">Rp {{ number_format($buku->harga_estimasi, 0, ',', '.') }}</span>
                        <span class="text-sm text-on-surface-variant font-medium">/ buku</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 lg:p-8 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 mb-10 transition-all hover:shadow-[0px_8px_30px_rgba(15,23,42,0.08)]">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-8 justify-between">
                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-bold text-on-surface-variant mb-3">Jumlah Donasi</label>
                        <div class="flex items-center bg-surface-bright rounded-full h-[52px] w-full md:w-[160px] p-1">
                            <button type="button" id="btn-minus" class="w-11 h-11 rounded-full text-on-surface-variant flex items-center justify-center hover:bg-surface-variant/30 transition-colors active:bg-surface-variant/50">
                                <span class="material-symbols-outlined font-bold text-[20px]">remove</span>
                            </button>
                            <input type="text" id="qty-input" value="1" readonly class="w-full h-full text-center bg-transparent border-none focus:ring-0 font-bold text-on-surface text-[17px] p-0">
                            <button type="button" id="btn-plus" class="w-11 h-11 rounded-full bg-[#E5ECE7] text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors active:scale-95">
                                <span class="material-symbols-outlined font-bold text-[20px]">add</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="w-full md:flex-1 flex flex-col items-end gap-3">
                        <div class="flex items-center justify-between md:justify-end w-full gap-4 mb-1">
                            <span class="text-sm text-on-surface-variant font-medium md:hidden">Total Donasi:</span>
                            <p class="text-sm text-on-surface-variant font-medium hidden md:block">Total:</p>
                            <span class="font-bold text-on-surface text-xl" id="subtotal-amount">Rp {{ number_format($buku->harga_estimasi, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 w-full justify-end mt-2">
                            <form action="{{ route('cart.add', $buku->id) }}" method="POST" class="w-full sm:w-auto flex-grow">
                                @csrf
                                <input type="hidden" name="qty" id="form-qty" value="1">
                                <button type="submit" class="w-full bg-white text-primary border border-primary font-semibold text-sm md:text-base h-[52px] rounded-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2 px-8">
                                    <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                    Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-outline-variant/30 flex-grow pt-8">
                <div class="flex items-center gap-8 border-b border-outline-variant/30 mb-8">
                    <button class="pb-3 text-primary font-bold border-b-[3px] border-primary text-base">Deskripsi Buku</button>
                </div>
                <div class="text-on-surface-variant text-base leading-relaxed space-y-5 prose prose-slate max-w-[75ch]">
                    {!! $buku->deskripsi !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const price = {{ $buku->harga_estimasi }};
    const maxQty = {{ $buku->stok_dibutuhkan }};
    let qty = 1;

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function render() {
        document.getElementById('subtotal-amount').textContent = formatRupiah(price * qty);
        document.getElementById('qty-input').value = qty;
        document.getElementById('form-qty').value = qty;
    }

    document.getElementById('btn-plus').addEventListener('click', () => {
        if (qty < maxQty) {
            qty++;
            render();
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Stok Maksimal',
                text: 'Anda tidak dapat mendonasikan lebih dari jumlah buku yang dibutuhkan saat ini.',
                confirmButtonColor: '#003215'
            });
        }
    });
    document.getElementById('btn-minus').addEventListener('click', () => {
        if (qty > 1) qty--;
        render();
    });
</script>
@endsection
