@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 p-4 md:p-0">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Manajemen Pengguna</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola hak akses pengguna dan peran internal/eksternal.</p>
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

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-700 shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ number_format($totalUsers) }}</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">User Internal</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ number_format($internalUsers) }}</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-700 shrink-0">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">User Eksternal</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ number_format($externalUsers) }}</h3>
            </div>
        </div>
    </div>

    <!-- Users Table Area -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <!-- Table Toolbar -->
        <form id="filterForm" method="GET" action="{{ route('admin.users') }}" class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <h3 class="text-lg font-bold text-slate-900 shrink-0">Daftar Pengguna Terdaftar</h3>
            <div class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-2">
                <select id="roleFilter" name="role" onchange="document.getElementById('filterForm').submit()" class="w-full sm:w-auto bg-white border border-slate-200 rounded-lg py-1.5 pl-3 pr-8 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                    <option value="all">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user_internal" {{ request('role') == 'user_internal' ? 'selected' : '' }}>User Internal</option>
                    <option value="user_external" {{ request('role') == 'user_external' ? 'selected' : '' }}>User Eksternal</option>
                </select>
                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="w-full bg-white border border-slate-200 rounded-lg py-1.5 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none justify-center bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors shrink-0 flex items-center">
                        Cari
                    </button>
                    <button type="button" onclick="openAddModal()" class="flex-1 sm:flex-none justify-center bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors shrink-0 flex items-center gap-1">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah
                    </button>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-slate-500 bg-slate-50 border-y border-slate-100">
                        <th class="px-6 py-4 font-semibold rounded-tl-xl">Donatur</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Peran</th>
                        <th class="px-6 py-4 font-semibold w-48">NIM / NIDN</th>
                        <th class="px-6 py-4 font-semibold text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50 border-b border-slate-100 last:border-0 transition-colors user-row">
                            <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($u->nama_lengkap ?? 'US', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">{{ $u->nama_lengkap }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Terdaftar: {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $u->email }}</td>
                        <td class="px-6 py-4">
                            @if($u->role == 'admin')
                                <span class="text-xs bg-amber-100 text-amber-800 border border-amber-200 px-3 py-1.5 font-bold rounded-full">Admin</span>
                            @else
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-flex items-center gap-2" id="form-role-{{ $u->id }}">
                                    @csrf
                                    <select name="role" onchange="handleRoleChange(this, '{{ $u->role }}', 'form-role-{{ $u->id }}')" class="text-xs border border-slate-200 rounded-full pl-3 pr-8 py-1 font-bold {{ $u->role == 'user_internal' ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-700' }}">
                                        <option value="user_external" {{ $u->role == 'user_external' ? 'selected' : '' }}>User External</option>
                                        <option value="user_internal" {{ $u->role == 'user_internal' ? 'selected' : '' }}>User Internal</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-700">{{ $u->identitas_kampus ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($u->id !== auth()->id())
                            <div class="flex items-center justify-center gap-1">
                                <button onclick='openEditModal({{ json_encode($u) }})' class="p-1.5 text-slate-400 hover:text-blue-500 transition-colors" title="Edit Pengguna">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button onclick='openDeleteModal({{ $u->id }}, "{{ $u->nama_lengkap }}")' class="p-1.5 text-slate-400 hover:text-red-500 transition-colors" title="Hapus Pengguna">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editModal" class="fixed inset-0 z-50 bg-[#121c29]/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-[#f8f9ff] rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-[#c0c9be]">
            <div class="flex items-center justify-between border-b border-[#d9e3f6] pb-4 mb-6">
                <h3 class="text-lg font-bold text-[#121c29] flex items-center gap-2" style="font-family: Poppins, sans-serif;">
                    <i data-lucide="edit" class="w-6 h-6 text-[#004b23]"></i>
                    Edit Pengguna
                </h3>
                <button onclick="closeEditModal()" class="text-[#707970] hover:text-[#404941] transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-[#404941] mb-1.5" style="font-family: Poppins, sans-serif;">Nama Lengkap <span class="text-[#ba1a1a]">*</span></label>
                        <input type="text" name="nama_lengkap" id="edit_nama" required class="w-full bg-[#eff4ff] border border-[#c0c9be] rounded-lg py-2 px-3 text-sm text-[#121c29] focus:bg-[#ffffff] focus:border-[#003215] focus:ring-1 focus:ring-[#003215] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#404941] mb-1.5" style="font-family: Poppins, sans-serif;">Email <span class="text-[#ba1a1a]">*</span></label>
                        <input type="email" name="email" id="edit_email" required class="w-full bg-[#eff4ff] border border-[#c0c9be] rounded-lg py-2 px-3 text-sm text-[#121c29] focus:bg-[#ffffff] focus:border-[#003215] focus:ring-1 focus:ring-[#003215] outline-none transition-all">
                    </div>
                    <div id="edit_identitas_container">
                        <label class="block text-sm font-semibold text-[#404941] mb-1.5" style="font-family: Poppins, sans-serif;">Identitas Kampus</label>
                        <input type="text" name="identitas_kampus" id="edit_identitas" maxlength="15" minlength="15" placeholder="NIM / NIDN (Opsional)" class="w-full bg-[#eff4ff] border border-[#c0c9be] rounded-lg py-2 px-3 text-sm text-[#121c29] focus:bg-[#ffffff] focus:border-[#003215] focus:ring-1 focus:ring-[#003215] outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-[#d9e3f6]">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2 text-[#404941] hover:bg-[#eaf1ff] border border-[#c0c9be] rounded-lg text-sm font-bold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#003215] hover:bg-[#004b23] text-[#ffffff] rounded-lg text-sm font-bold transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus User -->
    <div id="deleteModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 sm:p-8 shadow-2xl border border-slate-200 text-center">
            <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Hapus Pengguna</h3>
            <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menghapus akun <strong id="delete_user_name" class="text-slate-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="deleteForm" method="POST" action="">
                @csrf
                <div class="flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-slate-600 hover:bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold transition-colors flex-1">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold transition-colors flex-1 shadow-sm">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div id="addModal" class="fixed inset-0 z-50 bg-[#121c29]/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-900">Tambah Pengguna Baru</h3>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form id="addForm" action="{{ route('admin.users.store') }}" method="POST" onsubmit="submitAddForm(event)">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none">
                    </div>
                    <div id="add_identitas_container" style="display: none;">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Identitas Kampus (NIM/NIDN)</label>
                        <input type="text" name="identitas_kampus" id="add_identitas" minlength="15" maxlength="15" placeholder="Wajib untuk Internal" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="8" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none">
                        <p class="text-[11px] text-slate-500 mt-1">Minimal 8 karakter.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Peran <span class="text-red-500">*</span></label>
                        <select name="role" id="add_role" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none bg-white">
                            <option value="user_external">User Eksternal (Luar Kampus)</option>
                            <option value="user_internal">User Internal (Kampus)</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Admin -->
    <div id="adminConfirmModal" class="fixed inset-0 z-[60] bg-[#121c29]/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-[#f8f9ff] rounded-2xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-[#c0c9be]">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-[#ffdad6] text-[#ba1a1a] flex items-center justify-center mb-4">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-[#121c29] mb-2" style="font-family: Poppins, sans-serif;">Jadikan Admin?</h3>
                <p class="text-[16px] text-[#404941] mb-8" style="font-family: Poppins, sans-serif;">
                    Peringatan: Sekali pengguna ini diangkat menjadi <strong>Admin</strong>, peran ini bersifat permanen dan tidak dapat dibatalkan kembali dari halaman ini. Lanjutkan?
                </p>
                <div class="flex items-center gap-3 w-full">
                    <button type="button" onclick="cancelAdminConfirm()" class="flex-1 px-5 py-3 text-[#404941] hover:bg-[#d0dbed] border border-[#707970] rounded-xl text-sm font-bold transition-colors">Batal</button>
                    <button type="button" onclick="proceedAdminConfirm()" class="flex-1 px-5 py-3 bg-[#ba1a1a] hover:bg-[#93000a] text-white rounded-xl text-sm font-bold transition-colors shadow-sm">Ya, Jadikan Admin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Internal -->
    <div id="internalConfirmModal" class="fixed inset-0 z-[60] bg-[#121c29]/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-[#f8f9ff] rounded-2xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-[#c0c9be]">
            <div class="flex flex-col">
                <h3 class="text-xl font-bold text-[#121c29] mb-2" style="font-family: Poppins, sans-serif;">Masukkan Identitas Kampus</h3>
                <p class="text-[14px] text-[#404941] mb-6" style="font-family: Poppins, sans-serif;">
                    Untuk mengubah pengguna ini menjadi <strong>User Internal</strong>, Anda harus memasukkan NIM / NIDN pengguna terlebih dahulu.
                </p>
                <div class="mb-6">
                    <input type="text" id="internal_nim_input" placeholder="NIM / NIDN (15 Karakter)" maxlength="15" minlength="15" class="w-full bg-[#eff4ff] border border-[#c0c9be] rounded-lg py-2 px-3 text-sm text-[#121c29] focus:bg-[#ffffff] focus:border-[#003215] focus:ring-1 focus:ring-[#003215] outline-none transition-all">
                </div>
                <div class="flex items-center gap-3 w-full">
                    <button type="button" onclick="cancelInternalConfirm()" class="flex-1 px-5 py-3 text-[#404941] hover:bg-[#d0dbed] border border-[#707970] rounded-xl text-sm font-bold transition-colors">Batal</button>
                    <button type="button" onclick="proceedInternalConfirm()" class="flex-1 px-5 py-3 bg-[#003215] hover:bg-[#004b23] text-white rounded-xl text-sm font-bold transition-colors shadow-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

<script>
let pendingSelectElement = null;
let pendingOriginalRole = null;
let pendingFormId = null;

function openEditModal(user) {
    document.getElementById('edit_nama').value = user.nama_lengkap;
    document.getElementById('edit_email').value = user.email;
    
    const identitasContainer = document.getElementById('edit_identitas_container');
    const identitasInput = document.getElementById('edit_identitas');
    
    if (user.role === 'user_internal') {
        identitasContainer.style.display = 'block';
        identitasInput.value = user.identitas_kampus || '';
    } else {
        identitasContainer.style.display = 'none';
        identitasInput.value = '';
    }
    
    document.getElementById('editForm').action = `/admin/users/update/${user.id}`;
    
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    // Re-initialize lucide icons for modal if needed
    if(window.lucide) {
        lucide.createIcons();
    }
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Delete Modal Functions
function openDeleteModal(id, name) {
    document.getElementById('delete_user_name').textContent = name;
    document.getElementById('deleteForm').action = `/admin/users/delete/${id}`;
    
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    if(window.lucide) {
        lucide.createIcons();
    }
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('add_role').addEventListener('change', function() {
    const identitasContainer = document.getElementById('add_identitas_container');
    const identitasInput = document.getElementById('add_identitas');
    if (this.value === 'user_internal') {
        identitasContainer.style.display = 'block';
    } else {
        identitasContainer.style.display = 'none';
        identitasInput.value = '';
    }
});


function handleRoleChange(selectElement, originalRole, formId) {
    if (selectElement.value === 'admin') {
        pendingSelectElement = selectElement;
        pendingOriginalRole = originalRole;
        pendingFormId = formId;
        
        const modal = document.getElementById('adminConfirmModal');
        modal.classList.remove('hidden');
        if(window.lucide) lucide.createIcons();
    } else if (selectElement.value === 'user_internal' && originalRole !== 'user_internal') {
        pendingSelectElement = selectElement;
        pendingOriginalRole = originalRole;
        pendingFormId = formId;
        
        const modal = document.getElementById('internalConfirmModal');
        modal.classList.remove('hidden');
        document.getElementById('internal_nim_input').value = '';
    } else {
        document.getElementById(formId).submit();
    }
}

function cancelInternalConfirm() {
    if (pendingSelectElement && pendingOriginalRole) {
        pendingSelectElement.value = pendingOriginalRole;
    }
    document.getElementById('internalConfirmModal').classList.add('hidden');
    
    pendingSelectElement = null;
    pendingOriginalRole = null;
    pendingFormId = null;
}

function proceedInternalConfirm() {
    const nimInput = document.getElementById('internal_nim_input').value;
    if (nimInput.length !== 15) {
        alert('NIM / NIDN harus berjumlah 15 karakter.');
        return;
    }
    
    if (pendingFormId) {
        const form = document.getElementById(pendingFormId);
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'identitas_kampus';
        hiddenInput.value = nimInput;
        form.appendChild(hiddenInput);
        
        form.submit();
    }
}

function cancelAdminConfirm() {
    if (pendingSelectElement && pendingOriginalRole) {
        pendingSelectElement.value = pendingOriginalRole;
    }
    document.getElementById('adminConfirmModal').classList.add('hidden');
    pendingSelectElement = null;
    pendingOriginalRole = null;
    pendingFormId = null;
}

function proceedAdminConfirm() {
    if (pendingFormId) {
        document.getElementById(pendingFormId).submit();
    }
}

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    if(window.lucide) lucide.createIcons();
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addForm').reset();
}

function submitAddForm(e) {
    e.preventDefault();
    const role = document.getElementById('add_role').value;
    if (role === 'admin') {
        pendingFormId = 'addForm';
        document.getElementById('adminConfirmModal').classList.remove('hidden');
    } else {
        document.getElementById('addForm').submit();
    }
}
</script>
