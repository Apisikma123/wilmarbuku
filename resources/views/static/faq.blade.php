@extends((auth()->check() || session('is_user')) ? 'layouts.user' : 'layouts.main')
@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-16 min-h-[60vh]">
    <h1 class="text-4xl font-bold text-primary mb-6">Frequently Asked Questions (FAQ)</h1>
    <div class="prose prose-lg text-on-surface-variant max-w-none space-y-6">
        <div>
            <h3 class="text-xl font-bold text-on-surface mb-2">Q: Bagaimana cara berdonasi?</h3>
            <p>A: Anda dapat memilih buku dari katalog kami, menambahkannya ke keranjang, dan melakukan pembayaran secara online.</p>
        </div>
        <div>
            <h3 class="text-xl font-bold text-on-surface mb-2">Q: Ke mana buku donasi saya akan disalurkan?</h3>
            <p>A: Buku akan disalurkan langsung ke Perpustakaan Kampus Wilmar Business Indonesia Polytechnic untuk kebutuhan mahasiswa.</p>
        </div>
        <div>
            <h3 class="text-xl font-bold text-on-surface mb-2">Q: Apakah saya bisa melacak status donasi saya?</h3>
            <p>A: Ya, setelah donasi berhasil, Anda akan mendapatkan kode pelacakan dan dapat memantaunya di menu "Lacak Status" jika sudah masuk/login.</p>
        </div>
    </div>
</div>
@endsection
