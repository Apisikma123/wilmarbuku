@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10 min-h-[60vh] flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-8 max-w-lg w-full text-center">
        
        <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-3xl">account_balance</span>
        </div>

        <h1 class="text-2xl font-bold font-display text-on-surface mb-2">Pembayaran Donasi</h1>
        <p class="text-sm text-on-surface-variant mb-8">Silakan lakukan transfer ke rekening di bawah ini dan unggah bukti pembayarannya.</p>

        <div class="bg-surface-container-low border border-outline-variant/50 rounded-xl p-5 mb-8 text-left">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 shrink-0 font-bold">
                    BCA
                </div>
                <div>
                    <h3 class="font-bold text-on-surface text-lg">1234 5678 90</h3>
                    <p class="text-xs text-on-surface-variant">a/n Admin WilmarBOOKS</p>
                </div>
            </div>
            <div class="flex justify-between items-center border-t border-outline-variant/30 pt-4">
                <span class="text-sm font-medium text-on-surface-variant">Total Tagihan</span>
                <span class="text-lg font-bold text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kode_tracking" value="{{ $transaksi->kode_tracking }}">
            <div class="mb-6 text-left">
                <label class="block text-sm font-bold text-on-surface mb-2">Unggah Bukti Pembayaran *</label>
                <div class="border-2 border-dashed border-outline-variant rounded-xl p-4 text-center hover:border-primary transition-colors cursor-pointer relative" id="drop-zone">
                    <input type="file" name="bukti_pembayaran" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFile(this)">
                    <div class="flex flex-col items-center gap-2 pointer-events-none" id="file-info">
                        <span class="material-symbols-outlined text-outline-variant text-3xl">upload_file</span>
                        <span class="text-sm text-on-surface-variant font-medium">Pilih gambar (JPG, PNG)</span>
                        <span class="text-xs text-outline-variant">Maksimal 5MB</span>
                    </div>
                </div>
                @error('bukti_pembayaran')
                    <span class="text-xs text-error mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl hover:bg-primary/90 transition-colors shadow-sm flex justify-center items-center gap-2">
                <span class="material-symbols-outlined">send</span>
                Kirim Bukti Pembayaran
            </button>
        </form>

    </div>
</div>

<script>
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
                <span class="text-xs text-outline-variant">Maksimal 5MB</span>
            `;
        }
    }
</script>
@endsection
