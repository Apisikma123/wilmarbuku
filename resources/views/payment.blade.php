@extends('layouts.user')

@section('content')
    <div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10 min-h-[60vh] flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-8 max-w-lg w-full text-center">

            <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-3xl">account_balance</span>
            </div>

            <h1 class="text-2xl font-bold font-display text-on-surface mb-2">Pembayaran Donasi</h1>
            <p class="text-sm text-on-surface-variant mb-4">Silakan lakukan transfer ke rekening di bawah ini dan unggah
                bukti pembayarannya.</p>

            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-3 mb-8 flex items-start gap-2 text-left">
                <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5">timer</span>
                <div class="text-xs w-full">
                    <div class="flex justify-between items-center mb-0.5">
                        <strong class="block">Batas Waktu Pembayaran</strong>
                        <strong id="countdown-timer" class="text-red-700 bg-red-100 px-2 py-0.5 rounded">60:00</strong>
                    </div>
                    Segera selesaikan pembayaran sebelum <span
                        class="font-bold">{{ $transaksi->created_at->addHour()->format('d M Y H:i') }}</span> WIB atau
                    transaksi Anda akan otomatis dibatalkan.
                </div>
            </div>

            <div class="bg-surface-container-low border border-outline-variant/50 rounded-xl p-5 mb-8 text-left">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-on-surface mb-2">Pilih Bank Tujuan Transfer</label>
                    <select id="metodePembayaranSelect"
                        class="w-full bg-white border border-outline-variant/50 rounded-lg px-4 py-3 text-sm text-on-surface focus:ring-primary focus:border-primary shadow-sm"
                        onchange="updateBankInfo()">
                        @forelse($metodes as $metode)
                            <option value="{{ $metode->id }}" data-bank="{{ $metode->nama_bank }}"
                                data-rek="{{ $metode->nomor_rekening }}" data-nama="{{ $metode->atas_nama }}">
                                {{ $metode->nama_bank }}</option>
                        @empty
                            <option value="" data-bank="-" data-rek="Belum ada rekening" data-nama="-">Belum ada metode
                                pembayaran</option>
                        @endforelse
                    </select>
                </div>
                <div
                    class="flex items-center gap-3 mb-4 bg-white border border-outline-variant/30 p-4 rounded-xl shadow-sm">
                    <div id="bankIcon"
                        class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 shrink-0 font-bold uppercase">
                        BCA
                    </div>
                    <div>
                        <h3 id="nomorRekening" class="font-bold text-on-surface text-xl tracking-wider">1234 5678 90</h3>
                        <p id="atasNama" class="text-xs font-medium text-on-surface-variant mt-0.5">a/n Admin WilmarBOOKS
                        </p>
                    </div>
                </div>
                <div class="flex justify-between items-center border-t border-outline-variant/30 pt-4">
                    <span class="text-sm font-medium text-on-surface-variant">Total Tagihan
                        ({{ $transaksi->details->sum('qty') }} Buku)</span>
                    <span class="text-lg font-bold text-primary">Rp
                        {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kode_tracking" value="{{ $transaksi->kode_tracking }}">
                <input type="hidden" name="metode_pembayaran_id" id="hiddenMetodePembayaran" value="">
                <div class="mb-6 text-left">
                    <label class="block text-sm font-bold text-on-surface mb-2">Unggah Bukti Pembayaran *</label>
                    <div class="border-2 border-dashed border-outline-variant rounded-xl p-4 text-center hover:border-primary transition-colors cursor-pointer relative"
                        id="drop-zone">
                        <input type="file" name="bukti_pembayaran" accept="image/*" required
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            onchange="previewFile(this)">
                        <div class="flex flex-col items-center gap-2 pointer-events-none" id="file-info">
                            <span class="material-symbols-outlined text-outline-variant text-3xl">upload_file</span>
                            <span class="text-sm text-on-surface-variant font-medium">Pilih gambar (JPG, PNG)</span>
                            <span class="text-xs text-outline-variant">Auto Compress</span>
                        </div>
                    </div>
                    @error('bukti_pembayaran')
                        <span class="text-xs text-error mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white font-bold py-3.5 rounded-xl hover:bg-primary/90 transition-colors shadow-sm flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined">send</span>
                    Kirim Bukti Pembayaran
                </button>
            </form>

        </div>
    </div>

    <script>
        function updateBankInfo() {
            const select = document.getElementById('metodePembayaranSelect');
            if (!select || select.options.length === 0) return;

            const selectedOption = select.options[select.selectedIndex];
            const bankName = selectedOption.getAttribute('data-bank');
            const bankRek = selectedOption.getAttribute('data-rek');
            const bankNama = selectedOption.getAttribute('data-nama');

            document.getElementById('bankIcon').innerText = bankName.substring(0, 3);
            document.getElementById('nomorRekening').innerText = bankRek;
            document.getElementById('atasNama').innerText = "a/n " + bankNama;

            const hiddenInput = document.getElementById('hiddenMetodePembayaran');
            if (hiddenInput) hiddenInput.value = selectedOption.value;
        }

        document.addEventListener("DOMContentLoaded", function () {
            updateBankInfo();
        });

        @php
            $expireTimestamp = $transaksi->created_at->addHour()->timestamp;
            $currentTimestamp = now()->timestamp;
            $remainingSeconds = max(0, $expireTimestamp - $currentTimestamp);
        @endphp

        let remainingSeconds = {{ $remainingSeconds }};
    const countdownElement = document.getElementById('countdown-timer');

        if (countdownElement) {
             const timerInterval = setInterval(function() {
                if (remainingSeconds <= 0) {
                    clearInterval(timerInterval);
    countdownElement.innerHTML = "00:00";

                    const submitBtn = document.querySelector('button[type="submit"]');
                    if(submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="material-symbols-outlined">timer_off</span> Waktu Habis';
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;

                    const formattedMinutes = minutes.toString().padStart(2, '0');
                    const formattedSeconds = seconds.toString().padStart(2, '0');
    countdownElement.innerHTML = formattedMinutes + ":" + formattedSeconds;

                    remainingSeconds--;
                }
            }, 1000);
        }

        function previewFile(input) {
            const fileInfo = document.getElementById('file-info');
    const dropZone = document.getElementById('drop-zone');

            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                dropZone.classList.add('border-primary', 'bg-primary/5');
                fileInfo.innerHTML = `
                    <span class="material-symbols-outlined text-primary text-3xl">image</span>
                    <span class="text-sm text-primary font-bold line-clamp-1 px-4">${fileName}</span>
                    <span class="text-xs text-primary/80">Gambar siap diunggah</span>
                `;
            } else {
                dropZone.classList.remove('border-primary', 'bg-primary/5');
                fileInfo.innerHTML = `
                    <span class="material-symbols-outlined text-outline-variant text-3xl">upload_file</span>
                    <span class="text-sm text-on-surface-variant font-medium">Pilih gambar (JPG, PNG)</span>
                    <span class="text-xs text-outline-variant">Auto Compress</span>
                `;
            }
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

         document.querySelector('form').addEventListener('submit', async function(e) {
            e.preventDefault();
            let form = this;
            let btn = form.querySelector('button[type="submit"]');
    let fileInput = form.querySelector('input[type="file"]');

            if (fileInput && fileInput.files && fileInput.files[0]) {
                btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">sync</span> Mengompres...';

                let originalFile = fileInput.files[0];
                if (originalFile.type.startsWith('image/')) {
                    let compressedFile = await compressImage(originalFile, 1200, 1200, 0.8);
                    let dt = new DataTransfer();
                    dt.items.add(compressedFile);
                    fileInput.files = dt.files;
                }
    }

            form.submit();
        });
    </script>
@endsection
