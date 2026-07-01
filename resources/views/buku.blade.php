@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-medium text-on-surface-variant mb-8 overflow-x-auto whitespace-nowrap hide-scroll">
        <a href="/dashboard" class="hover:text-primary transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="#" class="hover:text-primary transition-colors">Katalog Buku</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span id="breadcrumb-category" class="hover:text-primary transition-colors cursor-pointer">Kategori</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span id="breadcrumb-title" class="text-on-surface font-bold">Judul Buku</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left Column: Book Image -->
        <div class="lg:col-span-4 lg:col-start-1 flex flex-col gap-6">
            <div class="bg-surface-bright rounded-2xl p-6 border border-outline-variant/30 flex items-center justify-center shadow-sm">
                <div id="book-cover" class="w-full max-w-[280px] aspect-[3/4] rounded-lg shadow-lg flex items-center justify-center p-6 text-center text-white border border-black/5 relative overflow-hidden">
                    <div>
                        <h4 id="cover-title" class="text-xl md:text-2xl font-bold uppercase leading-tight mb-2 tracking-tight"></h4>
                        <p class="text-xs text-white/80 border-t border-white/20 pt-2 mt-2">Edisi Terbaru</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Info Badges -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-surface-container-low rounded-xl p-4 flex flex-col items-center justify-center text-center gap-1 border border-outline-variant/20">
                    <span class="material-symbols-outlined text-primary text-[24px]">import_contacts</span>
                    <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Halaman</span>
                    <span id="book-pages" class="text-sm font-semibold text-on-surface">-</span>
                </div>
                <div class="bg-surface-container-low rounded-xl p-4 flex flex-col items-center justify-center text-center gap-1 border border-outline-variant/20">
                    <span class="material-symbols-outlined text-primary text-[24px]">inventory_2</span>
                    <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Stok Dibutuhkan</span>
                    <span id="book-stock" class="text-sm font-semibold text-on-surface">-</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Book Details & Actions -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Header Info -->
            <div>
                <div class="flex items-center gap-2 mb-4 flex-wrap">
                    <span id="book-category-badge" class="bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest border border-primary/20"></span>
                    <span id="book-badge" class="hidden bg-secondary/10 text-secondary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest border border-secondary/20 items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">verified</span> <span id="badge-text"></span>
                    </span>
                </div>
                
                <h1 id="book-title" class="text-3xl md:text-4xl font-bold text-on-surface tracking-tight mb-2 leading-tight"></h1>
                <p class="text-lg text-on-surface-variant font-medium mb-6">Oleh: <span id="book-author" class="text-primary font-bold"></span></p>
                
                <div class="flex items-baseline gap-3 mb-6">
                    <span id="book-price" class="text-3xl font-black text-primary tracking-tight"></span>
                    <span class="text-sm text-on-surface-variant font-medium">/ buku</span>
                </div>
            </div>

            <!-- Action Box -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-primary/20">
                <div class="flex flex-col sm:flex-row items-end sm:items-center gap-4">
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-bold text-on-surface-variant mb-2">Jumlah Donasi</label>
                        <div class="flex items-center bg-surface-bright border border-outline-variant/50 rounded-xl p-1 h-12 w-full sm:w-32">
                            <button type="button" id="btn-minus" class="w-10 h-full rounded-lg text-on-surface flex items-center justify-center hover:bg-outline-variant/20 transition-colors"><span class="material-symbols-outlined text-[20px]">remove</span></button>
                            <input type="text" id="qty-input" value="1" readonly class="w-full h-full text-center bg-transparent border-none focus:ring-0 font-bold text-on-surface p-0">
                            <button type="button" id="btn-plus" class="w-10 h-full rounded-lg bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><span class="material-symbols-outlined text-[20px]">add</span></button>
                        </div>
                    </div>
                    
                    <a href="/cart" id="btn-add-cart" class="w-full flex-grow bg-primary text-white font-bold h-12 rounded-xl hover:bg-primary-container transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                        Tambahkan ke Keranjang
                    </a>
                </div>
                <p id="subtotal-text" class="text-xs text-on-surface-variant mt-3 text-right font-medium"></p>
            </div>

            <!-- Description -->
            <div class="pt-8 border-t border-outline-variant/30">
                <div class="flex items-center gap-8 border-b border-outline-variant/30 mb-6">
                    <button class="pb-3 text-primary font-bold border-b-2 border-primary text-sm">Deskripsi Buku</button>
                    <button class="pb-3 text-on-surface-variant hover:text-on-surface font-medium text-sm transition-colors">Detail Distribusi</button>
                </div>
                
                <div id="book-description" class="text-on-surface-variant text-sm md:text-base leading-relaxed space-y-4">
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    // Book Database
    const books = {
        1: {
            title: 'Manajemen Modern & Strategi Inovasi',
            coverTitle: 'Manajemen<br>Modern',
            author: 'Dr. Andi S.',
            price: 150000,
            category: 'Manajemen & Bisnis',
            badge: 'Prioritas Kampus',
            pages: '342 Hal',
            stock: '15 Buku',
            gradient: 'linear-gradient(to bottom right, #003215, #004b23)',
            coverTextColor: '#ffffff',
            description: '<p>Buku <strong>"Manajemen Modern & Strategi Inovasi"</strong> mengulas pendekatan terbaru dalam pengelolaan organisasi di era digital. Membahas bagaimana perusahaan merumuskan strategi yang agile, membangun budaya inovasi, dan beradaptasi terhadap perubahan pasar.</p><p>Buku ini sangat dibutuhkan oleh mahasiswa Fakultas Bisnis dan Manajemen di Wilmar Business Indonesia Polytechnic sebagai referensi utama dalam mata kuliah Manajemen Strategis.</p><h3 class="text-on-surface font-bold text-lg mt-6 mb-3">Topik Pembahasan:</h3><ul class="list-disc pl-5 space-y-2"><li>Konsep dasar manajemen strategis kontemporer.</li><li>Kerangka kerja inovasi dan Design Thinking dalam bisnis.</li><li>Studi kasus perusahaan rintisan (startup) Indonesia.</li><li>Strategi kepemimpinan dalam transformasi digital.</li></ul>'
        },
        2: {
            title: 'Pengantar Kecerdasan Buatan',
            coverTitle: 'Artificial<br>Intelligence',
            author: 'Budi P., M.Kom',
            price: 125000,
            category: 'Teknologi & Informatika',
            badge: 'Prioritas Kampus',
            pages: '278 Hal',
            stock: '20 Buku',
            gradient: 'linear-gradient(to bottom right, #1e293b, #0f172a)',
            coverTextColor: '#67e8f9',
            description: '<p>Buku <strong>"Pengantar Kecerdasan Buatan"</strong> memperkenalkan konsep dasar AI mulai dari Machine Learning, Neural Networks, hingga aplikasi NLP. Sangat cocok untuk mahasiswa Teknik Informatika dan Sistem Informasi.</p><p>Dibutuhkan sebagai referensi wajib mata kuliah AI semester 5 di program studi Informatika WBI.</p><h3 class="text-on-surface font-bold text-lg mt-6 mb-3">Topik Pembahasan:</h3><ul class="list-disc pl-5 space-y-2"><li>Dasar-dasar Machine Learning dan Deep Learning.</li><li>Natural Language Processing (NLP).</li><li>Computer Vision dan implementasinya.</li><li>Etika dan masa depan Kecerdasan Buatan.</li></ul>'
        },
        3: {
            title: 'Sastra: Senja di Jakarta Klasik',
            coverTitle: 'Senja di<br>Jakarta',
            author: 'Mochtar Lubis',
            price: 85000,
            category: 'Sastra & Novel',
            badge: null,
            pages: '196 Hal',
            stock: '10 Buku',
            gradient: 'linear-gradient(to bottom right, #b45309, #431407)',
            coverTextColor: '#fde68a',
            description: '<p>Karya klasik sastra Indonesia yang menceritakan dinamika kehidupan masyarakat urban Jakarta di era pasca-kemerdekaan. Novel ini menjadi jendela untuk memahami kultur dan filosofi masyarakat Indonesia melalui sastra.</p><p>Buku ini dibutuhkan untuk koleksi sastra Indonesia di Perpustakaan Kampus WBI.</p>'
        },
        4: {
            title: 'Dasar Kewirausahaan Berkelanjutan',
            coverTitle: 'Dasar<br>Kewirausahaan',
            author: 'Siti Rahayu',
            price: 95000,
            category: 'Entrepreneurship',
            badge: null,
            pages: '224 Hal',
            stock: '18 Buku',
            gradient: 'linear-gradient(to bottom right, #d4d4d8, #d6d3d1)',
            coverTextColor: '#003215',
            description: '<p>Buku <strong>"Dasar Kewirausahaan Berkelanjutan"</strong> membahas konsep kewirausahaan modern yang berfokus pada keberlanjutan dan dampak sosial. Menjadi panduan bagi mahasiswa yang ingin memulai bisnis dengan prinsip sustainable.</p><p>Sangat relevan dengan visi WBI "Nurturing Entrepreneurs" dan dibutuhkan sebagai bahan ajar mata kuliah Kewirausahaan.</p>'
        },
        5: {
            title: 'Pengantar Bisnis Modern',
            coverTitle: 'Pengantar<br>Bisnis',
            author: 'Tim Dosen WBI',
            price: 210000,
            category: 'Bisnis & Manajemen',
            badge: 'Wajib Smst 1',
            pages: '456 Hal',
            stock: '25 Buku',
            gradient: 'linear-gradient(to bottom right, #003215, #004b23)',
            coverTextColor: '#ffffff',
            description: '<p>Buku wajib semester 1 yang menjadi fondasi pemahaman dunia bisnis. Membahas konsep dasar ekonomi bisnis, pemasaran, manajemen keuangan, dan etika bisnis secara komprehensif.</p><p>Digunakan sebagai buku pegangan utama di hampir seluruh program studi WBI.</p>'
        },
        6: {
            title: 'Algoritma & Struktur Data',
            coverTitle: 'Algoritma<br>& Data',
            author: 'Prof. Hadi Susanto',
            price: 185000,
            category: 'Teknologi & Informatika',
            badge: 'Wajib Smst 3',
            pages: '380 Hal',
            stock: '12 Buku',
            gradient: 'linear-gradient(to bottom right, #1e293b, #0f172a)',
            coverTextColor: '#ffffff',
            description: '<p>Referensi wajib semester 3 untuk mahasiswa Informatika. Membahas algoritma sorting, searching, graph traversal, dynamic programming, dan berbagai struktur data fundamental.</p>'
        },
        7: {
            title: 'Akuntansi Manajerial',
            coverTitle: 'Akuntansi<br>Manajerial',
            author: 'Dr. Maya Sari, Ak.',
            price: 320000,
            category: 'Akuntansi & Keuangan',
            badge: null,
            pages: '512 Hal',
            stock: '8 Buku',
            gradient: 'linear-gradient(to bottom right, #92400e, #78350f)',
            coverTextColor: '#ffffff',
            description: '<p>Buku komprehensif tentang akuntansi manajerial yang mencakup analisis biaya, penganggaran, dan pengambilan keputusan berbasis data keuangan untuk kebutuhan internal perusahaan.</p>'
        },
        8: {
            title: 'Ekonomi Makro Terapan',
            coverTitle: 'Ekonomi<br>Makro',
            author: 'Prof. Ir. Bambang W.',
            price: 190000,
            category: 'Ekonomi',
            badge: null,
            pages: '398 Hal',
            stock: '14 Buku',
            gradient: 'linear-gradient(to bottom right, #115e59, #134e4a)',
            coverTextColor: '#ffffff',
            description: '<p>Membahas teori ekonomi makro dengan pendekatan terapan: kebijakan fiskal, moneter, perdagangan internasional, serta analisis indikator ekonomi Indonesia kontemporer.</p>'
        },
        9: {
            title: 'Sistem Informasi Bisnis',
            coverTitle: 'Sistem<br>Informasi',
            author: 'Dr. Rizky Pratama',
            price: 250000,
            category: 'Teknologi & Bisnis',
            badge: null,
            pages: '420 Hal',
            stock: '11 Buku',
            gradient: 'linear-gradient(to bottom right, #312e81, #1e1b4b)',
            coverTextColor: '#ffffff',
            description: '<p>Mengintegrasikan konsep bisnis dan teknologi informasi. Membahas ERP, CRM, Business Intelligence, dan transformasi digital dalam konteks bisnis modern Indonesia.</p>'
        }
    };

    // Read book ID from URL
    const params = new URLSearchParams(window.location.search);
    const bookId = params.get('id') || '1';
    const book = books[bookId] || books['1'];
    let qty = 1;

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function render() {
        document.getElementById('breadcrumb-category').textContent = book.category;
        document.getElementById('breadcrumb-title').textContent = book.title;
        document.getElementById('book-title').textContent = book.title;
        document.getElementById('cover-title').innerHTML = book.coverTitle;
        document.getElementById('book-author').textContent = book.author;
        document.getElementById('book-price').textContent = formatRupiah(book.price);
        document.getElementById('book-category-badge').textContent = book.category;
        document.getElementById('book-pages').textContent = book.pages;
        document.getElementById('book-stock').textContent = book.stock;
        document.getElementById('book-description').innerHTML = book.description;
        document.getElementById('subtotal-text').textContent = 'Subtotal: ' + formatRupiah(book.price * qty);
        document.getElementById('qty-input').value = qty;

        // Cover styling
        const cover = document.getElementById('book-cover');
        cover.style.background = book.gradient;
        cover.querySelector('h4').style.color = book.coverTextColor;

        // Badge
        const badgeEl = document.getElementById('book-badge');
        if (book.badge) {
            badgeEl.classList.remove('hidden');
            badgeEl.classList.add('inline-flex');
            document.getElementById('badge-text').textContent = book.badge;
        } else {
            badgeEl.classList.add('hidden');
        }

        document.title = book.title + ' - Wilmar Literacy Hub';
    }

    // Qty buttons
    document.getElementById('btn-plus').addEventListener('click', () => {
        qty++;
        render();
    });
    document.getElementById('btn-minus').addEventListener('click', () => {
        if (qty > 1) qty--;
        render();
    });

    render();
</script>
@endsection
