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
                        <button onclick="viewRelatedBooks('kategori', '{{ addslashes($k->nama_kategori) }}')" class="text-sm font-medium text-slate-700 hover:text-emerald-700 transition-colors text-left flex-1 focus:outline-none flex items-center gap-2">
                            <span>{{ $k->nama_kategori }}</span>
                            <i data-lucide="external-link" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
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
                        <button onclick="viewRelatedBooks('penerbit', '{{ addslashes($p->nama_penerbit) }}')" class="text-sm font-medium text-slate-700 hover:text-amber-700 transition-colors text-left flex-1 focus:outline-none flex items-center gap-2">
                            <span>{{ $p->nama_penerbit }}</span>
                            <i data-lucide="external-link" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
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
                    <li class="flex items-center justify-between bg-slate-100 p-2 rounded border border-slate-200 group hover:border-slate-300 transition-colors">
                        <button onclick="viewRelatedBooks('badge', '{{ addslashes($dl) }}')" class="text-sm font-semibold text-slate-700 hover:text-purple-700 transition-colors text-left flex-1 focus:outline-none flex items-center gap-2">
                            <span>{{ $dl }} <span class="text-[10px] bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded ml-1">Bawaan</span></span>
                            <i data-lucide="external-link" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
                        <div class="flex items-center gap-1" title="Bawaan sistem, tidak bisa diubah">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i>
                        </div>
                    </li>
                    @endforeach
                    
                    @foreach($labels as $l)
                    <li class="flex items-center justify-between bg-slate-50 p-2 rounded border border-slate-100 group hover:border-slate-300 transition-colors">
                        <button onclick="viewRelatedBooks('badge', '{{ addslashes($l->nama_label) }}')" class="text-sm font-medium text-slate-700 hover:text-purple-700 transition-colors text-left flex-1 focus:outline-none flex items-center gap-2">
                            <span>{{ $l->nama_label }}</span>
                            <i data-lucide="external-link" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
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

<!-- Modal Related Books -->
<div id="modal-related-books" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
        <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="book-open" class="w-5 h-5 text-slate-600"></i>
                Buku Terkait: <span id="related-title" class="text-emerald-700"></span>
            </h3>
            <button onclick="document.getElementById('modal-related-books').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <div id="related-loading" class="flex flex-col items-center justify-center py-10 hidden">
                <div class="w-8 h-8 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-slate-500 text-sm mt-3 font-semibold">Memuat buku...</p>
            </div>
            
            <div id="related-empty" class="text-center py-10 hidden">
                <i data-lucide="inbox" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                <h4 class="text-slate-600 font-bold">Tidak Ada Buku</h4>
                <p class="text-slate-400 text-sm mt-1">Belum ada buku dengan data ini di katalog.</p>
            </div>

            <div id="related-content" class="grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
                <!-- Data buku masuk sini via JS -->
            </div>
        </div>
        
        <div class="p-4 border-t border-slate-200 bg-slate-50 text-right">
            <button onclick="document.getElementById('modal-related-books').classList.add('hidden')" class="px-5 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg transition-colors">Tutup</button>
        </div>
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

    function viewRelatedBooks(type, name) {
        const modal = document.getElementById('modal-related-books');
        const title = document.getElementById('related-title');
        const loading = document.getElementById('related-loading');
        const empty = document.getElementById('related-empty');
        const content = document.getElementById('related-content');

        title.textContent = name;
        modal.classList.remove('hidden');
        
        loading.classList.remove('hidden');
        empty.classList.add('hidden');
        content.classList.add('hidden');
        content.innerHTML = '';

        fetch(`/admin/master-data/books?type=${type}&name=${encodeURIComponent(name)}`)
            .then(response => response.json())
            .then(data => {
                loading.classList.add('hidden');
                
                if (!data.books || data.books.length === 0) {
                    empty.classList.remove('hidden');
                    return;
                }

                data.books.forEach(book => {
                    const statusClass = book.stok_dibutuhkan > 0 
                        ? 'bg-amber-100 text-amber-700 border-amber-200' 
                        : 'bg-emerald-100 text-emerald-700 border-emerald-200';
                    const statusText = book.stok_dibutuhkan > 0 ? 'Dibutuhkan' : 'Tersedia';
                    
                    const coverImg = book.cover_image 
                        ? `<img src="${book.cover_image}" alt="Cover" class="w-12 h-16 object-cover rounded shadow-sm shrink-0">`
                        : `<div class="w-12 h-16 bg-slate-100 rounded shadow-sm flex items-center justify-center shrink-0 border border-slate-200"><i data-lucide="image" class="w-4 h-4 text-slate-300"></i></div>`;

                    const html = `
                        <a href="/admin/catalog?search=${encodeURIComponent(book.judul_buku)}" class="flex gap-3 p-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:shadow-md transition-all group cursor-pointer bg-white">
                            ${coverImg}
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-800 text-sm truncate group-hover:text-emerald-700 transition-colors">${book.judul_buku}</h4>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border ${statusClass}">${statusText}</span>
                                    <span class="text-xs text-slate-500 font-semibold">Stok: ${book.stok_dibutuhkan}</span>
                                </div>
                            </div>
                        </a>
                    `;
                    content.insertAdjacentHTML('beforeend', html);
                });
                
                content.classList.remove('hidden');
                try {
                    lucide.createIcons();
                } catch(e) { console.error('Lucide error:', e); }
            })
            .catch(error => {
                loading.classList.add('hidden');
                if (content.innerHTML.trim() === '') {
                    empty.classList.remove('hidden');
                }
                console.error('Error fetching books:', error);
            });
    }
</script>

@endsection
