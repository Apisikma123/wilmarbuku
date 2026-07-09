@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kelola Transaksi Donasi</h2>
            <p class="text-slate-500 text-sm mt-1">Konfirmasi pembayaran, update status pengiriman, dan kirim pemberitahuan ke donatur.</p>
        </div>
        <button onclick="document.getElementById('modal-metode-pembayaran').classList.remove('hidden')" class="bg-[#003215] hover:bg-[#004b23] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm flex items-center justify-center gap-2 transition-colors">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Tambah Metode Transaksi
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    @endif

    <!-- Total Donation Summary -->
    <div class="bg-gradient-to-br from-green-900 via-green-800 to-green-950 rounded-2xl p-8 lg:p-10 shadow-xl text-white flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden border border-green-800">
        <div class="absolute right-0 top-0 w-80 h-80 bg-green-400 opacity-10 rounded-full blur-3xl -translate-y-1/3 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute left-0 bottom-0 w-64 h-64 bg-green-500 opacity-10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-6 w-full">
            <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-inner shrink-0">
                <i data-lucide="wallet" class="w-10 h-10 text-green-100"></i>
            </div>
            <div>
                <h3 class="text-green-200 font-bold uppercase tracking-widest text-xs mb-1.5">Total Donasi Terkumpul</h3>
                <div class="flex flex-col sm:flex-row sm:items-end gap-3 sm:gap-4 mt-2">
                    <span class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-white drop-shadow-sm">Rp {{ number_format($totalDonations, 0, ',', '.') }}</span>
                    <span class="text-sm font-bold text-green-100 mb-2 inline-flex items-center gap-1.5 bg-green-950/40 border border-green-700/50 px-2.5 py-1 rounded-lg backdrop-blur-sm self-center sm:self-auto">
                        <i data-lucide="trending-up" class="w-4 h-4 text-green-400"></i> Realtime Status
                    </span>
                </div>
                <p class="text-green-100/70 text-sm mt-3 max-w-md">Total nominal donasi dari transaksi terverifikasi dalam sistem.</p>
            </div>
        </div>
    </div>

    <!-- Payment Methods Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="wallet" class="w-5 h-5 text-green-700"></i> Daftar Metode Pembayaran
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($metodes as $metode)
                <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between group hover:border-green-600/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm uppercase">
                            {{ substr($metode->nama_bank, 0, 3) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">{{ $metode->nama_bank }}</h4>
                            <p class="text-xs font-mono text-slate-500">{{ $metode->nomor_rekening }}</p>
                            <p class="text-[10px] text-slate-400">a/n {{ $metode->atas_nama }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.metode.destroy', $metode->id) }}" method="POST" onsubmit="return confirm('Hapus metode pembayaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-6 text-center text-slate-400 text-sm italic border border-dashed border-slate-200 rounded-xl">
                    Belum ada metode pembayaran. Silakan tambah metode transaksi.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-[11px] font-bold text-slate-500 mb-1 leading-tight uppercase tracking-wider">Belum Dibayar</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ number_format($pendingPayments) }} Transaksi</h3>
        </div>
        
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i data-lucide="truck" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-[11px] font-bold text-slate-500 mb-1 leading-tight uppercase tracking-wider">Dalam Pengiriman</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ number_format($inProcess) }} Transaksi</h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-[11px] font-bold text-slate-500 mb-1 leading-tight uppercase tracking-wider">Selesai</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ number_format($completed) }} Transaksi</h3>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <form method="GET" action="{{ route('admin.transactions') }}" class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50 flex-wrap gap-4">
            <h3 class="text-lg font-bold text-slate-900">Daftar Transaksi</h3>
            <div class="relative w-64 shrink-0 flex items-center gap-2">
                <div class="relative w-full">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode/nama..." class="w-full bg-white border border-slate-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                </div>
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">Cari</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 font-black uppercase tracking-widest bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Kode Tracking</th>
                        <th class="px-6 py-4">Donatur / User</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4 text-center">Status Pembayaran</th>
                        <th class="px-6 py-4 text-center">Metode</th>
                        <th class="px-6 py-4">Status Tracking</th>
                        <th class="px-6 py-4 text-center">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">
                            #{{ $trx->kode_tracking }}
                            <div class="text-[10px] font-normal text-slate-400">{{ $trx->tanggal_checkout ? \Carbon\Carbon::parse($trx->tanggal_checkout)->format('d M Y H:i') : $trx->created_at->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-green-100 text-green-800 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($trx->user->nama_lengkap ?? 'US', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">{{ $trx->user->nama_lengkap ?? 'User' }}</div>
                                    <div class="text-xs text-slate-500">{{ $trx->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap min-w-[200px]">
                            <div class="font-bold text-slate-900 text-sm cursor-pointer hover:text-green-700 transition-colors" onclick="document.getElementById('buku-expand-{{ $trx->kode_tracking }}').classList.toggle('hidden')">
                                {{ $trx->details->first()->buku->judul_buku ?? 'Buku Donasi' }}
                                @if($trx->details->count() > 1)
                                <span class="text-xs text-slate-400 font-normal ml-1">(+{{ $trx->details->count() - 1 }} item lainnya) <i data-lucide="chevron-down" class="w-3 h-3 inline"></i></span>
                                @else
                                <span class="text-xs text-slate-400 font-normal ml-1"><i data-lucide="chevron-down" class="w-3 h-3 inline"></i></span>
                                @endif
                            </div>
                            
                            <div id="buku-expand-{{ $trx->kode_tracking }}" class="hidden mt-2 p-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-normal text-slate-600 whitespace-normal min-w-[200px]">
                                <ul class="space-y-3">
                                    @foreach($trx->details as $detail)
                                    <li class="border-b border-slate-100 pb-2 last:border-0 last:pb-0">
                                        <div class="font-medium text-slate-700">&bull; {{ $detail->buku->judul_buku ?? 'Buku Donasi' }} <span class="text-slate-400">(x{{ $detail->qty }})</span></div>
                                        @if($detail->pesan_dukungan && !in_array($trx->status_tracking, ['Menunggu Pembayaran']))
                                            <div class="mt-1.5 ml-2 p-2 bg-blue-50 border-l-2 border-blue-400 rounded-r text-[10px] text-slate-600 italic">
                                                <i data-lucide="message-square" class="w-3 h-3 inline mr-1 text-blue-500"></i> "{{ $detail->pesan_dukungan }}"
                                            </div>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="text-xs font-medium text-slate-500 mt-2">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($trx->status_pembayaran == 'Paid')
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Lunas</span>
                            @elseif($trx->status_pembayaran == 'Failed')
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Gagal</span>
                            @elseif($trx->bukti_pembayaran)
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 whitespace-nowrap">Menunggu Konfirmasi</span>
                            @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Belum Dibayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($trx->metodePembayaran)
                            <div class="inline-flex px-2 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-lg text-[11px] font-bold">
                                {{ $trx->metodePembayaran->nama_bank }}
                            </div>
                            @else
                            <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full {{ $trx->status_tracking == 'Selesai' ? 'bg-emerald-500' : ($trx->status_tracking == 'Dibatalkan' ? 'bg-red-500' : ($trx->status_tracking == 'Dalam Pengiriman' ? 'bg-blue-500' : 'bg-amber-500')) }}"></div>
                                    <span class="text-sm font-bold text-slate-800">{{ $trx->status_tracking }}</span>
                                </div>
                                @if($trx->status_tracking == 'Dibatalkan' && $trx->alasan_pembatalan)
                                <p class="text-[11px] text-red-600 bg-red-50 p-1.5 rounded border border-red-100 mt-1 max-w-xs">
                                    <strong>Alasan:</strong> {{ $trx->alasan_pembatalan }}
                                </p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Ubah Status Manual & Kirim Pesan -->
                                @if(in_array($trx->status_tracking, ['Selesai', 'Dibatalkan']) || in_array($trx->status_pembayaran, ['Failed', 'Expired']))
                                    @if($trx->status_tracking == 'Selesai')
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold flex items-center gap-1">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Telah Selesai
                                    </span>
                                    @else
                                    <span class="px-3 py-1.5 bg-red-50 text-red-400 rounded-lg text-xs font-bold flex items-center gap-1 border border-red-100">
                                        <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Dibatalkan
                                    </span>
                                    @endif
                                @else
                                <button onclick='openStatusModal({{ json_encode($trx) }})' class="px-3 py-1.5 border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Update Pesanan">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Update Pesanan
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                            <p class="text-base font-bold text-slate-600">Belum ada transaksi donasi.</p>
                            <p class="text-sm text-slate-400 mt-1">Transaksi pengguna yang telah menyelesaikan donasi akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Modal Update Status Manual & Kirim Pesan -->
<div id="statusModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-6 h-6 text-green-900"></i>
                Update Pesanan
            </h3>
            <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form id="statusForm" method="POST" class="space-y-4">
            @csrf
            
            <div id="buktiPembayaranContainerStatus" class="hidden mb-4">
                <label class="block text-xs font-bold uppercase text-slate-600 mb-2">Bukti Pembayaran Donatur</label>
                <a id="buktiPembayaranLinkStatus" href="#" target="_blank" class="block group relative rounded-lg border border-slate-200 overflow-hidden bg-slate-50">
                    <img id="buktiPembayaranImgStatus" src="" alt="Bukti Pembayaran" class="w-full h-auto max-h-60 object-contain group-hover:opacity-80 transition-opacity">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="bg-black/70 text-white px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5"><i data-lucide="external-link" class="w-3.5 h-3.5"></i> Buka Penuh</span>
                    </div>
                </a>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pilih Status Baru *</label>
                <select id="modal_status_tracking" name="status_tracking" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 bg-white">
                    <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                    <option value="Dana Diterima">Dana Diterima</option>
                    <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pesan Khusus ke Inbox Donatur (Opsional)</label>
                <textarea name="pesan_admin" rows="3" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Ketik pesan yang ingin Anda sampaikan langsung ke kotak masuk pengguna..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeStatusModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-green-900 text-white rounded-lg text-sm font-bold hover:bg-green-800 shadow-sm">Simpan & Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>

    <!-- Modal Tambah Metode Pembayaran -->
    <div id="modal-metode-pembayaran" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl relative">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Tambah Metode Transaksi</h3>
                <button onclick="document.getElementById('modal-metode-pembayaran').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-200/50 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">X</span>
                </button>
            </div>
            
            <form action="{{ route('admin.metode.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Metode Apa yang Mau Ditambah?</label>
                        <select name="tipe" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:ring-green-600 focus:border-green-600">
                            <option value="Bank Transfer">Transfer Bank</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Bank Apa?</label>
                        <input type="text" name="nama_bank" placeholder="Contoh: BCA, Mandiri, BNI" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:ring-green-600 focus:border-green-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" placeholder="Masukkan nomor rekening..." required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:ring-green-600 focus:border-green-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Atas Nama</label>
                        <input type="text" name="atas_nama" placeholder="Contoh: Admin WilmarBOOKS" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:ring-green-600 focus:border-green-600">
                    </div>
                </div>
                
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-metode-pembayaran').classList.add('hidden')" class="flex-1 bg-white border border-slate-200 text-slate-600 font-bold py-2.5 rounded-xl hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 bg-[#003215] text-white font-bold py-2.5 rounded-xl hover:bg-[#004b23] transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

<script>
function openStatusModal(trx) {
    document.getElementById('statusForm').action = "/admin/transactions/status/" + trx.kode_tracking;
    document.getElementById('modal_status_tracking').value = trx.status_tracking || 'Menunggu Konfirmasi';
    
    if (trx.bukti_pembayaran) {
        document.getElementById('buktiPembayaranImgStatus').src = trx.bukti_pembayaran;
        document.getElementById('buktiPembayaranLinkStatus').href = trx.bukti_pembayaran;
        document.getElementById('buktiPembayaranContainerStatus').classList.remove('hidden');
    } else {
        document.getElementById('buktiPembayaranContainerStatus').classList.add('hidden');
    }
    
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

function filterTable(input) {
    let filter = input.value.toLowerCase();
    let table = input.closest('.rounded-xl').querySelector('table');
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
