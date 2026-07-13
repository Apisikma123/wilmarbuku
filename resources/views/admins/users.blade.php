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
            <h3 class="text-lg font-bold text-slate-900">Daftar Pengguna Terdaftar</h3>
            <div class="relative w-full sm:w-auto shrink-0 flex flex-col sm:flex-row items-center gap-2">
                <select id="roleFilter" name="role" onchange="document.getElementById('filterForm').submit()" class="bg-white border border-slate-200 rounded-lg py-1.5 pl-3 pr-8 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                    <option value="all">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user_internal" {{ request('role') == 'user_internal' ? 'selected' : '' }}>User Internal</option>
                    <option value="user_external" {{ request('role') == 'user_external' ? 'selected' : '' }}>User Eksternal</option>
                </select>
                  <div class="relative w-full sm:w-64">
                      <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                      <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="w-full bg-white border border-slate-200 rounded-lg py-1.5 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                  </div>
                  <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors shrink-0">Cari</button>
                  <button type="button" onclick="openAddModal()" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors shrink-0 flex items-center gap-1">
                      <i data-lucide="plus" class="w-4 h-4"></i> Tambah
                  </button>
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
                            @if($u->identitas_kampus)
                                @if($u->nim_status == 'pending')
                                    <div class="mt-2 flex flex-col gap-1">
                                        <span class="inline-block text-[9px] uppercase tracking-wider font-bold bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full w-max mb-1">Perlu Validasi</span>
                                        <div class="flex items-center gap-1">
                                            <form action="{{ route('admin.users.nim', [$u->id, 'accept']) }}" method="POST">
                                                @csrf
                                                <button class="bg-green-500 text-white p-1 rounded hover:bg-green-600 transition" title="Terima Validasi">
                                                    <i data-lucide="check" class="w-3 h-3"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.nim', [$u->id, 'reject']) }}" method="POST">
                                                @csrf
                                                <button class="bg-red-500 text-white p-1 rounded hover:bg-red-600 transition" title="Tolak Validasi">
                                                    <i data-lucide="x" class="w-3 h-3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($u->nim_status == 'verified')
                                    <span class="inline-block mt-1 text-[9px] uppercase tracking-wider font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Terverifikasi</span>
                                @elseif($u->nim_status == 'rejected')
                                    <span class="inline-block mt-1 text-[9px] uppercase tracking-wider font-bold bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Ditolak</span>
                                @endif
                            @endif
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
    <div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="edit" class="w-6 h-6 text-blue-600"></i>
                    Edit Pengguna
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" id="edit_nama" required class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm focus:bg-white focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="edit_email" required class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm focus:bg-white focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Identitas Kampus</label>
                        <input type="text" name="identitas_kampus" id="edit_identitas" placeholder="NIM / NIDN (Opsional)" class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm focus:bg-white focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2 text-slate-600 hover:bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-colors">Simpan Perubahan</button>
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

</div>
@endsection

<script>
let pendingSelectElement = null;
let pendingOriginalRole = null;
let pendingFormId = null;

function openEditModal(user) {
    document.getElementById('edit_nama').value = user.nama_lengkap;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_identitas').value = user.identitas_kampus || '';
    
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

let pendingSelectElement = null;
let pendingOriginalRole = null;
let pendingFormId = null;

function handleRoleChange(selectElement, originalRole, formId) {
    if (selectElement.value === 'admin') {
        pendingSelectElement = selectElement;
        pendingOriginalRole = originalRole;
        pendingFormId = formId;
        
        const modal = document.getElementById('adminConfirmModal');
        modal.classList.remove('hidden');
        if(window.lucide) lucide.createIcons();
    } else {
        document.getElementById(formId).submit();
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
