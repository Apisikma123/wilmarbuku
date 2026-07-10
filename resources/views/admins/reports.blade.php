@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 p-4 md:p-0">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Analitik & Laporan</h2>
            <p class="text-slate-500 text-sm mt-1">Ringkasan performa sistem, transaksi, dan keterlibatan pengguna.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <select onchange="window.location.href='?filter=' + this.value" class="appearance-none pl-4 pr-10 py-2 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 outline-none focus:border-green-500 shadow-sm cursor-pointer">
                    <option value="6_months" {{ $filter == '6_months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                    <option value="this_year" {{ $filter == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="30_days" {{ $filter == '30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>
            
            <a href="{{ route('admin.reports.export') }}" class="flex items-center gap-2 px-5 py-2 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                Ekspor Laporan
            </a>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md">Realtime</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Donasi (Rp)</p>
            <h3 class="text-3xl font-bold text-slate-900">Rp {{ number_format($totalDonations, 0, ',', '.') }}</h3>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-md">Checkout</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Transaksi</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalTransactions) }}</h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
                <span class="inline-flex px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md">Selesai</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Transaksi Selesai</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ number_format($completedTransactions) }}</h3>
        </div>
    </div>

    <!-- Main Overall Chart -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col h-[400px]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h3 class="text-lg font-bold text-slate-900">
                    Aktivitas Keseluruhan
                    @if($filter == 'this_year') (Tahun Ini)
                    @elseif($filter == '30_days') (30 Hari Terakhir)
                    @else (6 Bulan Terakhir)
                    @endif
                </h3>
                <p class="text-sm text-slate-500">Perbandingan dana masuk dan distribusi buku.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                    <span class="w-3 h-3 rounded bg-green-900"></span> Dana (Rp)
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                    <span class="w-3 h-3 rounded bg-amber-500"></span> Buku
                </div>
            </div>
        </div>

        <!-- CSS Based Bar Chart -->
        <div class="flex-1 flex items-end gap-2 sm:gap-4 px-2 mt-auto border-b border-slate-200 pb-2 relative">
            
            <!-- Grid Lines Background -->
            <div class="absolute inset-0 flex flex-col justify-between z-0 border-t border-slate-100 pointer-events-none">
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full border-b border-slate-100 border-dashed flex-1"></div>
                <div class="w-full flex-1"></div>
            </div>

            @foreach($chartData as $data)
            <div class="flex-1 flex items-end justify-center gap-1 group relative z-10 h-full">
                <!-- Funds Bar -->
                <div class="w-full max-w-[20px] bg-green-900 rounded-t transition-opacity hover:opacity-80 cursor-pointer" 
                     style="height: {{ $data['funds'] > 0 ? max(10, ($data['funds'] / $maxFunds) * 100) : 10 }}%" 
                     title="Dana: Rp {{ number_format($data['funds'], 0, ',', '.') }}"></div>
                
                <!-- Books Bar -->
                <div class="w-full max-w-[20px] bg-amber-500 rounded-t transition-opacity hover:opacity-80 cursor-pointer" 
                     style="height: {{ $data['books'] > 0 ? max(10, ($data['books'] / $maxBooks) * 100) : 10 }}%" 
                     title="Buku: {{ $data['books'] }}"></div>
                
                <span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 uppercase">{{ $data['name'] }}</span>
            </div>
            @endforeach

        </div>
    </div>

</div>
@endsection

<script>
function filterTable(input) {
    let filter = input.value.toLowerCase();
    let table = input.closest('.shadow-sm').querySelector('table');
    if(!table) return;
    let tr = table.getElementsByTagName("tr");
    for (let i = 1; i < tr.length; i++) { 
        let txtValue = tr[i].textContent || tr[i].innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
