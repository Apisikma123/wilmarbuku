@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Wishlist Katalog Buku</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola daftar buku yang diajukan dan dibutuhkan untuk perpustakaan.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openCategoryModal()" class="flex items-center gap-2 px-3 py-2.5 bg-[#003128] hover:bg-[#00493d] text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="tag" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Tambah Kategori</span>
            </button>
            <button onclick="openPublisherModal()" class="flex items-center gap-2 px-3 py-2.5 bg-[#7b5800] hover:bg-[#715000] text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="building" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Tambah Penerbit</span>
            </button>
            <button onclick="openAddModal()" class="flex items-center gap-2 px-3 py-2.5 bg-[#003215] hover:bg-[#004b23] text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                <i data-lucide="plus-square" class="w-4 h-4"></i>
                Tambah Buku Baru
            </button>
        </div>
    </div>


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
        <form method="GET" action="{{ route('admin.catalog') }}" class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50 flex-wrap gap-4">
            <h3 class="text-lg font-bold text-slate-900">Daftar Katalog Buku</h3>
            <div class="relative w-64 shrink-0 flex items-center gap-2">
                <div class="relative w-full">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..." class="w-full bg-white border border-slate-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                </div>
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">Cari</button>
            </div>
        </form>
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
                        <td class="px-6 py-5 font-bold text-slate-900">#{{ $b->id }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                @if($b->cover_image)
                                    @if(str_starts_with($b->cover_image, '/storage/') || str_starts_with($b->cover_image, 'http'))
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
                        <td class="px-6 py-5">
                            <div class="text-slate-900 font-medium">{{ $b->pengarang }}</div>
                            @if($b->penerbit)
                            <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                <i data-lucide="building" class="w-3 h-3"></i> {{ $b->penerbit }}
                            </div>
                            @endif
                        </td>
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
                                <form action="{{ route('admin.catalog.delete', $b->id) }}" method="POST" onsubmit="confirmDelete(event, this)" class="m-0 flex items-center">
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
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $books->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="categoryModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="tag" class="w-5 h-5 text-slate-700"></i>
                Tambah Kategori
            </h3>
            <button onclick="closeCategoryModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Kategori Baru *</label>
                <input type="text" id="new_cat_name" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: Otomotif">
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeCategoryModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="button" onclick="submitCategory()" class="px-5 py-2.5 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-700 shadow-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Penerbit -->
<div id="publisherModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="building" class="w-5 h-5 text-blue-900"></i>
                Tambah Penerbit
            </h3>
            <button onclick="closePublisherModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Penerbit Baru *</label>
                <input type="text" id="new_pub_name" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: Erlangga">
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closePublisherModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="button" onclick="submitPublisher()" class="px-5 py-2.5 bg-blue-900 text-white rounded-lg text-sm font-bold hover:bg-blue-800 shadow-sm">Simpan</button>
            </div>
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

        <form id="addBookForm" onsubmit="submitAddBook(event)" enctype="multipart/form-data" class="space-y-4" novalidate>
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                <input type="text" name="judul_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: Manajemen Strategi Bisnis Modern">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pengarang / Penulis *</label>
                    <input type="text" name="pengarang" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Nama pengarang">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Penerbit *</label>
                    <select name="penerbit" id="add_penerbit" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach($penerbits as $p)
                        <option value="{{ $p->nama_penerbit }}">{{ $p->nama_penerbit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori (Pilih 1 atau lebih) *</label>
                    <div class="w-full border border-slate-200 rounded-lg p-3 bg-slate-50 max-h-48 overflow-y-auto mb-2">
                        <div id="category_list_add" class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="kategori[]" value="{{ $cat->nama_kategori }}" class="w-4 h-4 text-green-600 rounded border-slate-300 focus:ring-green-600">
                                <span class="text-slate-700">{{ $cat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Harga Estimasi *</label>
                    <div class="flex items-center w-full border border-slate-200 rounded-lg bg-white overflow-hidden focus-within:border-green-600 focus-within:ring-1 focus-within:ring-green-600">
                        <span class="pl-3.5 pr-1 text-sm font-bold text-slate-400 select-none">Rp</span>
                        <input type="text" inputmode="numeric" name="harga_estimasi" required class="w-full py-2.5 px-2 text-sm outline-none border-none focus:ring-0 bg-transparent" placeholder="150.000" oninput="this.value = formatInputRupiah(this.value)">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stok Dibutuhkan *</label>
                    <input type="text" inputmode="numeric" name="stok_dibutuhkan" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="10">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Status Buku *</label>
                    <select name="status_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="Dibutuhkan">Dibutuhkan</option>
                        <option value="Tersedia">Tersedia</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Badge / Label *</label>
                    <select name="badge" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white" required>
                        <option value="" disabled selected>-- Pilih Label --</option>
                        <option value="Prioritas">Prioritas</option>
                        <option value="Pilihan Utama">Pilihan Utama</option>
                        <option value="Trending">Trending</option>
                        <option value="Rekomendasi">Rekomendasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Jumlah Halaman</label>
                    <input type="text" name="jumlah_halaman" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Contoh: 320 Halaman">
                </div>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                <p class="text-xs font-bold uppercase text-slate-700">Gambar Sampul / Cover Buku</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Upload Berkas Gambar *</label>
                        <input type="file" id="cover_file_add" name="cover_file" accept="image/jpeg,image/png,image/webp" onchange="document.getElementById('cover_image_add').value = ''" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-green-900 file:text-white hover:file:bg-green-800 transition-colors">
                        <p class="text-[10px] text-slate-400 mt-1">Sistem akan otomatis mengecilkan gambar.</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Atau Gunakan Link URL Gambar</label>
                        <input type="text" id="cover_image_add" name="cover_image" oninput="document.getElementById('cover_file_add').value = ''" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-green-600 bg-white" placeholder="https://domain.com/image.jpg">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" placeholder="Tulis deskripsi atau sinopsis singkat buku ini..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="submit" id="btnSubmitAddBook" class="px-5 py-2.5 bg-green-900 text-white rounded-lg text-sm font-bold hover:bg-green-800 shadow-sm flex items-center gap-2">Simpan Buku</button>
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

        <form id="editForm" onsubmit="submitEditBook(event)" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                <input type="text" id="edit_judul_buku" name="judul_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Pengarang / Penulis *</label>
                    <input type="text" id="edit_pengarang" name="pengarang" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Penerbit *</label>
                    <select name="penerbit" id="edit_penerbit" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach($penerbits as $p)
                        <option value="{{ $p->nama_penerbit }}">{{ $p->nama_penerbit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori (Pilih 1 atau lebih) *</label>
                    <div class="w-full border border-slate-200 rounded-lg p-3 bg-slate-50 max-h-48 overflow-y-auto mb-2">
                        <div id="category_list_edit" class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="kategori[]" value="{{ $cat->nama_kategori }}" class="w-4 h-4 text-green-600 rounded border-slate-300 focus:ring-green-600 edit_kategori_checkbox">
                                <span class="text-slate-700">{{ $cat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Harga Estimasi *</label>
                    <div class="flex items-center w-full border border-slate-200 rounded-lg bg-white overflow-hidden focus-within:border-green-600 focus-within:ring-1 focus-within:ring-green-600">
                        <span class="pl-3.5 pr-1 text-sm font-bold text-slate-400 select-none">Rp</span>
                        <input type="text" inputmode="numeric" id="edit_harga_estimasi" name="harga_estimasi" required class="w-full py-2.5 px-2 text-sm outline-none border-none focus:ring-0 bg-transparent" oninput="this.value = formatInputRupiah(this.value)">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stok Dibutuhkan *</label>
                    <input type="text" inputmode="numeric" id="edit_stok_dibutuhkan" name="stok_dibutuhkan" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Status Buku *</label>
                    <select id="edit_status_buku" name="status_buku" required class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white">
                        <option value="Dibutuhkan">Dibutuhkan</option>
                        <option value="Tersedia">Tersedia</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Badge / Label *</label>
                    <select id="edit_badge" name="badge" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 bg-white" required>
                        <option value="" disabled selected>-- Pilih Label --</option>
                        <option value="Prioritas">Prioritas</option>
                        <option value="Pilihan Utama">Pilihan Utama</option>
                        <option value="Trending">Trending</option>
                        <option value="Rekomendasi">Rekomendasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Jumlah Halaman</label>
                    <input type="text" id="edit_jumlah_halaman" name="jumlah_halaman" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600">
                </div>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                <p class="text-xs font-bold uppercase text-slate-700">Gambar Sampul / Cover Buku</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Upload File Gambar Baru *</label>
                        <input type="file" id="cover_file_edit" name="cover_file" accept="image/jpeg,image/png,image/webp" onchange="document.getElementById('edit_cover_image').value = ''" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-green-900 file:text-white hover:file:bg-green-800 transition-colors">
                        <p class="text-[10px] text-slate-400 mt-1">Sistem akan otomatis mengecilkan gambar.</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-600 mb-1">Atau Gunakan Link URL Gambar</label>
                        <input type="text" id="edit_cover_image" name="cover_image" oninput="document.getElementById('cover_file_edit').value = ''" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-green-600 bg-white" placeholder="https://domain.com/image.jpg">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Singkat</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Batal</button>
                <button type="submit" id="btnSubmitEditBook" class="px-5 py-2.5 bg-green-900 text-white rounded-lg text-sm font-bold hover:bg-green-800 shadow-sm flex items-center justify-center gap-2">
                    <span class="btn-text">Perbarui Buku</span>
                    <i data-lucide="loader-2" class="w-4 h-4 animate-spin hidden spinner"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
}
function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}
function openPublisherModal() {
    document.getElementById('publisherModal').classList.remove('hidden');
}
function closePublisherModal() {
    document.getElementById('publisherModal').classList.add('hidden');
}

function submitCategory() {
    let inputEl = document.getElementById('new_cat_name');
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
            closeCategoryModal();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Kategori baru ditambahkan!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal menambahkan kategori. Mungkin kategori sudah ada.',
                confirmButtonColor: '#003215'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: 'Terjadi kesalahan saat menambahkan kategori.',
            confirmButtonColor: '#003215'
        });
    });
}

function submitPublisher() {
    let inputEl = document.getElementById('new_pub_name');
    let name = inputEl.value.trim();
    if (!name) return;

    fetch('{{ route("admin.penerbit.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ nama_penerbit: name })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let pubName = data.penerbit.nama_penerbit;
            ['add_penerbit', 'edit_penerbit'].forEach(id => {
                let select = document.getElementById(id);
                if (select) {
                    let opt = document.createElement('option');
                    opt.value = pubName;
                    opt.innerHTML = pubName;
                    select.appendChild(opt);
                    if (id === 'add_penerbit') select.value = pubName;
                }
            });
            inputEl.value = '';
            closePublisherModal();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Penerbit baru ditambahkan!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal menambahkan penerbit. Mungkin penerbit sudah ada.',
                confirmButtonColor: '#003215'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: 'Terjadi kesalahan saat menambahkan penerbit.',
            confirmButtonColor: '#003215'
        });
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
    document.getElementById('edit_penerbit').value = book.penerbit || '';
    
    let categories = book.kategori ? book.kategori.split(',').map(s => s.trim()) : [];
    document.querySelectorAll('.edit_kategori_checkbox').forEach(cb => {
        cb.checked = categories.includes(cb.value);
    });
    document.getElementById('edit_harga_estimasi').value = formatInputRupiah(book.harga_estimasi ? book.harga_estimasi.toString() : '');
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

function confirmDelete(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Hapus Buku?',
        text: "Anda yakin ingin menghapus buku ini dari katalog?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ba1a1a',
        cancelButtonColor: '#707970',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}


async function compressImage(file, maxWidth, maxHeight, quality) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (event) {
            const img = new Image();
            img.src = event.target.result;
            img.onload = function () {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > maxWidth) {
                        height = Math.round((height *= maxWidth / width));
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width = Math.round((width *= maxHeight / height));
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    resolve(new File([blob], file.name.replace(/\.[^/.]+$/, ".webp"), {
                        type: 'image/webp',
                        lastModified: Date.now()
                    }));
                }, 'image/webp', quality);
            };
            img.onerror = (error) => reject(error);
        };
        reader.onerror = (error) => reject(error);
    });
}

