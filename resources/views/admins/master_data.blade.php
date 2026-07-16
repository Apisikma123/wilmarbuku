@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 p-4 md:p-0">
    
    <!-- Top Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.catalog') }}" class="p-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg transition-colors shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Manajemen Master Data</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola data kategori, penerbit, dan label untuk katalog buku.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-4 rounded-lg border border-emerald-200 text-sm font-semibold flex items-center gap-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kategori -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col">
            <div class="bg-slate-50 p-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="tag" class="w-4 h-4 text-[#003128]"></i> Kategori
                </h3>
                <button onclick="document.getElementById('modal-add-kategori').classList.remove('hidden')" class="text-xs bg-[#003128] text-white px-2 py-1 rounded hover:bg-[#00493d] transition-colors font-semibold">
                    Tambah
                </button>
            </div>
            <div class="flex-1 p-4 overflow-y-auto max-h-[500px]">
                <ul class="space-y-2">
                    @forelse($kategoris as $k)
                    <li class="flex items-center justify-between bg-slate-50 p-2 rounded border border-slate-100 group hover:border-slate-300 transition-colors">
                        <span class="text-sm font-medium text-slate-700">{{ $k->nama_kategori }}</span>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="editKategori({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')" class="p-1 text-slate-400 hover:text-blue-600 transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="openDeleteModal('{{ route('admin.master.kategori.delete', $k->id) }}', 'Hapus Kategori', '{{ addslashes($k->nama_kategori) }}')" class="p-1 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </li>
                    @empty
                    <li class="text-sm text-slate-500 text-center py-4">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Kolom Penerbit -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col">
            <div class="bg-slate-50 p-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="building" class="w-4 h-4 text-[#7b5800]"></i> Penerbit
                </h3>
                <button onclick="document.getElementById('modal-add-penerbit').classList.remove('hidden')" class="text-xs bg-[#7b5800] text-white px-2 py-1 rounded hover:bg-[#715000] transition-colors font-semibold">
                    Tambah
                </button>
            </div>
            <div class="flex-1 p-4 overflow-y-auto max-h-[500px]">
                <ul class="space-y-2">
                    @forelse($penerbits as $p)
                    <li class="flex items-center justify-between bg-slate-50 p-2 rounded border border-slate-100 group hover:border-slate-300 transition-colors">
                        <span class="text-sm font-medium text-slate-700">{{ $p->nama_penerbit }}</span>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="editPenerbit({{ $p->id }}, '{{ addslashes($p->nama_penerbit) }}')" class="p-1 text-slate-400 hover:text-blue-600 transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="openDeleteModal('{{ route('admin.master.penerbit.delete', $p->id) }}', 'Hapus Penerbit', '{{ addslashes($p->nama_penerbit) }}')" class="p-1 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </li>
                    @empty
                    <li class="text-sm text-slate-500 text-center py-4">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Kolom Label/Badge -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col">
            <div class="bg-slate-50 p-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="bookmark" class="w-4 h-4 text-purple-700"></i> Label Buku
                </h3>
                <button onclick="document.getElementById('modal-add-label').classList.remove('hidden')" class="text-xs bg-purple-700 text-white px-2 py-1 rounded hover:bg-purple-800 transition-colors font-semibold">
                    Tambah
                </button>
            </div>
            <div class="flex-1 p-4 overflow-y-auto max-h-[500px]">
                <ul class="space-y-2">

                    @php
                        $defaultLabels = ['Buku Wajib', 'Prioritas Kampus', 'Bestseller', 'Rekomendasi', 'Trending', 'Pilihan Utama'];
                    @endphp
                    @foreach($defaultLabels as $dl)
                    <li class="flex items-center justify-between bg-slate-100 p-2 rounded border border-slate-200">
                        <span class="text-sm font-semibold text-slate-700">{{ $dl }} <span class="text-[10px] bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded ml-1">Bawaan</span></span>
                        <div class="flex items-center gap-1" title="Bawaan sistem, tidak bisa diubah">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i>
                        </div>
                    </li>
                    @endforeach
                    
                    @foreach($labels as $l)
                    <li class="flex items-center justify-between bg-slate-50 p-2 rounded border border-slate-100 group hover:border-slate-300 transition-colors">
                        <span class="text-sm font-medium text-slate-700">{{ $l->nama_label }}</span>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="editLabel({{ $l->id }}, '{{ addslashes($l->nama_label) }}')" class="p-1 text-slate-400 hover:text-blue-600 transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="openDeleteModal('{{ route('admin.master.label.delete', $l->id) }}', 'Hapus Label', '{{ addslashes($l->nama_label) }}')" class="p-1 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-add-kategori" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Kategori</h3>
            <form action="{{ route('admin.master.kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-emerald-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-add-kategori').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-[#003128] text-white rounded-lg hover:bg-[#00493d] transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="modal-edit-kategori" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Kategori</h3>
            <form id="form-edit-kategori" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Kategori</label>
                    <input type="text" id="edit-nama-kategori" name="nama_kategori" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-emerald-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-edit-kategori').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-[#003128] text-white rounded-lg hover:bg-[#00493d] transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Penerbit -->
<div id="modal-add-penerbit" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Penerbit</h3>
            <form action="{{ route('admin.master.penerbit.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Penerbit</label>
                    <input type="text" name="nama_penerbit" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-amber-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-add-penerbit').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-[#7b5800] text-white rounded-lg hover:bg-[#715000] transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Penerbit -->
<div id="modal-edit-penerbit" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Penerbit</h3>
            <form id="form-edit-penerbit" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Penerbit</label>
                    <input type="text" id="edit-nama-penerbit" name="nama_penerbit" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-amber-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-edit-penerbit').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-[#7b5800] text-white rounded-lg hover:bg-[#715000] transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Label -->
<div id="modal-add-label" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Label</h3>
            <form action="{{ route('admin.master.label.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Label</label>
                    <input type="text" name="nama_label" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-purple-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-add-label').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Label -->
<div id="modal-edit-label" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Label</h3>
            <form id="form-edit-label" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Label</label>
                    <input type="text" id="edit-nama-label" name="nama_label" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-purple-600 outline-none" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-edit-label').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modal-delete" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 sm:p-8 shadow-2xl border border-slate-200 text-center">
        <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
        </div>
        <h3 id="delete-title" class="text-xl font-bold text-slate-900 mb-2">Hapus Data</h3>
        <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menghapus <strong id="delete-name" class="text-slate-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="form-delete" method="POST" action="">
            @csrf
            <div class="flex items-center justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-slate-600 hover:bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold transition-colors flex-1">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold transition-colors flex-1 shadow-sm">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(url, title, name) {
        const modal = document.getElementById('modal-delete');
        document.getElementById('form-delete').action = url;
        document.getElementById('delete-title').textContent = title;
        document.getElementById('delete-name').textContent = name;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('modal-delete').classList.add('hidden');
    }

    function editKategori(id, nama) {
        document.getElementById('form-edit-kategori').action = '/admin/master-data/kategori/update/' + id;
        document.getElementById('edit-nama-kategori').value = nama;
        document.getElementById('modal-edit-kategori').classList.remove('hidden');
    }

    function editPenerbit(id, nama) {
        document.getElementById('form-edit-penerbit').action = '/admin/master-data/penerbit/update/' + id;
        document.getElementById('edit-nama-penerbit').value = nama;
        document.getElementById('modal-edit-penerbit').classList.remove('hidden');
    }

    function editLabel(id, nama) {
        document.getElementById('form-edit-label').action = '/admin/master-data/label/update/' + id;
        document.getElementById('edit-nama-label').value = nama;
        document.getElementById('modal-edit-label').classList.remove('hidden');
    }
</script>

@endsection
