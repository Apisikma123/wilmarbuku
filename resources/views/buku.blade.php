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
                <div id="product-cover-image" class="w-full max-w-[260px] aspect-[3/4] rounded-lg shadow-lg flex items-center justify-center p-6 text-center text-white border border-black/5 relative overflow-hidden @if((!str_starts_with($buku->cover_image, '/storage/') && !str_starts_with($buku->cover_image, 'http'))) bg-gradient-to-br {{ $buku->cover_image }} @endif">
                    @if((str_starts_with($buku->cover_image, '/storage/') || str_starts_with($buku->cover_image, 'http')))
                        <img src="{{ $buku->cover_image }}" alt="{{ $buku->judul_buku }}" class="absolute inset-0 w-full h-full object-cover z-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10 pointer-events-none"></div>
                    @else
                        <div class="relative z-20 pointer-events-none">
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
                            @if($buku->stok_dibutuhkan <= 0)
                            <button type="button" disabled class="w-full sm:w-auto flex-grow bg-surface-variant text-on-surface-variant font-semibold text-sm md:text-base h-[52px] rounded-lg flex items-center justify-center gap-2 cursor-not-allowed">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                Target Buku Terpenuhi
                            </button>
                            @elseif(Auth::check() && isset(Auth::user()->cart_data[$buku->id]) && Auth::user()->cart_data[$buku->id]['qty'] >= $buku->stok_dibutuhkan)
                            <button type="button" disabled class="w-full sm:w-auto flex-grow bg-surface-variant text-on-surface-variant font-semibold text-sm md:text-base h-[52px] rounded-lg flex items-center justify-center gap-2 cursor-not-allowed">
                                <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                                Maksimal di Keranjang
                            </button>
                            @elseif(auth()->check() && auth()->user()->role === 'admin')
                            <button type="button" disabled class="w-full sm:w-auto flex-grow bg-surface-variant text-on-surface-variant font-semibold text-sm md:text-base h-[52px] rounded-lg flex items-center justify-center gap-2 cursor-not-allowed">
                                <span class="material-symbols-outlined text-[20px]">block</span>
                                Admin Tidak Dapat Membeli
                            </button>
                            @else
                            <form id="add-to-cart-form" action="{{ route('cart.add', $buku->id) }}" method="POST" class="w-full sm:w-auto flex-grow flex gap-3">
                                @csrf
                                <input type="hidden" name="qty" id="form-qty" value="1">
                                <input type="hidden" name="action" id="form-action" value="cart">
                                <button type="button" onclick="submitForm('cart')" class="flex-1 bg-white text-primary border border-primary font-semibold text-sm md:text-base h-[52px] rounded-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                    Keranjang
                                </button>
                                <button type="button" onclick="submitForm('checkout')" class="flex-1 bg-primary text-white font-semibold text-sm md:text-base h-[52px] rounded-lg hover:bg-primary-container transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">payments</span>
                                    Beli Langsung
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-outline-variant/30 flex-grow pt-8">
                <div class="flex items-center gap-8 border-b border-outline-variant/30 mb-8">
                    <button class="pb-3 text-primary font-bold border-b-[3px] border-primary text-base">Deskripsi Buku</button>
                </div>
                <div class="text-on-surface-variant text-base leading-relaxed space-y-5 prose prose-slate max-w-[75ch]">
                    {!! nl2br(htmlspecialchars($buku->deskripsi, ENT_QUOTES, 'UTF-8')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@if($buku_terkait->count() > 0)
<div class="w-full bg-surface-container-low py-12 mt-12 border-t border-outline-variant/30">
    <div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-on-surface tracking-tight">Buku Terkait Kategori {{ $buku->kategori }}</h2>
            <a href="/kategori" class="bg-transparent border border-outline-variant text-primary font-semibold text-sm px-4 py-2 rounded-md hover:bg-primary/5 transition-colors">Lihat Semua</a>
        </div>
        
        <div class="relative group/slider">
            <div id="related-books-container" class="flex gap-6 overflow-x-auto hide-scroll snap-x snap-mandatory pb-8 pt-2">
                @foreach($buku_terkait as $item)
                <div class="bg-white rounded-[8px] shadow-[0_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 hover:-translate-y-[2px] hover:shadow-[0_8px_30px_rgba(15,23,42,0.08)] transition-all duration-300 flex flex-col w-[240px] md:w-[260px] flex-shrink-0 snap-start relative overflow-hidden">
                    <a href="{{ route('buku.detail', $item->id) }}" class="flex-grow flex flex-col block">
                        <!-- Image Area -->
                        <div class="w-full aspect-[5/3] relative @if((!str_starts_with($item->cover_image, '/storage/') && !str_starts_with($item->cover_image, 'http'))) bg-gradient-to-br {{ $item->cover_image }} @endif flex items-center justify-center p-3 text-white text-center">
                            @if((str_starts_with($item->cover_image, '/storage/') || str_starts_with($item->cover_image, 'http')))
                                <img src="{{ $item->cover_image }}" alt="{{ $item->judul_buku }}" class="absolute inset-0 w-full h-full object-cover z-0">
                                <div class="absolute inset-0 bg-black/40 z-10 pointer-events-none"></div>
                                <h3 class="font-bold text-xs leading-snug tracking-tight relative z-20 pointer-events-none">{{ $item->judul_buku }}</h3>
                            @else
                                <h3 class="font-bold text-xs leading-snug tracking-tight relative z-20 pointer-events-none">{!! str_replace(' ', '<br/>', $item->judul_buku) !!}</h3>
                            @endif
                            @if($item->stok_dibutuhkan <= 0)
                                <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-30 flex items-center justify-center pointer-events-none">
                                    <span class="bg-primary text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-md">Terpenuhi</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Text Area -->
                        <div class="p-4 md:p-5 flex flex-col flex-grow">
                            <h3 class="text-[13px] md:text-sm font-semibold text-on-surface mb-2 line-clamp-2 leading-relaxed">{{ $item->judul_buku }}</h3>
                            <p class="text-[11px] text-outline mb-5">{{ $item->kategori }}</p>
                            
                            <p class="text-primary font-bold text-sm md:text-base mb-5 mt-auto">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                            
                            <div class="flex justify-between items-center text-[10px] text-outline font-medium">
                                <span class="text-primary">{{ $item->stok_dibutuhkan }} Dibutuhkan</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            <button onclick="scrollRelated(1)" class="absolute right-0 top-[40%] -translate-y-1/2 translate-x-4 w-12 h-12 bg-white shadow-[0_4px_20px_rgba(15,23,42,0.15)] rounded-full text-on-surface flex items-center justify-center hover:bg-surface-bright transition-colors z-10 opacity-0 group-hover/slider:opacity-100 hidden md:flex active:scale-95">
                <span class="material-symbols-outlined text-[24px]">chevron_right</span>
            </button>
            <button onclick="scrollRelated(-1)" class="absolute left-0 top-[40%] -translate-y-1/2 -translate-x-4 w-12 h-12 bg-white shadow-[0_4px_20px_rgba(15,23,42,0.15)] rounded-full text-on-surface flex items-center justify-center hover:bg-surface-bright transition-colors z-10 opacity-0 group-hover/slider:opacity-100 hidden md:flex active:scale-95">
                <span class="material-symbols-outlined text-[24px]">chevron_left</span>
            </button>
        </div>
    </div>
</div>

    <style>
    .hide-scroll::-webkit-scrollbar { display: none; }
    .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    
    <script>
    function scrollRelated(direction) {
        const container = document.getElementById('related-books-container');
        const scrollAmount = 280;
        container.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
    }
    </script>
    @endif
</div>

<script>
    const price = {{ $buku->harga_estimasi }};
    const maxQty = {{ $buku->stok_dibutuhkan }};
    let qty = 1;

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function render() {
        if (maxQty > 0) {
            document.getElementById('subtotal-amount').textContent = formatRupiah(price * qty);
            document.getElementById('qty-input').value = qty;
            if(document.getElementById('form-qty')) {
                document.getElementById('form-qty').value = qty;
            }
        }
    }

    if(maxQty > 0) {
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
    }

    function flyToCart() {
        const cartBtns = document.querySelectorAll('a[href="/cart"]');
        let cartBtn = null;
        cartBtns.forEach(btn => {
            if(btn.offsetParent !== null) {
                cartBtn = btn;
            }
        });
        
        if(!cartBtn) return;
        
        const productImgContainer = document.getElementById('product-cover-image');
        const productImg = productImgContainer ? (productImgContainer.querySelector('img') || productImgContainer) : null;
        if(!productImg) return;
        
        const imgClone = productImg.cloneNode(true);
        const rect = productImg.getBoundingClientRect();
        const cartRect = cartBtn.getBoundingClientRect();
        
        imgClone.style.position = 'fixed';
        imgClone.style.top = rect.top + 'px';
        imgClone.style.left = rect.left + 'px';
        imgClone.style.width = rect.width + 'px';
        imgClone.style.height = rect.height + 'px';
        imgClone.style.zIndex = '9999';
        imgClone.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        imgClone.style.borderRadius = '8px';
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
        }, 50);
        
        setTimeout(() => {
            imgClone.remove();
            cartBtn.style.transition = 'transform 0.3s ease';
            cartBtn.style.transform = 'scale(1.3)';
            setTimeout(() => {
                cartBtn.style.transform = 'scale(1)';
            }, 300);
        }, 800);
    }

    function submitForm(action) {
        document.getElementById('form-action').value = action;
        if (action === 'checkout') {
            document.getElementById('add-to-cart-form').submit();
        } else {
            // Trigger animation first
            flyToCart();
            
            let form = document.getElementById('add-to-cart-form');
            let formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                    }).then(() => {
                        // Update cart badges
                        const badges = document.querySelectorAll('.bg-secondary.text-white.text-\\[9px\\]');
                        if(badges.length > 0) {
                            badges.forEach(badge => {
                                badge.innerText = data.cart_count;
                            });
                        }
                    });
                } else {
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
                console.error(err);
                document.getElementById('add-to-cart-form').submit();
            });
        }
    }
</script>
@endsection
