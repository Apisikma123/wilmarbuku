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

        <div class="flex items-center gap-2 md:gap-3 mb-6 md:mb-8">
            <span class="material-symbols-outlined text-primary text-2xl md:text-3xl">shopping_bag</span>
            <h1 class="text-2xl md:text-3xl font-bold font-display text-on-surface tracking-tight">Keranjang Donasi</h1>
        </div>

        @if(session('error'))
        <div class="bg-error-container/20 border border-error/30 text-error px-4 py-4 rounded-xl flex items-start gap-3 shadow-sm mb-8">
            <span class="material-symbols-outlined shrink-0 mt-0.5 text-error">error</span>
            <div class="font-medium text-sm leading-relaxed">{{ session('error') }}</div>
            <button onclick="this.parentElement.remove()" class="text-error/70 hover:text-error ml-auto shrink-0"><span class="material-symbols-outlined text-[20px]">close</span></button>
        </div>
        @endif

        @if(session('success'))
        <div class="bg-primary/10 border border-primary/20 text-primary px-4 py-4 rounded-xl flex items-start gap-3 shadow-sm mb-8">
            <span class="material-symbols-outlined shrink-0 mt-0.5 text-primary">check_circle</span>
            <div class="font-medium text-sm leading-relaxed">{{ session('success') }}</div>
            <button onclick="this.parentElement.remove()" class="text-primary/70 hover:text-primary ml-auto shrink-0"><span class="material-symbols-outlined text-[20px]">close</span></button>
        </div>
        @endif
        
        <div id="cart-main-container" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-8 space-y-6">
                @if(isset($cart) && count($cart) > 0)
                    @php $total = 0; $count = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php 
                            $subtotal = $item['harga_estimasi'] * $item['qty'];
                            $total += $subtotal;
                            $count += $item['qty'];
                        @endphp
                        <!-- Cart Item -->
                        <div id="cart-item-{{ $id }}" class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-outline-variant/40 hover-lift transition-all group {{ $item['stok_dibutuhkan'] <= 0 ? 'opacity-50 grayscale bg-surface-container-low' : '' }}">
                            <div class="flex gap-3 md:gap-5">
                                <div class="flex items-start justify-center pt-1 md:pt-2">
                                    @if($item['stok_dibutuhkan'] > 0)
                                    <input type="checkbox" checked data-id="{{ $id }}" onchange="recalculateLocalCart()" class="item-checkbox w-5 h-5 md:w-6 md:h-6 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0 transition-colors cursor-pointer bg-white">
                                    @else
                                    <span class="material-symbols-outlined text-outline text-[20px] md:text-[24px]">block</span>
                                    @endif
                                </div>
                                <div class="flex-grow overflow-hidden">
                                    <!-- Header Info -->
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4 md:mb-5">
                                        <div class="flex gap-3 md:gap-5 w-full">
                                            <div class="w-20 h-28 md:w-24 md:h-36 rounded-xl shadow-md flex-shrink-0 relative overflow-hidden group-hover:shadow-lg transition-shadow bg-slate-900 flex items-center justify-center p-2 text-center text-white">
                                                <img src="{{ (str_starts_with($item['cover_image'] ?? '', '/storage/') || str_starts_with($item['cover_image'] ?? '', 'http')) ? $item['cover_image'] : asset('images/default-cover.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/40 z-10 pointer-events-none"></div>
                                                @if((!str_starts_with($item['cover_image'] ?? '', '/storage/') && !str_starts_with($item['cover_image'] ?? '', 'http')))
                                                    <h4 class="font-bold text-[10px] md:text-xs leading-tight tracking-tight relative z-20 pointer-events-none">{!! str_replace(' ', '<br/>', e($item['judul_buku'])) !!}</h4>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-between py-1 overflow-hidden w-full">
                                                <div>
                                                    <span class="inline-block px-2 py-1 md:px-2.5 md:py-1 bg-surface-container-low text-primary text-[9px] md:text-[10px] font-bold rounded-md mb-1.5 md:mb-2 uppercase tracking-wider">{{ $item['kategori'] }}</span>
                                                    @if($item['stok_dibutuhkan'] <= 0)
                                                    <span class="inline-block px-2 py-1 md:px-2.5 md:py-1 bg-error-container text-error text-[9px] md:text-[10px] font-bold rounded-md mb-1.5 md:mb-2 uppercase tracking-wider">Stok Terpenuhi</span>
                                                    @endif
                                                    <h3 class="font-bold text-on-surface leading-tight text-base md:text-xl mb-1 group-hover:text-primary transition-colors line-clamp-2">{{ $item['judul_buku'] }}</h3>
                                                    <p class="text-xs md:text-sm text-on-surface-variant font-medium truncate">Oleh: {{ $item['pengarang'] }}</p>
                                                </div>
                                                <p class="font-bold text-primary text-lg md:text-2xl mt-2 md:mt-4">Rp {{ number_format($item['harga_estimasi'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Informasi Pesanan -->
                                    <div class="bg-surface-bright rounded-xl p-3.5 md:p-5 border border-outline-variant/30">
                                        <h4 class="text-xs md:text-sm font-bold text-on-surface flex items-center gap-2 mb-3 md:mb-4">
                                            <span class="material-symbols-outlined text-primary text-[16px] md:text-[18px]">edit_note</span> Detail Penyaluran
                                        </h4>
                                        <form id="update-form-{{ $id }}" action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <div class="space-y-5">
                                                <div class="w-full relative">
                                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Pesan Dukungan (Opsional)</label>
                                                    <div class="relative">
                                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[18px]">chat</span>
                                                        <input type="text" name="pesan_dukungan" value="{{ $item['pesan_dukungan'] ?? '' }}" placeholder="Tulis semangat untuk penerima..." class="w-full bg-white border border-outline-variant/50 rounded-lg py-2.5 pl-10 pr-4 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm transition-shadow focus:shadow-md" onchange="submitUpdate(this.form)" {{ $item['stok_dibutuhkan'] <= 0 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between items-center gap-2 md:gap-5 pt-2 border-t border-outline-variant/30">
                                                    <div class="flex gap-2 shrink-0">
                                                        <button type="button" onclick="removeItem('{{ $id }}')" class="w-8 h-8 md:w-9 md:h-9 rounded-full text-outline-variant hover:text-error hover:bg-error/10 flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[18px] md:text-[20px]">delete</span></button>
                                                    </div>
                                                    <div class="h-6 w-px bg-outline-variant/40 shrink-0"></div>
                                                    <div class="flex items-center gap-1 bg-white border border-outline-variant/50 rounded-lg p-1 shadow-sm {{ $item['stok_dibutuhkan'] <= 0 ? 'opacity-50 pointer-events-none' : '' }}">
                                                        <button type="button" onclick="updateQty(this, -1)" class="w-7 h-7 rounded-md bg-surface-bright text-on-surface flex items-center justify-center hover:bg-outline-variant/20 transition-colors" {{ $item['stok_dibutuhkan'] <= 0 ? 'disabled' : '' }}><span class="material-symbols-outlined text-[18px]">remove</span></button>
                                                        <input type="number" name="qty" value="{{ $item['qty'] }}" data-price="{{ $item['harga_estimasi'] }}" class="qty-input font-bold text-sm w-12 text-center text-on-surface border-none focus:ring-0 p-0 bg-transparent" min="1" max="{{ $item['stok_dibutuhkan'] ?? 999 }}" readonly onchange="clearTimeout(updateTimeout); updateTimeout = setTimeout(() => submitUpdate(this.form), 400); recalculateLocalCart();" {{ $item['stok_dibutuhkan'] <= 0 ? 'disabled' : '' }}>
                                                        <button type="button" onclick="updateQty(this, 1)" class="w-7 h-7 rounded-md bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors" {{ $item['stok_dibutuhkan'] <= 0 ? 'disabled' : '' }}><span class="material-symbols-outlined text-[18px]">add</span></button>
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
            @if(isset($cart) && count($cart) > 0)
            <div class="lg:col-span-4 relative">
                <div class="bg-white rounded-2xl shadow-lg border border-outline-variant/20 p-7 sticky top-28">
                    <h3 class="font-bold text-on-surface text-xl mb-6 pb-4 border-b border-outline-variant/40 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">receipt_long</span> Ringkasan Donasi
                    </h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span id="summary-count" class="text-on-surface-variant font-medium">Total Harga ({{ $count }} Buku)</span>
                            <span id="summary-subtotal" class="font-bold text-on-surface">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
                        <p id="summary-total" class="text-2xl font-black text-primary tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    
                    @if($count > 0)
                    <a href="{{ route('checkout') }}" id="checkout-btn" onclick="checkoutCart(event)" class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined">payments</span> Donasikan Sekarang
                    </a>
                    @else
                    <button disabled id="checkout-btn" class="flex items-center justify-center gap-2 w-full bg-outline-variant/30 text-on-surface-variant font-bold py-4 rounded-xl cursor-not-allowed">
                        <span class="material-symbols-outlined">payments</span> Tidak Ada Buku
                    </button>
                    @endif
                    
                    <div class="mt-5 flex items-center justify-center gap-2 text-xs text-on-surface-variant font-medium bg-surface-container-low py-2 rounded-lg">
                        <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span> Transaksi Aman & Transparan
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

<script>
function formatRupiah(num) {
    return 'Rp ' + num.toLocaleString('id-ID').replace(/,/g, '.');
}

let updateTimeout;
window.isUpdatingCartLocally = false;

function setLocalUpdateFlag() {
    window.isUpdatingCartLocally = true;
    clearTimeout(window.localUpdateTimer);
    window.localUpdateTimer = setTimeout(() => window.isUpdatingCartLocally = false, 2000);
}

function updateQty(btn, delta) {
    setLocalUpdateFlag();
    const form = btn.closest('form');
    const input = form.querySelector('input[name="qty"]');
    let val = parseInt(input.value) + delta;
    let max = parseInt(input.getAttribute('max')) || 999;
    if (val < 1) val = 1;
    if (val > max) {
        Swal.fire({
            icon: 'info',
            title: 'Stok Maksimal',
            text: 'Anda tidak dapat mendonasikan lebih dari jumlah buku yang dibutuhkan saat ini.',
            confirmButtonColor: '#003215'
        });
        return;
    }
    input.value = val;
    
    recalculateLocalCart();
    clearTimeout(updateTimeout);
    updateTimeout = setTimeout(() => {
        submitUpdate(form);
    }, 400);
}

function checkoutCart(event) {
    event.preventDefault();
    const checkedBoxes = document.querySelectorAll('input.item-checkbox:checked');
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Buku',
            text: 'Silakan pilih minimal satu buku untuk didonasikan.',
            confirmButtonColor: '#003215'
        });
        return;
    }
    const ids = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-id')).join(',');
    window.location.href = `{{ route('checkout') }}?selected=` + ids;
}

function recalculateLocalCart() {
    let totalCheckedCount = 0;
    let totalCartCount = 0;
    let totalPrice = 0;
    const inputs = document.querySelectorAll('input.qty-input');
    inputs.forEach(input => {
        if(!input.disabled) {
            let qty = parseInt(input.value) || 0;
            let price = parseInt(input.getAttribute('data-price')) || 0;
            totalCartCount += qty;

            const itemDiv = input.closest('[id^="cart-item-"]');
            const checkbox = itemDiv ? itemDiv.querySelector('input.item-checkbox') : null;
            if (!checkbox || checkbox.checked) {
                totalCheckedCount += qty;
                totalPrice += (qty * price);
            }
        }
    });

    if(document.getElementById('summary-count')) {
        document.getElementById('summary-count').innerText = `Total Harga (${totalCheckedCount} Buku)`;
        document.getElementById('summary-subtotal').innerText = formatRupiah(totalPrice);
        document.getElementById('summary-total').innerText = formatRupiah(totalPrice);
    }
    
    ['cart-badge-desktop', 'cart-badge-mobile'].forEach(id => {
        const badge = document.getElementById(id);
        if (badge) {
            badge.innerText = totalCartCount;
            badge.style.display = totalCartCount > 0 ? 'flex' : 'none';
        }
    });
    
    // Disable/enable checkout button based on totalCheckedCount
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        if (totalCheckedCount > 0) {
            checkoutBtn.classList.remove('bg-outline-variant/30', 'text-on-surface-variant', 'cursor-not-allowed');
            checkoutBtn.classList.add('bg-primary', 'text-white', 'hover:bg-primary-container', 'shadow-md', 'hover:shadow-lg', 'transform', 'hover:-translate-y-0.5');
            checkoutBtn.style.pointerEvents = 'auto';
        } else {
            checkoutBtn.classList.add('bg-outline-variant/30', 'text-on-surface-variant', 'cursor-not-allowed');
            checkoutBtn.classList.remove('bg-primary', 'text-white', 'hover:bg-primary-container', 'shadow-md', 'hover:shadow-lg', 'transform', 'hover:-translate-y-0.5');
            checkoutBtn.style.pointerEvents = 'none';
        }
    }
}

function removeItem(id) {
    setLocalUpdateFlag();
    const itemDiv = document.getElementById('cart-item-' + id);
    if(itemDiv) {
        // Optimistic UI: hide and disable immediately
        itemDiv.style.opacity = '0';
        itemDiv.style.transform = 'scale(0.95)';
        itemDiv.style.pointerEvents = 'none';
        
        // Disable its input so it's not counted in local calculation
        const input = itemDiv.querySelector('input.qty-input');
        if(input) input.disabled = true;
        recalculateLocalCart();

        setTimeout(() => {
            itemDiv.remove();
            // Check if cart is empty after removal
            if(document.querySelectorAll('.qty-input').length === 0) {
                window.location.reload(); // Reload to show empty state if all removed
            }
        }, 300);
    }
    
    // Send background fetch request
    const form = document.getElementById('remove-form-' + id);
    if(form) {
        let formData = new FormData(form);
        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                ['cart-badge-desktop', 'cart-badge-mobile'].forEach(id => {
                    const badge = document.getElementById(id);
                    if (badge) {
                        badge.innerText = data.cart_count;
                        badge.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    }
                });
                recalculateLocalCart();
            }
        })
        .catch(err => console.error(err));
    }
}