async function submitAddBook(event) {
    event.preventDefault();
    let form = event.target;
    let formData = new FormData(form);
    
    // Clean up currency format
    let harga = formData.get('harga_estimasi');
    if (harga) {
        formData.set('harga_estimasi', harga.replace(/[^0-9]/g, ''));
    }
    
    // Client-side compression
    let fileInput = form.querySelector('input[type="file"]');
    if (fileInput && fileInput.files && fileInput.files[0]) {
        let originalFile = fileInput.files[0];
        if (originalFile.type.startsWith('image/')) {
            let compressedFile = await compressImage(originalFile, 1200, 1200, 0.8);
            formData.set('cover_file', compressedFile);
        }
    }

    let btn = document.getElementById('btnSubmitAddBook');
    
    // Disable button & show loading state
    btn.disabled = true;
    let originalHtml = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...';
    lucide.createIcons();

    fetch('{{ route("admin.catalog.store") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        let text = await response.text();
        let result;
        
        if (response.status === 419) {
            Swal.fire({
                icon: 'warning',
                title: 'Sesi Kedaluwarsa',
                text: 'Sesi Anda telah berakhir (mungkin Anda login di tab lain). Halaman akan dimuat ulang otomatis.',
                confirmButtonColor: '#003215'
            }).then(() => {
                window.location.reload();
            });
            return;
        }
        
        try {
            result = JSON.parse(text);
        } catch(e) {
            console.error("RAW RESPONSE:", text);
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: 'Terjadi kesalahan sistem atau ukuran file gambar melampaui batas wajar server (Maks. 1GB). Jika menggunakan Link URL, pastikan kolom file gambar dikosongkan.',
                confirmButtonColor: '#003215'
            });
            return;
        }

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Buku berhasil ditambahkan ke katalog!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            // Validation errors (422)
            if (response.status === 422) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Tidak Lengkap',
                    text: 'Mohon lengkapi semua data buku yang wajib terisi (*).',
                    confirmButtonColor: '#003215'
                });

                // Clear previous errors
                form.querySelectorAll('.error-text').forEach(el => el.remove());
                form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                
                let firstErrorField = null;
                for (let field in result.errors) {
                    // Handle array fields like kategori.0
                    let inputName = field.includes('.') ? field.split('.')[0] + '[]' : field;
                    let inputs = form.querySelectorAll(`[name="${inputName}"]`);
                    
                    if (inputs.length > 0) {
                        let targetInput = inputs[inputs.length - 1]; // for checkboxes, put error after last checkbox container
                        if(inputs[0].type === 'checkbox') {
                            targetInput = inputs[0].closest('.grid') || inputs[0].parentElement;
                        }
                        
                        inputs.forEach(inp => inp.classList.add('border-red-500'));
                        
                        let errorMsg = document.createElement('p');
                        errorMsg.className = 'error-text text-red-500 text-[10px] mt-1 font-semibold';
                        errorMsg.innerText = result.errors[field][0];
                        targetInput.parentNode.insertBefore(errorMsg, targetInput.nextSibling);
                        
                        if (!firstErrorField) firstErrorField = inputs[0];
                    }
                }
                
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: result.message || 'Terjadi kesalahan sistem.',
                    confirmButtonColor: '#003215'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: error.message || 'Terjadi kesalahan sistem saat menyimpan data.',
            confirmButtonColor: '#dc2626'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        lucide.createIcons();
    });
}

