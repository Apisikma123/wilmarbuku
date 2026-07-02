@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10 font-poppins">
    
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm font-medium text-on-surface-variant mb-10 overflow-x-auto whitespace-nowrap hide-scroll">
        <a href="/dashboard" class="hover:text-primary transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a href="#" class="hover:text-primary transition-colors">Katalog Buku</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span id="breadcrumb-category" class="hover:text-primary transition-colors cursor-pointer">Kategori</span>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span id="breadcrumb-title" class="text-on-surface font-semibold">Judul Buku</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Left Column: Book Image -->
        <div class="lg:col-span-4 lg:col-start-1 flex flex-col gap-6">
            <div class="rounded-lg p-4 md:p-8 flex items-center justify-center">
                <div id="book-cover" class="w-full max-w-[260px] aspect-[3/4] rounded-lg shadow-lg flex items-center justify-center p-6 text-center text-white border border-black/5 relative overflow-hidden">
                    <div>
                        <h4 id="cover-title" class="text-xl md:text-2xl font-bold uppercase leading-tight mb-2 tracking-tight"></h4>
                        <p class="text-xs text-white border-t border-white/30 pt-2 mt-2 font-medium">Edisi Terbaru</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Info Badges -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-5 flex flex-col items-center justify-center text-center gap-2 border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)]">
                    <span class="material-symbols-outlined text-primary text-[28px]">import_contacts</span>
                    <div>
                        <span class="block text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Halaman</span>
                        <span id="book-pages" class="block text-sm font-semibold text-on-surface">-</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-5 flex flex-col items-center justify-center text-center gap-2 border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)]">
                    <span class="material-symbols-outlined text-primary text-[28px]">inventory_2</span>
                    <div>
                        <span class="block text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Dibutuhkan</span>
                        <span id="book-stock" class="block text-sm font-semibold text-on-surface">-</span>
                    </div>
                </div>
            </div>

            <!-- Academic Validation Notice (from PRD) -->
            <div class="bg-[#EDF6EE] rounded-lg p-5 border border-primary/20 flex items-start gap-4">
                <div class="bg-primary text-white p-2 rounded-full flex-shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-primary mb-1">Syarat Kelulusan</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Donasi buku ini valid sebagai syarat Surat Keterangan Bebas Pustaka bagi mahasiswa tingkat akhir.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Book Details & Actions -->
        <div class="lg:col-span-8 flex flex-col">
            
            <!-- Header Info -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5 flex-wrap">
                    <span id="book-category-badge" class="bg-[#EDF6EE] text-primary text-[12px] font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-primary/20"></span>
                    <span id="book-badge" class="hidden bg-[#FFF9E6] text-[#996B00] text-[12px] font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-[#996B00]/20 items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">verified</span> <span id="badge-text"></span>
                    </span>
                </div>
                
                <h1 id="book-title" class="text-3xl md:text-[36px] lg:text-[44px] font-bold text-on-surface tracking-tight mb-4 leading-[1.2]"></h1>
                <p class="text-lg text-on-surface-variant font-medium mb-8">Oleh <span id="book-author" class="text-on-surface font-semibold"></span></p>
                
                <div class="flex items-baseline gap-3 mb-2 bg-surface-bright p-5 rounded-lg border border-outline-variant/30 shadow-[0px_4px_20px_rgba(15,23,42,0.02)] inline-block">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">Estimasi Harga Donasi</p>
                    <div class="flex items-baseline gap-2">
                        <span id="book-price" class="text-3xl lg:text-[36px] font-bold text-primary tracking-tight"></span>
                        <span class="text-sm text-on-surface-variant font-medium">/ buku</span>
                    </div>
                </div>
            </div>

            <!-- Action Box -->
            <div class="bg-white rounded-lg p-6 lg:p-8 shadow-[0px_4px_20px_rgba(15,23,42,0.05)] border border-outline-variant/30 mb-10 transition-all hover:shadow-[0px_8px_30px_rgba(15,23,42,0.08)]">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-8 justify-between">
                    
                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-bold text-on-surface-variant mb-3">Jumlah Donasi</label>
                        <!-- Rounded pill quantity selector based on user image -->
                        <div class="flex items-center bg-surface-bright rounded-full h-[52px] w-full md:w-[160px] p-1">
                            <button type="button" id="btn-minus" class="w-11 h-11 rounded-full text-on-surface-variant flex items-center justify-center hover:bg-surface-variant/30 transition-colors active:bg-surface-variant/50">
                                <span class="material-symbols-outlined font-bold text-[20px]">remove</span>
                            </button>
                            <input type="text" id="qty-input" value="1" readonly class="w-full h-full text-center bg-transparent border-none focus:ring-0 font-bold text-on-surface text-[17px] p-0">
                            <!-- Distinct greenish/grayish background for the plus button -->
                            <button type="button" id="btn-plus" class="w-11 h-11 rounded-full bg-[#E5ECE7] text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors active:scale-95">
                                <span class="material-symbols-outlined font-bold text-[20px]">add</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="w-full md:flex-1 flex flex-col items-end gap-3">
                        <div class="flex items-center justify-between md:justify-end w-full gap-4 mb-1">
                            <span class="text-sm text-on-surface-variant font-medium md:hidden">Total Donasi:</span>
                            <p class="text-sm text-on-surface-variant font-medium hidden md:block">Total:</p>
                            <span class="font-bold text-on-surface text-xl" id="subtotal-amount"></span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 w-full justify-end mt-2">
                            <a href="/cart" id="btn-add-cart" class="w-full sm:w-auto flex-grow bg-white text-primary border border-primary font-semibold text-sm md:text-base h-[52px] rounded-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2 px-8">
                                <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                Keranjang
                            </a>
                            <a href="/checkout" id="btn-checkout" class="w-full sm:w-auto flex-grow bg-primary text-white font-semibold text-sm md:text-base h-[52px] rounded-lg hover:bg-primary-container transition-all flex items-center justify-center gap-2 px-8">
                                <span class="material-symbols-outlined text-[20px]">volunteer_activism</span>
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-outline-variant/30 flex-grow pt-8">
                <div class="flex items-center gap-8 border-b border-outline-variant/30 mb-8">
                    <button class="pb-3 text-primary font-bold border-b-[3px] border-primary text-base">Deskripsi Buku</button>
                    <button class="pb-3 text-on-surface-variant hover:text-on-surface font-semibold text-base transition-colors">Detail Distribusi</button>
                </div>
                
                <div id="book-description" class="text-on-surface-variant text-base leading-relaxed space-y-5 prose prose-slate max-w-[75ch]">
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
            description: '<p>Buku <strong>"Manajemen Modern & Strategi Inovasi"</strong> mengulas pendekatan terbaru dalam pengelolaan organisasi di era digital. Membahas bagaimana perusahaan merumuskan strategi yang agile, membangun budaya inovasi, dan beradaptasi terhadap perubahan pasar.</p><p>Buku ini sangat dibutuhkan oleh mahasiswa Fakultas Bisnis dan Manajemen di Wilmar Business Indonesia Polytechnic sebagai referensi utama dalam mata kuliah Manajemen Strategis.</p><h2 class="text-on-surface font-bold text-lg mt-6 mb-3">Topik Pembahasan:</h2><ul class="list-disc pl-5 space-y-2"><li>Konsep dasar manajemen strategis kontemporer.</li><li>Kerangka kerja inovasi dan Design Thinking dalam bisnis.</li><li>Studi kasus perusahaan rintisan (startup) Indonesia.</li><li>Strategi kepemimpinan dalam transformasi digital.</li></ul>'
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
            description: '<p>Buku <strong>"Pengantar Kecerdasan Buatan"</strong> memperkenalkan konsep dasar AI mulai dari Machine Learning, Neural Networks, hingga aplikasi NLP. Sangat cocok untuk mahasiswa Teknik Informatika dan Sistem Informasi.</p><p>Dibutuhkan sebagai referensi wajib mata kuliah AI semester 5 di program studi Informatika WBI.</p><h2 class="text-on-surface font-bold text-lg mt-6 mb-3">Topik Pembahasan:</h2><ul class="list-disc pl-5 space-y-2"><li>Dasar-dasar Machine Learning dan Deep Learning.</li><li>Natural Language Processing (NLP).</li><li>Computer Vision dan implementasinya.</li><li>Etika dan masa depan Kecerdasan Buatan.</li></ul>'
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
        document.getElementById('subtotal-amount').textContent = formatRupiah(book.price * qty);
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
