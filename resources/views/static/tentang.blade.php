@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-6">Tentang Kami</h1>
    <div class="prose prose-lg text-on-surface-variant max-w-none">
        <p>Wilmar Literacy Hub adalah platform donasi buku resmi dari Wilmar Business Indonesia Polytechnic. Kami menghubungkan donatur dengan perpustakaan kampus WBI — Anda pilih buku, kami pastikan sampai di rak.</p>
        <p>Visi kami adalah "Nurturing Entrepreneurs through literacy and accessible education" dengan menyediakan sumber daya belajar yang berkualitas untuk membentuk pemimpin bisnis masa depan.</p>
    </div>
</div>
@endsection
