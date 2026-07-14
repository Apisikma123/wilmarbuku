@extends('layouts.user')

@section('content')
    <div class="px-6 md:px-12 xl:px-24 max-w-[1200px] mx-auto py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="javascript:void(0)"
                onclick="if(document.referrer) { window.history.back(); } else { window.location.href='/cart'; }"
                class="inline-flex items-center text-sm font-medium text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-lg mr-1">arrow_back</span>
                Kembali
            </a>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" class="flex flex-col lg:flex-row gap-8 items-start">
            @csrf
            <input type="hidden" name="type" value="{{ request('type') }}">
            <!-- Kiri: Identitas & Buku -->
            <div class="w-full lg:w-[60%] flex flex-col gap-6">

                <!-- Identitas Donatur -->
                <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
                    <div class="flex items-center gap-2 mb-6 text-[#004225]">
                        <span class="material-symbols-outlined">person</span>
                        <h2 class="text-lg font-bold">Identitas Donatur</h2>
                    </div>

                    <!-- Tipe Donatur Toggle -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Internal -->
                        <label
                            class="relative flex flex-col border border-outline-variant/50 rounded-xl p-4 cursor-pointer transition-colors peer-checked:border-[#004225] peer-checked:border-2"
                            id="label-internal">
                            <input type="radio" name="tipe_donatur" value="internal" class="hidden peer" {{ Auth::user()->role == 'user_internal' ? 'checked' : '' }} onchange="toggleIdentitas()">
                            <span class="font-bold text-on-surface mb-1">Internal Kampus</span>
                            <span class="text-xs text-on-surface-variant">Mahasiswa / Dosen WBI</span>
                        </label>
                        <!-- Eksternal -->
                        <label
                            class="relative flex flex-col border border-outline-variant/50 rounded-xl p-4 cursor-pointer transition-colors peer-checked:border-[#004225] peer-checked:border-2"
                            id="label-eksternal">
                            <input type="radio" name="tipe_donatur" value="eksternal" class="hidden peer" {{ Auth::user()->role != 'user_internal' ? 'checked' : '' }} onchange="toggleIdentitas()">
                            <span class="font-bold text-on-surface mb-1">Publik / Umum</span>
                            <span class="text-xs text-on-surface-variant">Donatur Eksternal</span>
                        </label>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-5">
                        <div id="identitas-kampus-container"
                            class="{{ Auth::user()->role == 'user_internal' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-on-surface mb-1">Nomor Induk Mahasiswa / NIDN <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="identitas_kampus" value="{{ Auth::user()->identitas_kampus }}" maxlength="15" minlength="15"
                                class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg outline-none transition-colors text-sm text-gray-500 cursor-not-allowed"
                                placeholder="Masukkan NIM/NIDN Anda" readonly>
                            <div class="flex items-center gap-1 mt-1.5 text-on-surface-variant text-[11px]">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                <span>Perubahan NIM hanya dapat dilakukan melalui Pengaturan Profil.</span>
                            </div>
                            @error('identitas_kampus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-1">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}"
                                    class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg outline-none transition-colors text-sm text-gray-500 cursor-not-allowed"
                                    placeholder="Nama sesuai identitas" readonly>
                                @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-on-surface mb-1">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-3 bg-[#f8fafc] border border-outline-variant/30 rounded-lg outline-none transition-colors text-sm text-gray-500 cursor-not-allowed"
                                    placeholder="alamat@email.com" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buku Donasi -->
                <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
                    <div class="flex items-center gap-2 mb-6 text-[#004225]">
                        <span class="material-symbols-outlined">menu_book</span>
                        <h2 class="text-lg font-bold">Buku Donasi</h2>
                    </div>

                    @foreach($cart as $id => $item)
                        <div class="flex flex-col sm:flex-row gap-6 mb-6">
                            <!-- Book Cover -->
                            <div
                                class="w-24 aspect-[2/3] rounded-lg @if((!str_starts_with($item['cover_image'] ?? '', '/storage/') && !str_starts_with($item['cover_image'] ?? '', 'http'))) bg-gradient-to-br {{ $item['cover_image'] ?? 'from-primary to-primary-container' }} @endif flex-shrink-0 flex flex-col items-center justify-center p-3 text-center text-white border border-black/5 shadow-md relative overflow-hidden">
                                @if((str_starts_with($item['cover_image'] ?? '', '/storage/') || str_starts_with($item['cover_image'] ?? '', 'http')))
                                    <img src="{{ $item['cover_image'] }}" class="absolute inset-0 w-full h-full object-cover z-0"
                                        alt="">
                                @else
                                    <h4 class="text-[9px] font-bold uppercase leading-tight mb-1 relative z-10">
                                        {!! str_replace(' ', '<br>', $item['judul_buku']) !!}</h4>
                                @endif
                            </div>

                            <!-- Book Info -->
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-lg text-on-surface leading-tight mb-1">{{ $item['judul_buku'] }}</h3>
                                <p class="text-sm text-on-surface-variant mb-4">Oleh: {{ $item['pengarang'] }}</p>
                                <div class="flex gap-2 mb-2">
                                    <span
                                        class="bg-[#f1f5f9] text-[#475569] text-[11px] font-bold px-3 py-1.5 rounded-md">{{ $item['kategori'] }}</span>
                                </div>
                                <p class="text-sm font-bold text-primary">{{ $item['qty'] }} Buku x Rp
                                    {{ number_format($item['harga_estimasi'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kanan: Ringkasan & Pembayaran -->
            <div class="w-full lg:w-[40%] flex flex-col gap-6">

                <!-- Ringkasan Donasi -->
                <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden sticky top-24">

                    <div class="bg-[#f8fafc] p-6 border-b border-outline-variant/30">
                        <h2 class="text-sm font-bold text-[#004225]">Ringkasan Donasi</h2>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4 mb-6">
                            @php $total_qty = collect($cart)->sum('qty'); @endphp
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">Subtotal ({{ $total_qty }} Buku)</span>
                                <span class="font-medium text-on-surface">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">Biaya Platform</span>
                                <span class="font-medium text-on-surface">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">Pajak (Termasuk)</span>
                                <span class="font-medium text-on-surface">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 mb-6 border-t border-outline-variant/30 pt-6">
                            <span class="font-bold text-sm text-on-surface">Metode Pembayaran</span>
                            <div
                                class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg bg-surface-container-low">
                                <span class="material-symbols-outlined text-primary">account_balance</span>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">Transfer Rekening</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-outline-variant/30 pt-6 mb-8">
                                <span class="font-bold text-on-surface text-sm">Total Pembayaran</span>
                                <span class="font-bold text-2xl text-[#004225]">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit"
                                class="w-full bg-[#004225] text-white font-bold text-sm px-6 py-4 rounded-xl hover:bg-primary transition-colors shadow-md flex justify-center items-center gap-2 mb-4">
                                <span class="material-symbols-outlined text-lg">lock</span>
                                Bayar Sekarang
                            </button>

                            <div class="flex items-center justify-center gap-1.5 text-[11px] text-on-surface-variant">
                                <span class="material-symbols-outlined text-[14px]">verified_user</span>
                                <span>Pembayaran aman & terverifikasi oleh Midtrans</span>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div>

    <script>
        const userNimStatus = '{{ Auth::user()->nim_status }}';

        function toggleIdentitas() {
            const internalRadio = document.querySelector('input[name="tipe_donatur"][value="internal"]');
            const eksternalRadio = document.querySelector('input[name="tipe_donatur"][value="eksternal"]');
            
            if (internalRadio.checked && userNimStatus !== 'verified') {
                eksternalRadio.checked = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'Akses Ditolak',
                    text: 'Anda tidak dapat menggunakan role Internal. NIM belum diisi atau sedang menunggu validasi Admin.',
                    confirmButtonText: 'Buka Profil Akun',
                    confirmButtonColor: '#004b23',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("akun") }}';
                    }
                });
                return;
            }

            const type = document.querySelector('input[name="tipe_donatur"]:checked').value;
            const container = document.getElementById('identitas-kampus-container');
            const internalLabel = document.getElementById('label-internal');
            const eksternalLabel = document.getElementById('label-eksternal');

            if (type === 'internal') {
                container.classList.remove('hidden');
                internalLabel.classList.add('border-[#004225]', 'border-2');
                internalLabel.classList.remove('border-outline-variant/50');
                eksternalLabel.classList.remove('border-[#004225]', 'border-2');
                eksternalLabel.classList.add('border-outline-variant/50');
            } else {
                container.classList.add('hidden');
                eksternalLabel.classList.add('border-[#004225]', 'border-2');
                eksternalLabel.classList.remove('border-outline-variant/50');
                internalLabel.classList.remove('border-[#004225]', 'border-2');
                internalLabel.classList.add('border-outline-variant/50');
            }
        }

        // Initial call to set correct styles
        document.addEventListener("DOMContentLoaded", toggleIdentitas);
    </script>
@endsection