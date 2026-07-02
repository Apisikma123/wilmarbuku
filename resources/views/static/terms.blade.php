@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-6">Terms of Service</h1>
    <div class="prose prose-lg text-on-surface-variant max-w-none space-y-4">
        <p>Dengan mengakses dan menggunakan platform Wilmar Literacy Hub, Anda menyetujui syarat dan ketentuan berikut:</p>
        <ul class="list-disc pl-6 space-y-2">
            <li>Dana yang telah didonasikan tidak dapat dikembalikan (non-refundable).</li>
            <li>Buku yang didonasikan adalah bentuk barang/fisik atau e-book yang sudah diverifikasi oleh kampus.</li>
            <li>Platform berhak membatalkan donasi jika terindikasi adanya kecurangan pembayaran.</li>
        </ul>
    </div>
</div>
@endsection
