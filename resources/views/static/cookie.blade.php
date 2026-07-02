@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-6">Cookie Policy</h1>
    <div class="prose prose-lg text-on-surface-variant max-w-none space-y-4">
        <p>Wilmar Literacy Hub menggunakan cookies agar situs ini berjalan normal.</p>
        <h3 class="text-xl font-bold text-on-surface mt-6">Apa itu Cookies?</h3>
        <p>Cookies adalah file kecil yang disimpan pada perangkat Anda saat mengunjungi website kami. Kami menggunakan session cookies untuk mempertahankan status login Anda dan melacak item di keranjang donasi.</p>
        <p>Dengan melanjutkan penggunaan situs ini, Anda menyetujui penggunaan cookies sesuai dengan kebijakan kami.</p>
    </div>
</div>
@endsection
