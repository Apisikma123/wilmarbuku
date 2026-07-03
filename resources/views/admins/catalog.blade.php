@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Wishlist Katalog Buku</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola daftar buku yang diajukan dan dibutuhkan untuk perpustakaan.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openAddModal()" class="flex items-center gap-2 px-4 py-2.5 bg-green-900 hover:bg-green-800 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="plus-square" class="w-4 h-4"></i>
                Tambah Buku Baru
            </button>
        </div>
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

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                <i data-lucide="book-open" class="w-6 h-6 text-slate-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalPengajuan) }} Judul</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <a href="{{ route('admin.dibutuhkan') }}" class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6 hover:shadow-md hover:border-amber-300 transition-all cursor-pointer group">
            <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center text-amber-700 shrink-0 group-hover:bg-amber-100 transition-colors">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-amber-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 group-hover:text-amber-700 transition-colors">Dibutuhkan Segera</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ number_format($dibutuhkanSegera) }} Judul</h3>
            </div>
        </a>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6 text-emerald-700"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Berhasil Tersedia</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ number_format($berhasilTersedia) }} Judul</h3>
            </div>
        </div>
    </div>

    <!-- Wishlist Detail Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50 flex-wrap gap-4">
            <h3 class="text-lg font-bold text-slate-900">Daftar Katalog Buku</h3>
            <div class="relative w-64 shrink-0">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" onkeyup="filterTable(this)" placeholder="Cari buku..." class="w-full bg-white border border-slate-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">ID</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Judul Buku</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Pengarang</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Stok</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Harga Est.</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $b)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900">#WL-{{ str_pad($b->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                @if($b->cover_image)
                                    @if(str_starts_with($b->cover_image, '/storage/'))
                                        <img src="{{ $b->cover_image }}" alt="Cover" class="w-10 h-14 object-cover rounded shadow-sm border border-slate-200 shrink-0">
                                    @else
                                        <div class="w-10 h-14 rounded shadow-sm border border-slate-200 shrink-0 bg-gradient-to-br {{ $b->cover_image }} flex items-center justify-center overflow-hidden">
                                            <span class="text-[5px] text-white font-bold leading-[1.1] text-center p-0.5 uppercase break-all">{!! str_replace(' ', '<br>', $b->judul_buku) !!}</span>
                                        </div>
                                    @endif
                                @else
                                <div class="w-10 h-14 bg-slate-100 border border-slate-200 rounded flex items-center justify-center text-slate-400 shrink-0">
                                    <i data-lucide="book" class="w-5 h-5"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-900 text-sm max-w-xs truncate">{{ $b->judul_buku }}</div>
                                    <div class="text-xs text-slate-400 font-normal">{{ $b->kategori ?? 'Umum' }} @if($b->badge)<span class="ml-1 px-1.5 py-0.5 bg-green-50 text-green-700 rounded text-[10px] font-bold">{{ $b->badge }}</span>@endif</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-slate-600">{{ $b->pengarang }}</td>
                        <td class="px-6 py-5 text-center font-bold text-slate-700">{{ number_format($b->stok_dibutuhkan) }}</td>
                        <td class="px-6 py-5 font-bold text-slate-900 text-right">Rp {{ number_format($b->harga_estimasi, 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-center">
                            @if($b->status_buku == 'Dibutuhkan')
                            <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Dibutuhkan</span>
                            @else
                            <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2 text-slate-400">
                                <button onclick='openEditModal({{ json_encode($b) }})' class="p-1.5 hover:text-slate-900 hover:bg-slate-100 rounded transition-colors" title="Edit Buku">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.catalog.delete', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Hapus Buku">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i data-lucide="book-open" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                            <p class="text-base font-bold text-slate-600">Belum ada buku di dalam katalog.</p>
                            <p class="text-sm text-slate-400 mt-1">Klik tombol "Tambah Buku Baru" di atas untuk menambahkan buku pertama Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-6 h-6 text-green-900"></i>
                Tambah Buku Baru
            </h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form action="{{ route('admin.catalog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                <input type="text" name="judul_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: Manajemen Strategi Bisnis Modern">
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pengarang / Penulis *</label>
                    <input type="text" name="pengarang" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Nama pengarang">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori (Pilih 1 atau lebih) *</label>
                    <div class="w-full border border-slate-200 rounded-lg p-3 bg-slate-50 max-h-48 overflow-y-auto mb-2">
                        <div id="category_list_add" class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="kategori[]" value="{{ $cat->nama_kategori }}" class="w-4 h-4 text-green-600 rounded border-slate-300 focus:ring-green-600">
                                <span class="text-slate-700">{{ $cat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                        <div class="border-t border-slate-200 pt-3 mt-2 flex items-center gap-2">
                            <input type="text" id="new_category_input_add" class="flex-1 border border-slate-200 rounded-lg px-3 py-1.5 text-xs outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Ketik kategori baru...">
                            <button type="button" onclick="addCategoryAJAX('add')" class="px-3 py-1.5 bg-slate-800 text-white text-xs font-bold rounded-lg hover:bg-slate-700 transition-colors whitespace-nowrap">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Harga Estimasi (Rp) *</label>
                    <input type="number" name="harga_estimasi" required min="0" step="1000" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="150000">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stok Dibutuhkan *</label>
                    <input type="number" name="stok_dibutuhkan" required min="1" value="1" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Status Buku *</label>
                    <select name="status_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="Dibutuhkan">Dibutuhkan</option>
                        <option value="Tersedia">Tersedia</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Jumlah Halaman</label>
                    <input type="text" name="jumlah_halaman" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: 320 Halaman">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Badge / Label (Opsional)</label>
                    <input type="text" name="badge" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: Pilihan Utama / Trending">
                </div>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                <p class="text-xs font-bold uppercase text-slate-700">Gambar Sampul / Cover Buku</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Upload Berkas Gambar (Maks. 2MB)</label>
                        <input type="file" name="cover_file" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-green-900 file:text-white hover:file:bg-green-800 transition-colors">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2 Megabyte.</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Atau Gunakan Link URL Gambar</label>
                        <input type="text" name="cover_image" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-green-600 bg-white" placeholder="https://domain.com/image.jpg">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Tulis deskripsi atau sinopsis singkat buku ini..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-green-900 text-white rounded-lg text-sm font-bold hover:bg-green-800 shadow-sm">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Buku -->
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="pencil" class="w-6 h-6 text-green-900"></i>
                Edit Informasi Buku
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                <input type="text" id="edit_judul_buku" name="judul_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pengarang / Penulis *</label>
                    <input type="text" id="edit_pengarang" name="pengarang" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori (Pilih 1 atau lebih) *</label>
                    <div class="w-full border border-slate-200 rounded-lg p-3 bg-slate-50 max-h-48 overflow-y-auto mb-2">
                        <div id="category_list_edit" class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="kategori[]" value="{{ $cat->nama_kategori }}" class="w-4 h-4 text-green-600 rounded border-slate-300 focus:ring-green-600 edit_kategori_checkbox">
                                <span class="text-slate-700">{{ $cat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                        <div class="border-t border-slate-200 pt-3 mt-2 flex items-center gap-2">
                            <input type="text" id="new_category_input_edit" class="flex-1 border border-slate-200 rounded-lg px-3 py-1.5 text-xs outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Ketik kategori baru...">
                            <button type="button" onclick="addCategoryAJAX('edit')" class="px-3 py-1.5 bg-slate-800 text-white text-xs font-bold rounded-lg hover:bg-slate-700 transition-colors whitespace-nowrap">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Harga Estimasi (Rp) *</label>
                    <input type="number" id="edit_harga_estimasi" name="harga_estimasi" required min="0" step="1000" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stok Dibutuhkan *</label>
                    <input type="number" id="edit_stok_dibutuhkan" name="stok_dibutuhkan" required min="1" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Status Buku *</label>
                    <select id="edit_status_buku" name="status_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="Dibutuhkan">Dibutuhkan</option>
                        <option value="Tersedia">Tersedia</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Jumlah Halaman</label>
                    <input type="text" id="edit_jumlah_halaman" name="jumlah_halaman" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Badge / Label (Opsional)</label>
                    <input type="text" id="edit_badge" name="badge" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                <p class="text-xs font-bold uppercase text-slate-700">Gambar Sampul / Cover Buku</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Upload File Gambar Baru (Maks. 2MB)</label>
                        <input type="file" name="cover_file" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-green-900 file:text-white hover:file:bg-green-800 transition-colors">
                        <p class="text-[10px] text-slate-400 mt-1">Maksimal 2 Megabyte.</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Atau Gunakan Link URL Gambar</label>
                        <input type="text" id="edit_cover_image" name="cover_image" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-green-600 bg-white">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Singkat</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-green-900 text-white rounded-lg text-sm font-bold hover:bg-green-800 shadow-sm">Perbarui Buku</button>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
function addCategoryAJAX(modalType) {
    let inputEl = document.getElementById('new_category_input_' + modalType);
    let name = inputEl.value.trim();
    if (!name) return;

    fetch('{{ route("admin.kategori.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ nama_kategori: name })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let catName = data.kategori.nama_kategori;
            // Append to both Add and Edit modals
            ['add', 'edit'].forEach(type => {
                let container = document.getElementById('category_list_' + type);
                if (container) {
                    let lbl = document.createElement('label');
                    lbl.className = 'flex items-center gap-2 cursor-pointer text-sm';
                    let checkboxClass = type === 'edit' ? 'edit_kategori_checkbox' : '';
                    lbl.innerHTML = `<input type="checkbox" name="kategori[]" value="${catName}" class="w-4 h-4 text-green-600 rounded border-slate-300 focus:ring-green-600 ${checkboxClass}" checked>
                                     <span class="text-slate-700">${catName}</span>`;
                    container.appendChild(lbl);
                }
            });
            inputEl.value = '';
            // Show tiny success indicator
            let btn = inputEl.nextElementSibling;
            let oldText = btn.innerText;
            btn.innerText = 'Tersimpan!';
            btn.classList.add('bg-green-600');
            setTimeout(() => {
                btn.innerText = oldText;
                btn.classList.remove('bg-green-600');
            }, 2000);
        } else {
            alert('Gagal menambahkan kategori. Mungkin kategori sudah ada.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan kategori.');
    });
}

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal(book) {
    document.getElementById('editForm').action = "/admin/catalog/update/" + book.id;
    document.getElementById('edit_judul_buku').value = book.judul_buku || '';
    document.getElementById('edit_pengarang').value = book.pengarang || '';
    
    let categories = book.kategori ? book.kategori.split(',').map(s => s.trim()) : [];
    document.querySelectorAll('.edit_kategori_checkbox').forEach(cb => {
        cb.checked = categories.includes(cb.value);
    });
    document.getElementById('edit_harga_estimasi').value = book.harga_estimasi || '';
    document.getElementById('edit_stok_dibutuhkan').value = book.stok_dibutuhkan || 1;
    document.getElementById('edit_status_buku').value = book.status_buku || 'Dibutuhkan';
    document.getElementById('edit_jumlah_halaman').value = book.jumlah_halaman || '';
    document.getElementById('edit_badge').value = book.badge || '';
    document.getElementById('edit_cover_image').value = book.cover_image || '';
    document.getElementById('edit_deskripsi').value = book.deskripsi || '';

    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function filterTable(input) {
    let filter = input.value.toLowerCase();
    let table = input.closest('div.bg-white').querySelector('table');
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
