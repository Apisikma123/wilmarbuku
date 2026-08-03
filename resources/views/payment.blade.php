@extends('layouts.user')

@section('content')
    <div class="px-4 md:px-12 xl:px-24 max-w-[1080px] mx-auto py-8 md:py-12 min-h-[70vh]">
        
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-primary hover:shadow-md transition-all border border-gray-100">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold font-display text-primary">Selesaikan Pembayaran</h1>
                <p class="text-sm text-gray-500 mt-1">Langkah terakhir untuk kebaikan yang Anda bagikan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Kiri: Info Tagihan & Rekening -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Tagihan -->
                <div class="bg-primary rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <p class="text-primary-50 text-sm mb-1 opacity-80">Total Tagihan Donasi</p>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 font-display">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h2>
                    <div class="flex items-center justify-between border-t border-white/20 pt-4 mt-2">
                        <span class="text-sm opacity-90">Jumlah Buku</span>
                        <span class="font-semibold">{{ $transaksi->details->sum('qty') }} Eksemplar</span>
                    </div>
                </div>

                <!-- Card Rekening Tujuan -->
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center">1</span>
                        Informasi Transfer
                    </h3>
                    
                    <label class="block text-sm font-medium text-gray-600 mb-2">Pilih Rekening Tujuan Admin</label>
                    <select id="metodePembayaranSelect" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all mb-5 outline-none font-medium" onchange="updateBankInfo()">
                        @if(count($metodes) > 0)
                            <option value="" disabled selected data-bank="-" data-rek="Pilih bank di atas" data-nama="-">-- Pilih Rekening Admin --</option>
                        @endif
                        @forelse($metodes as $metode)
                            <option value="{{ $metode->id }}" data-bank="{{ $metode->nama_bank }}" data-rek="{{ $metode->nomor_rekening }}" data-nama="{{ $metode->atas_nama }}">
                                {{ $metode->nama_bank }}
                            </option>
                        @empty
                            <option value="" data-bank="-" data-rek="Belum ada rekening" data-nama="-">Belum ada metode pembayaran</option>
                        @endforelse
                    </select>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center gap-4 relative group">
                        <div id="bankIcon" class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-primary font-bold text-sm uppercase tracking-wider shrink-0 border border-gray-100">
                            -
                        </div>
                        <div class="overflow-hidden flex-grow">
                            <p class="text-xs text-gray-500 mb-0.5">Nomor Rekening</p>
                            <h4 id="nomorRekening" class="font-bold text-gray-800 text-lg md:text-xl tracking-wider font-mono">0000 0000 00</h4>
                            <p id="atasNama" class="text-xs font-medium text-gray-600 mt-0.5">a/n -</p>
                        </div>
                        <button onclick="copyRekening()" class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-500 hover:text-primary hover:bg-primary/5 transition-colors" title="Salin Rekening">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kanan: Form Konfirmasi -->
            <div class="lg:col-span-7">
                <form id="paymentForm" action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 md:p-8 shadow-[0_4px_24px_rgba(0,0,0,0.06)] border border-gray-50 h-full">
                    @csrf
                    <input type="hidden" name="kode_tracking" value="{{ $transaksi->kode_tracking }}">
                    <input type="hidden" name="metode_pembayaran_id" id="hiddenMetodePembayaran" value="">
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">2</span>
                        Konfirmasi Pembayaran
                    </h3>

                    <!-- Data Pengirim -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Bank Anda (Pengirim) <span class="text-red-500">*</span></label>
                            <input type="text" name="bank_pengirim" required placeholder="Contoh: BCA, Mandiri, Jenius" 
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-gray-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Nama Pemilik Rekening <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pengirim" required placeholder="Sesuai buku tabungan" 
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-gray-400">
                        </div>
                    </div>

                    <!-- Bukti Transfer -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Bukti Transfer <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 bg-gray-50/50 rounded-xl p-6 text-center hover:border-primary hover:bg-primary/5 transition-all cursor-pointer relative group" id="drop-zone">
                            <input type="file" name="bukti_pembayaran" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFile(this)">
                            
                            <div class="flex flex-col items-center gap-2 pointer-events-none transition-transform group-hover:-translate-y-1" id="file-info">
                                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary mb-2">
                                    <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                                </div>
                                <span class="text-sm text-gray-800 font-bold">Tap atau drop foto bukti transfer di sini</span>
                                <span class="text-xs text-gray-500 font-medium">Mendukung JPG, PNG (Max 5MB)</span>
                            </div>
                        </div>
                        
                        @error('bukti_pembayaran')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary/90 hover:shadow-lg hover:shadow-primary/30 transition-all flex justify-center items-center gap-2 text-base group relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Kirim Bukti Pembayaran
                            <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </span>
                    </button>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        // Update informasi Bank Tujuan berdasarkan pilihan Dropdown
        function updateBankInfo() {
            const select = document.getElementById('metodePembayaranSelect');
            if (!select || select.options.length === 0 || select.selectedIndex === -1) return;

            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption) return;

            const bankName = selectedOption.getAttribute('data-bank') || '';
            const bankRek = selectedOption.getAttribute('data-rek') || '';
            const bankNama = selectedOption.getAttribute('data-nama') || '';

            document.getElementById('bankIcon').innerText = bankName ? bankName.substring(0, 3) : '-';
            document.getElementById('nomorRekening').innerText = bankRek;
            document.getElementById('atasNama').innerText = bankNama ? "a/n " + bankNama : 'a/n -';

            const hiddenInput = document.getElementById('hiddenMetodePembayaran');
            if (hiddenInput) hiddenInput.value = selectedOption.value;
        }

        // Fitur Copy Rekening (Disukai Gen Z)
        function copyRekening() {
            const rek = document.getElementById('nomorRekening').innerText;
            if(rek && rek !== '0000 0000 00') {
                navigator.clipboard.writeText(rek);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Nomor Rekening berhasil disalin!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            updateBankInfo();
            
            @if($errors->any())
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terdapat kesalahan pada input Anda. Silakan periksa kembali.',
                        confirmButtonColor: '#004b23'
                    });
                }
            @endif
        });

        // UI Preview Foto Bukti Transfer
        function previewFile(input) {
            const fileInfo = document.getElementById('file-info');
            const dropZone = document.getElementById('drop-zone');

            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                dropZone.classList.add('border-primary', 'bg-primary/5');
                fileInfo.innerHTML = `
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mb-2">
                        <span class="material-symbols-outlined text-2xl">check_circle</span>
                    </div>
                    <span class="text-sm text-primary font-bold line-clamp-1 px-4">${fileName}</span>
                    <span class="text-xs text-primary/70 font-medium">Foto siap diunggah</span>
                `;
            } else {
                dropZone.classList.remove('border-primary', 'bg-primary/5');
                fileInfo.innerHTML = `
                    <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-gray-400 mb-2">
                        <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                    </div>
                    <span class="text-sm text-gray-800 font-bold">Tap atau drop foto bukti transfer di sini</span>
                    <span class="text-xs text-gray-500 font-medium">Mendukung JPG, PNG (Max 5MB)</span>
                `;
            }
        }

        // Kompresi Gambar ke WebP di sisi Klien
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

        // Tangkap Submit Form
        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            let form = this;
            let btn = form.querySelector('button[type="submit"]');
            let fileInput = form.querySelector('input[type="file"]');
            let bankPengirim = form.querySelector('input[name="bank_pengirim"]');
            let namaPengirim = form.querySelector('input[name="nama_pengirim"]');

            const select = document.getElementById('metodePembayaranSelect');
            const bankVal = select ? select.value : '';
            const fileSelected = fileInput && fileInput.files && fileInput.files[0];

            if (!bankVal) {
                Swal.fire({ icon: 'warning', title: 'Tujuan Belum Dipilih', text: 'Pilih rekening admin tujuan transfer terlebih dahulu!', confirmButtonColor: '#004b23' });
                return;
            }
            if (!bankPengirim.value.trim() || !namaPengirim.value.trim()) {
                Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap', text: 'Mohon isi Bank dan Nama Pemilik Rekening pengirim!', confirmButtonColor: '#004b23' });
                return;
            }
            if (!fileSelected) {
                Swal.fire({ icon: 'warning', title: 'Bukti Belum Diunggah', text: 'Silakan unggah foto bukti transfer Anda!', confirmButtonColor: '#004b23' });
                return;
            }

            // Ubah state tombol saat proses
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">sync</span> Sedang Memproses...';
            btn.classList.add('opacity-80', 'cursor-not-allowed');

            try {
                let originalFile = fileInput.files[0];
                if (originalFile.type.startsWith('image/')) {
                    let compressedFile = await compressImage(originalFile, 1200, 1200, 0.8);
                    let dt = new DataTransfer();
                    dt.items.add(compressedFile);
                    fileInput.files = dt.files;
                }
                form.submit();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal mengompres gambar. Silakan coba gambar lain.', confirmButtonColor: '#004b23' });
                btn.disabled = false;
                btn.innerHTML = 'Kirim Bukti Pembayaran <span class="material-symbols-outlined">arrow_forward</span>';
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
            }
        });
    </script>
@endsection