async function submitEditBook(event) {
    event.preventDefault();
    let form = event.target;
    let formData = new FormData(form);
    
    // Clean up currency format
    let harga = formData.get('harga_estimasi');
    if (harga) {
        formData.set('harga_estimasi', harga.replace(/[^0-9]/g, ''));
    }
    
    // Client-side compression
    let fileInput = form.querySelector('input[type="file"]');
    if (fileInput && fileInput.files && fileInput.files[0]) {
        let originalFile = fileInput.files[0];
        if (originalFile.type.startsWith('image/')) {
            let compressedFile = await compressImage(originalFile, 1200, 1200, 0.8);
            formData.set('cover_file', compressedFile);
        }
    }

    let btn = document.getElementById('btnSubmitEditBook');
    
    // Disable button & show loading state
    btn.disabled = true;
    btn.querySelector('.btn-text').classList.add('hidden');
    btn.querySelector('.spinner').classList.remove('hidden');

    // Hapus error sebelumnya
    form.querySelectorAll('.text-red-500').forEach(el => el.remove());
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

    try {
        let response = await fetch(form.action, {
            method: 'POST', // We use POST but FormData has _method=PUT
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });

        if (response.status === 419) {
            Swal.fire({
                icon: 'warning',
                title: 'Sesi Kedaluwarsa',
                text: 'Sesi Anda telah berakhir, silakan refresh halaman ini.',
                confirmButtonColor: '#003215'
            });
            return;
        }

        let text = await response.text();
        let result;
        try {
            result = JSON.parse(text);
        } catch(e) {
            console.error("RAW RESPONSE:", text);
            // Show the first 1000 characters of the raw HTML to help debug
            let errorPreview = text.substring(0, 500).replace(/<[^>]*>?/gm, ''); // Strip HTML tags
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Response: ' + errorPreview,
                confirmButtonColor: '#003215'
            });
            return;
        }

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data buku berhasil diperbarui!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            if (response.status === 422 && result.errors) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Tidak Lengkap',
                    text: 'Mohon lengkapi semua data buku yang wajib terisi (*).',
                    confirmButtonColor: '#003215'
                });

                // Tampilkan error inline
                for (let field in result.errors) {
                    let inputName = field;
                    if (field.startsWith('kategori.')) {
                        inputName = 'kategori[]';
                    }
                    
                    let input = form.querySelector(`[name="${inputName}"]`);
                    if (input) {
                        let targetInput = input;
                        if(input.type === 'checkbox') {
                            targetInput = input.closest('.grid') || input.parentElement;
                        }
                        if (targetInput.parentNode.classList.contains('flex') && targetInput.parentNode.classList.contains('items-center')) {
                             targetInput = targetInput.parentNode;
                        }

                        if (input.parentNode.classList.contains('flex')) {
                            input.parentNode.classList.add('border-red-500');
                        } else {
                            input.classList.add('border-red-500');
                        }

                        let errorText = document.createElement('p');
                        errorText.className = 'text-red-500 text-[10px] font-bold mt-1';
                        errorText.innerText = result.errors[field][0];
                        targetInput.parentNode.insertBefore(errorText, targetInput.nextSibling);
                    }
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui',
                    text: result.message || 'Terjadi kesalahan.',
                    confirmButtonColor: '#003215'
                });
            }
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Koneksi Terputus',
            text: 'Gagal menghubungi server.',
            confirmButtonColor: '#003215'
        });
    } finally {
        // Re-enable button
        btn.disabled = false;
        btn.querySelector('.btn-text').classList.remove('hidden');
        btn.querySelector('.spinner').classList.add('hidden');
    }
}
function formatInputRupiah(value) {
    let number_string = value.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
    if(ribuan){
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
}
</script>