function submitUpdate(form) {
    setLocalUpdateFlag();
    let formData = new FormData(form);
    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            ['cart-badge-desktop', 'cart-badge-mobile'].forEach(id => {
                const badge = document.getElementById(id);
                if (badge) {
                    badge.innerText = data.cart_count;
                    badge.style.display = data.cart_count > 0 ? 'flex' : 'none';
                }
            });
            recalculateLocalCart();
            
            // If item subtotal is needed, we update it too
            if (data.item_subtotal !== undefined) {
                const idInput = form.querySelector('input[name="id"]');
                if (idInput) {
                    const id = idInput.value;
                    const itemDiv = document.getElementById('cart-item-' + id);
                    if (itemDiv) {
                        const priceElem = itemDiv.querySelector('p.font-bold.text-primary.text-lg.md\\:text-2xl');
                        // Note: The UI previously showed base price. If we want it to show subtotal, we can update it.
                        // But UI design seems to show unit price.
                    }
                }
            }
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const setupCartPageEcho = () => {
        if(window.Echo) {
            window.Echo.private('user.{{ auth()->id() }}')
                .listen('CartUpdated', (e) => {
                    // Jika update berasal dari tab ini sendiri, abaikan agar tidak refresh DOM (mencegah scroll jump)
                    if (window.isUpdatingCartLocally) return;

                    // Cek apakah user sedang mengetik di input pesan, jika ya jangan refresh UI
                    const active = document.activeElement;
                    if (active && active.tagName === 'INPUT' && active.name === 'pesan_dukungan') {
                        return;
                    }
                    
                    fetch(window.location.href)
                        .then(res => res.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            const newContainer = doc.getElementById('cart-main-container');
                            const currentContainer = document.getElementById('cart-main-container');
                            
                            if (newContainer && currentContainer) {
                                currentContainer.innerHTML = newContainer.innerHTML;
                            }

                            // Update badges
                            ['cart-badge-desktop', 'cart-badge-mobile'].forEach(id => {
                                const badge = document.getElementById(id);
                                if (badge) {
                                    badge.innerText = e.cartCount;
                                    badge.style.display = e.cartCount > 0 ? 'flex' : 'none';
                                }
                            });
                        });
                });
        } else {
            setTimeout(setupCartPageEcho, 200);
        }
    };
    setupCartPageEcho();
});
</script>
@endsection
