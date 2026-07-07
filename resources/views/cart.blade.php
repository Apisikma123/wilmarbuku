@extends('layouts.user')

@section('content')
    <div class="flex-grow max-w-[1280px] mx-auto w-full px-6 py-10">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="javascript:void(0)" onclick="if(document.referrer) { window.history.back(); } else { window.location.href='/'; }" class="inline-flex items-center text-sm font-medium text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-lg mr-1">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-primary text-3xl">shopping_bag</span>
            <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight">Keranjang Donasi</h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-8 space-y-6">
                @if(session('cart') && count(session('cart')) > 0)
                    @php $total = 0; $count = 0; @endphp
                    @foreach(session('cart') as $id => $item)
                        @php 
                            $subtotal = $item['harga_estimasi'] * $item['qty'];
                            $total += $subtotal;
                            $count += $item['qty'];
                        @endphp
                        <!-- Cart Item -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all group">
                            <div class="flex gap-5">
                                <div class="flex items-start justify-center pt-2">
                                    <input type="checkbox" checked class="w-6 h-6 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0 transition-colors cursor-pointer bg-white">
                                </div>
                                <div class="flex-grow">
                                    <!-- Header Info -->
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-5">
                                        <div class="flex gap-5">
                                            <div class="w-24 h-36 rounded-xl shadow-md flex-shrink-0 relative overflow-hidden group-hover:shadow-lg transition-shadow @if((!str_starts_with($item['cover_image'] ?? '', '/storage/') && !str_starts_with($item['cover_image'] ?? '', 'http'))) bg-gradient-to-br {{ $item['cover_image'] ?? 'from-primary to-primary-container' }} @endif flex items-center justify-center p-2 text-center text-white">
                                                @if((str_starts_with($item['cover_image'] ?? '', '/storage/') || str_starts_with($item['cover_image'] ?? '', 'http')))
                                                    <img src="{{ $item['cover_image'] }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                                                @else
                                                    <h4 class="font-bold text-xs leading-tight tracking-tight relative z-20">{!! str_replace(' ', '<br/>', $item['judul_buku']) !!}</h4>
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>
                                            </div>
                                            <div class="flex flex-col justify-between py-1">
                                                <div>
                                                    <span class="inline-block px-2.5 py-1 bg-surface-container-low text-primary text-[10px] font-bold rounded-md mb-2 uppercase tracking-wider">{{ $item['kategori'] }}</span>
                                                    <h3 class="font-bold text-on-surface leading-tight text-xl mb-1 group-hover:text-primary transition-colors line-clamp-2">{{ $item['judul_buku'] }}</h3>
                                                    <p class="text-sm text-on-surface-variant font-medium">Oleh: {{ $item['pengarang'] }}</p>
                                                </div>
                                                <p class="font-bold text-primary text-2xl mt-4">Rp {{ number_format($item['harga_estimasi'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Informasi Pesanan -->
                                    <div class="bg-surface-bright rounded-xl p-5 border border-outline-variant/30">
                                        <h4 class="text-sm font-bold text-on-surface flex items-center gap-2 mb-4">
                                            <span class="material-symbols-outlined text-primary text-[18px]">edit_note</span> Detail Penyaluran
                                        </h4>
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <div class="space-y-5">
                                                <div class="w-full relative">
                                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Pesan Dukungan (Opsional)</label>
                                                    <div class="relative">
                                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[18px]">chat</span>
                                                        <input type="text" name="pesan_dukungan" value="{{ $item['pesan_dukungan'] ?? '' }}" placeholder="Tulis semangat untuk penerima..." class="w-full bg-white border border-outline-variant/50 rounded-lg py-2.5 pl-10 pr-4 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm transition-shadow focus:shadow-md" onchange="this.form.submit()">
                                                    </div>
                                                </div>
                                                <div class="flex justify-end items-center gap-5 pt-2 border-t border-outline-variant/30">
                                                    <div class="flex gap-2">
                                                        <button type="button" onclick="event.preventDefault(); document.getElementById('remove-form-{{ $id }}').submit();" class="w-9 h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                                    </div>
                                                    <div class="h-6 w-px bg-outline-variant/40"></div>
                                                    <div class="flex items-center gap-1 bg-white border border-outline-variant/50 rounded-lg p-1 shadow-sm">
                                                        <button type="button" onclick="updateQty(this, -1)" class="w-7 h-7 rounded-md bg-surface-bright text-on-surface flex items-center justify-center hover:bg-outline-variant/20 transition-colors"><span class="material-symbols-outlined text-[18px]">remove</span></button>
                                                        <input type="number" name="qty" value="{{ $item['qty'] }}" class="font-bold text-sm w-12 text-center text-on-surface border-none focus:ring-0 p-0 bg-transparent" min="1" onchange="this.form.submit()">
                                                        <button type="button" onclick="updateQty(this, 1)" class="w-7 h-7 rounded-md bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><span class="material-symbols-outlined text-[18px]">add</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form id="remove-form-{{ $id }}" action="{{ route('cart.remove') }}" method="POST" class="hidden">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-2xl p-10 shadow-sm border border-outline-variant/40 text-center">
                        <span class="material-symbols-outlined text-outline-variant text-5xl mb-4">production_quantity_limits</span>
                        <h3 class="text-xl font-bold text-on-surface mb-2">Keranjang Kosong</h3>
                        <p class="text-on-surface-variant mb-6">Anda belum memilih buku untuk didonasikan.</p>
                        <a href="/kategori" class="inline-flex bg-primary text-white font-semibold py-2.5 px-6 rounded-lg hover:bg-primary-container transition-colors">Pilih Buku</a>
                    </div>
                @endif
            </div>
            
            <!-- Right Column: Summary -->
            @if(session('cart') && count(session('cart')) > 0)
            <div class="lg:col-span-4 relative">
                <div class="bg-white rounded-2xl shadow-lg border border-outline-variant/20 p-7 sticky top-28">
                    <h3 class="font-bold text-on-surface text-xl mb-6 pb-4 border-b border-outline-variant/40 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">receipt_long</span> Ringkasan Donasi
                    </h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Total Harga ({{ $count }} Buku)</span>
                            <span class="font-bold text-on-surface">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Biaya Penyaluran</span>
                            <span class="font-bold text-primary">Gratis</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mb-8 pt-4 border-t border-outline-variant/40">
                        <div>
                            <p class="text-sm text-on-surface-variant font-medium mb-1">Total Pembayaran</p>
                            <p class="text-[10px] text-on-surface-variant/80">Termasuk pajak & biaya admin</p>
                        </div>
                        <p class="text-2xl font-black text-primary tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined">payments</span> Donasikan Sekarang
                    </a>
                    
                    <div class="mt-5 flex items-center justify-center gap-2 text-xs text-on-surface-variant font-medium bg-surface-container-low py-2 rounded-lg">
                        <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span> Transaksi Aman & Transparan
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

<script>
function updateQty(btn, delta) {
    const input = btn.parentNode.querySelector('input[name="qty"]');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    input.form.submit();
}
</script>
@endsection
