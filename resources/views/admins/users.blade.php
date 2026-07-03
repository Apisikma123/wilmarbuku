@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">User Management</h2>
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
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Users</p>
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
        <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <h3 class="text-lg font-bold text-slate-900">Daftar Pengguna Terdaftar</h3>
            <div class="relative w-48 md:w-64 shrink-0">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" onkeyup="filterTable(this)" placeholder="Search users..." class="w-full bg-white border border-slate-200 rounded-lg py-1.5 pl-9 pr-3 text-sm focus:border-green-600 focus:ring-1 focus:ring-green-600 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 font-black uppercase tracking-widest bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4">Identitas Kampus</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition-colors">
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
                            <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="text-xs border border-slate-200 rounded px-2.5 py-1 font-bold rounded-full {{ $u->role == 'admin' ? 'bg-amber-100 text-amber-800' : ($u->role == 'user_internal' ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-700') }}">
                                    <option value="user_external" {{ $u->role == 'user_external' ? 'selected' : '' }}>User External</option>
                                    <option value="user_internal" {{ $u->role == 'user_internal' ? 'selected' : '' }}>User Internal</option>
                                    <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $u->identitas_kampus ?? '-' }}
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

// Edit Modal Functions
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
</script>
