@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6 p-4 md:p-0">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Donasi Offline</h2>
            <p class="text-slate-500 mt-2">Input donasi buku secara offline mewakili donatur.</p>
        </div>
        <a href="{{ route('admin.transactions') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 font-medium transition-colors shadow-sm text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Riwayat Transaksi
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm mb-4">
        <div class="flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-error-container border border-error text-on-error-container px-4 py-3 rounded-xl flex items-center justify-between shadow-sm mb-4">
        <div class="flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-error"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-error hover:text-on-error-container"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ route('admin.obo.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Donatur (User)</label>
                <select name="user_id" id="user_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required>
                    <option value="">-- Pilih Donatur --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nama_lengkap }} ({{ $user->email }}) - {{ $user->identitas_kampus ?? 'Eksternal' }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Book Items Container -->
            <div id="book-items-container" class="space-y-6">
                <!-- Book Item Row -->
                <div class="book-item bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Buku</label>
                        <select name="buku_id[]" class="buku-select w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required onchange="calculateTotal()">
                            <option value="" data-price="0" data-stock="0">-- Pilih Buku --</option>
                            @foreach($buku as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->harga_estimasi }}" data-stock="{{ $item->stok_dibutuhkan }}">
                                    {{ $item->judul_buku }} (Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}) - Sisa Stok: {{ $item->stok_dibutuhkan }}
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Eksemplar</label>
                            <input type="number" name="qty[]" min="1" value="1" class="qty-input w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required oninput="calculateTotal()">
                            <p class="stock-warning text-red-500 text-xs mt-1 hidden">Kuantitas melebihi stok yang dibutuhkan.</p>
                            @error('qty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-end justify-end">
                            <button type="button" onclick="removeBookRow(this)" class="remove-book-btn hidden text-red-500 hover:text-red-700 text-sm font-semibold flex items-center gap-1 mb-3">
                                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add More Button -->
            <button type="button" onclick="addBookRow()" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 font-bold rounded-lg transition-colors text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Buku Lain
            </button>

            <!-- Total Harga Global -->
            <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                <div></div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Total Harga Keseluruhan</label>
                    <div class="w-full px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl font-bold text-lg flex items-center justify-between">
                        <span>Rp</span>
                        <span id="total_harga_display">0</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 flex justify-end">
                <button type="submit" id="submit-btn" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-sm shadow-green-600/20 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    Proses Donasi Offline
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TomSelect CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .ts-control {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        font-size: inherit !important;
    }
    .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input {
        cursor: pointer;
        font-family: inherit;
    }
</style>

<!-- TomSelect JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect for User
        new TomSelect("#user_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        // Initialize TomSelect for first Buku
        initTomSelect(document.querySelector('.buku-select'));
    });

    function initTomSelect(el) {
        new TomSelect(el, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            onChange: function(value) {
                calculateTotal();
            }
        });
    }

    function addBookRow() {
        const container = document.getElementById('book-items-container');
        // Get the original select HTML structure (without TomSelect wrappers)
        const templateHtml = `
            <div class="book-item bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative mt-4">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Buku</label>
                    <select name="buku_id[]" class="buku-select w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required onchange="calculateTotal()">
                        <option value="" data-price="0" data-stock="0">-- Pilih Buku --</option>
                        @foreach($buku as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->harga_estimasi }}" data-stock="{{ $item->stok_dibutuhkan }}">
                                {{ $item->judul_buku }} (Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}) - Sisa Stok: {{ $item->stok_dibutuhkan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Eksemplar</label>
                        <input type="number" name="qty[]" min="1" value="1" class="qty-input w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required oninput="calculateTotal()">
                        <p class="stock-warning text-red-500 text-xs mt-1 hidden">Kuantitas melebihi stok yang dibutuhkan.</p>
                    </div>
                    <div class="flex items-end justify-end">
                        <button type="button" onclick="removeBookRow(this)" class="remove-book-btn text-red-500 hover:text-red-700 text-sm font-semibold flex items-center gap-1 mb-3">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', templateHtml);
        
        const newRows = container.querySelectorAll('.book-item');
        const newlyAddedRow = newRows[newRows.length - 1];
        
        // Initialize TomSelect on the new select
        const newSelect = newlyAddedRow.querySelector('.buku-select');
        initTomSelect(newSelect);
        
        // Re-init lucide icons for the new trash icon
        if(window.lucide) {
            lucide.createIcons();
        }
        
        // Ensure remove buttons are visible if > 1 rows
        updateRemoveButtons();
    }

    function removeBookRow(btn) {
        const row = btn.closest('.book-item');
        row.remove();
        updateRemoveButtons();
        calculateTotal();
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.book-item');
        const removeBtns = document.querySelectorAll('.remove-book-btn');
        if (rows.length > 1) {
            removeBtns.forEach(btn => btn.classList.remove('hidden'));
        } else {
            removeBtns.forEach(btn => btn.classList.add('hidden'));
        }
    }

    function calculateTotal() {
        let globalTotal = 0;
        let hasError = false;
        const rows = document.querySelectorAll('.book-item');
        
        rows.forEach(row => {
            const selectEl = row.querySelector('.buku-select');
            const qtyInput = row.querySelector('.qty-input');
            const stockWarning = row.querySelector('.stock-warning');
            
            // Get the actual select element since TomSelect hides it
            if (selectEl.selectedIndex > 0) {
                const selectedOption = selectEl.options[selectEl.selectedIndex];
                const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
                const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                
                if (qty > stock) {
                    stockWarning.classList.remove('hidden');
                    hasError = true;
                } else {
                    stockWarning.classList.add('hidden');
                }
                
                globalTotal += price * qty;
            } else {
                stockWarning.classList.add('hidden');
            }
        });

        document.getElementById('total_harga_display').textContent = new Intl.NumberFormat('id-ID').format(globalTotal);
        
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = hasError || globalTotal === 0;
    }
</script>
@endsection
