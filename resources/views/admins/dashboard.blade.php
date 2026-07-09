@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 p-4 md:p-0">

        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Overview Dashboard</h2>
                <p class="text-slate-500 text-sm mt-1">Selamat datang kembali. Berikut yang sedang terjadi di hub hari ini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard.export') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Ekspor Data
                </a>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('admin.transactions') }}"
                class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition-all cursor-pointer group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-700 group-hover:bg-green-100 transition-colors">
                        <i data-lucide="hand-coins" class="w-5 h-5"></i>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> Realtime
                    </span>
                </div>
                <div>
                    <p
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-slate-700 transition-colors">
                        Total Donasi</p>
                    <h3 class="text-3xl font-bold text-slate-900">Rp {{ number_format($totalDonations, 0, ',', '.') }}</h3>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.dibutuhkan') }}"
                class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-amber-300 transition-all cursor-pointer group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors">
                        <i data-lucide="book-copy" class="w-5 h-5"></i>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold">
                        Target Stok
                    </span>
                </div>
                <div>
                    <p
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-amber-700 transition-colors">
                        Buku Dibutuhkan</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($booksNeeded) }}</h3>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('admin.catalog') }}"
                class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-blue-300 transition-all cursor-pointer group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors">
                        <i data-lucide="book" class="w-5 h-5"></i>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold">
                        Katalog
                    </span>
                </div>
                <div>
                    <p
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-blue-700 transition-colors">
                        Total Buku</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalBooks) }}</h3>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('admin.users') }}"
                class="block bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all cursor-pointer group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                        Pengguna Terdaftar
                    </span>
                </div>
                <div>
                    <p
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-emerald-700 transition-colors">
                        Total Pengguna</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalUsers) }}</h3>
                </div>
            </a>
        </div>

        <!-- Charts & Highlight Section -->
        <div class="mb-6">
            <!-- Donation Trends Chart -->
            <div class="w-full bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col h-[350px]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Tren Donasi</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <span class="w-3 h-3 rounded-full bg-green-900"></span> Total Dana
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span> Buku
                        </div>
                    </div>
                </div>

                <div class="flex-1 flex items-end gap-2 sm:gap-4 px-2 mt-auto border-b border-slate-200 pb-2 relative">

                    <!-- Grid Lines Background -->
                    <div
                        class="absolute inset-0 flex flex-col justify-between z-0 border-t border-slate-100 pointer-events-none">
                        <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                        <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                        <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                        <div class="w-full flex-1"></div>
                    </div>

                    @foreach($chartData as $data)
                        <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                            <!-- Funds Bar -->
                            <div class="w-full max-w-[20px] sm:max-w-[30px] bg-green-900 rounded-t transition-opacity hover:opacity-80 cursor-pointer"
                                style="height: {{ $data['funds'] > 0 ? max(10, ($data['funds'] / $maxFunds) * 100) : 10 }}%"
                                title="Dana: Rp {{ number_format($data['funds'], 0, ',', '.') }}"></div>

                            <!-- Books Bar -->
                            <div class="w-full max-w-[20px] sm:max-w-[30px] bg-amber-500 rounded-t transition-opacity hover:opacity-80 cursor-pointer"
                                style="height: {{ $data['books'] > 0 ? max(10, ($data['books'] / $maxBooks) * 100) : 10 }}%"
                                title="Buku: {{ $data['books'] }}"></div>

                            <span
                                class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">{{ $data['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-8">
            <div
                class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50 flex-wrap gap-4">
                <h3 class="text-lg font-bold text-slate-900">Transaksi Terkini</h3>
                <div class="flex items-center gap-4">
                    <a href="transactions"
                        class="text-sm font-semibold text-slate-500 hover:text-green-700 transition-colors">Lihat Semua</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-xs text-slate-500 uppercase bg-white border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-bold tracking-wider">ID Transaksi</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Donatur / User</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Judul Buku</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Nominal</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentTransactions as $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">#{{ $trx->kode_tracking }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($trx->user->nama_lengkap ?? 'US', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $trx->user->nama_lengkap ?? 'User' }}</div>
                                            <div class="text-xs text-slate-500">{{ $trx->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $trx->details->first()->buku->judul_buku ?? 'Buku Donasi' }}
                                    @if($trx->details->count() > 1)
                                        <span class="text-xs text-slate-400">(+{{ $trx->details->count() - 1 }} lainnya)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $trx->tanggal_checkout ? \Carbon\Carbon::parse($trx->tanggal_checkout)->format('d M Y') : $trx->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">Rp
                                    {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($trx->status_tracking == 'Selesai')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold
                                                            uppercase tracking-wide">Selesai</span>
                                    @elseif($trx->status_tracking == 'Dalam Pengiriman')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold
                                                            uppercase tracking-wide">Pengiriman</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold
                                                            uppercase tracking-wide">{{ $trx->status_tracking }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada transaksi terkini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script>
    function filterTable(input) {
        let filter = input.value.toLowerCase();
        // find the closest table inside the parent card (div.bg-white)
        let table = input.closest('.shadow-sm').querySelector('table');
        if (!table) return;
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) { // start from 1 to skip thead
            let txtValue = tr[i].textContent || tr[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
</script>