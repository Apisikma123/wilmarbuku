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

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            {{ session('error') }}
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

            <!-- Book Selection -->
            <div>
                <label for="buku_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Buku</label>
                <select name="buku_id" id="buku_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required onchange="calculateTotal()">
                    <option value="" data-price="0" data-stock="0">-- Pilih Buku --</option>
                    @foreach($buku as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->harga_estimasi }}" data-stock="{{ $item->stok_dibutuhkan }}">
                            {{ $item->judul_buku }} (Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}) - Sisa Stok: {{ $item->stok_dibutuhkan }}
                        </option>
                    @endforeach
                </select>
                @error('buku_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label for="qty" class="block text-sm font-bold text-slate-700 mb-2">Jumlah Eksemplar</label>
                    <input type="number" name="qty" id="qty" min="1" value="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium" required oninput="calculateTotal()">
                    <p id="stock-warning" class="text-red-500 text-xs mt-1 hidden">Kuantitas melebihi stok yang dibutuhkan.</p>
                    @error('qty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Total Harga -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Total Harga</label>
                    <div class="w-full px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl font-bold text-lg flex items-center justify-between">
                        <span>Rp</span>
                        <span id="total_harga_display">0</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
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
<!-- TomSelect Tailwind theme (optional, standard works too but we adjust it with Tailwind classes below if needed) -->
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

        // Initialize TomSelect for Buku
        new TomSelect("#buku_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            onChange: function(value) {
                calculateTotal();
            }
        });
    });

    function calculateTotal() {
        const bookSelect = document.getElementById('buku_id');
        const qtyInput = document.getElementById('qty');
        const totalDisplay = document.getElementById('total_harga_display');
        const stockWarning = document.getElementById('stock-warning');
        const submitBtn = document.getElementById('submit-btn');
        
        if (bookSelect.selectedIndex > 0) {
            const selectedOption = bookSelect.options[bookSelect.selectedIndex];
            const price = parseInt(selectedOption.getAttribute('data-price'));
            const stock = parseInt(selectedOption.getAttribute('data-stock'));
            const qty = parseInt(qtyInput.value) || 0;
            
            // Check stock
            if (qty > stock) {
                stockWarning.classList.remove('hidden');
                submitBtn.disabled = true;
            } else {
                stockWarning.classList.add('hidden');
                submitBtn.disabled = false;
            }

            // Calculate total
            const total = price * qty;
            totalDisplay.textContent = new Intl.NumberFormat('id-ID').format(total);
        } else {
            totalDisplay.textContent = '0';
            stockWarning.classList.add('hidden');
            submitBtn.disabled = true;
        }
    }
</script>
@endsection
