@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-6">Kebijakan Privasi</h1>
    <div class="prose prose-lg text-on-surface-variant max-w-none space-y-4">
        <p>WilmarBOOKS menjaga data pribadi Anda. Berikut data apa saja yang kami simpan dan untuk apa.</p>
        <h3 class="text-xl font-bold text-on-surface mt-6">1. Pengumpulan Data</h3>
        <p>Kami mengumpulkan nama, alamat email, nomor telepon, dan data transaksi saat Anda melakukan pendaftaran atau donasi.</p>
        <h3 class="text-xl font-bold text-on-surface mt-6">2. Penggunaan Data</h3>
        <p>Data yang dikumpulkan digunakan semata-mata untuk keperluan pemrosesan donasi, penerbitan tanda terima, dan laporan transparansi.</p>
    </div>
</div>
@endsection
