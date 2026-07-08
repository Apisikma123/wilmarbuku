# 📋 TECHNICAL DUE DILIGENCE REPORT
## WilmarBOOKS — Platform Donasi Buku
**Tanggal Audit:** 7 Juli 2026  
**Auditor:** Principal Software Architect / Security Engineer / DevOps Engineer / QA Lead  
**Versi Aplikasi:** Laravel 13.8 + TailwindCSS + AlpineJS  
**Jenis Audit:** Enterprise Readiness Assessment  
**Klasifikasi:** CONFIDENTIAL

---

# 1. Executive Summary

## Ringkasan Aplikasi
WilmarBOOKS adalah platform donasi buku berbasis Laravel monolith yang memungkinkan pengguna (internal kampus & eksternal) untuk menyumbangkan dana bagi pengadaan buku yang dibutuhkan perpustakaan. Aplikasi ini memiliki flow: katalog buku → keranjang → checkout → pembayaran manual (upload bukti) → konfirmasi admin → tracking status.

## Kelebihan Aplikasi
- ✅ **Konsep bisnis yang jelas** — Flow donasi buku terdefinisi dengan baik dari awal hingga akhir
- ✅ **OTP-based authentication** — Implementasi 2FA via email OTP
- ✅ **Google OAuth** — Integrasi SSO untuk kemudahan login
- ✅ **Security Headers middleware** — Sudah ada X-Frame-Options, HSTS, X-Content-Type-Options
- ✅ **Session management** — Menggunakan database-backed sessions dengan JSON serialization
- ✅ **Image optimization** — Kompresi WebP dengan Intervention Image
- ✅ **Database indexing** — Sudah ada migration untuk search indexes
- ✅ **PWA basic** — Manifest.json dan service worker sudah tersedia
- ✅ **PDF export** — DomPDF untuk laporan admin
- ✅ **Notification system** — In-app messaging + email notification

## Kekurangan Kritis
- ❌ **Hardcoded secrets di `.env`** — Google OAuth credentials terekspos di repository
- ❌ **OTP code disimpan plain text** — Tidak di-hash di database
- ❌ **Tidak ada file upload size limit** yang memadai
- ❌ **AdminController monolith 652 baris** — God Controller pattern
- ❌ **Tidak ada database transaction** untuk operasi checkout yang kritikal
- ❌ **Session-based cart** — Tidak scalable untuk horizontal scaling
- ❌ **Tidak ada rate limiting global** — Hanya pada OTP verify
- ❌ **Tidak ada unit/integration test** yang berarti (hanya scaffolding default Laravel)
- ❌ **Tidak ada logging terstruktur** — Minimal error tracking
- ❌ **Kategori disimpan sebagai comma-separated string** — Pelanggaran 1NF

## Risiko Terbesar
1. **Credential Exposure** — Google Client ID dan Secret terekspos di `.env` yang ter-track git
2. **Race Condition pada Stok** — Tidak ada locking/transaction saat checkout mengurangi stok
3. **Data Integrity** — Kategori sebagai string menyebabkan inkonsistensi data
4. **Scalability Wall** — Session cart + database-backed everything akan bottleneck di ~1.000 concurrent users

## Estimasi Biaya Maintenance
- **Monthly (1 developer):** Rp 15-25 juta
- **Kompleksitas Pengembangan:** Medium-Low (untuk fitur baru sederhana), High (untuk refactoring arsitektur)

---

# 2. Overall Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    CLIENT BROWSER                       │
│  ┌─────────────┐  ┌──────────┐  ┌──────────────────┐   │
│  │ TailwindCSS  │  │ AlpineJS │  │  SweetAlert2     │   │
│  │ (CDN)        │  │ (CDN)    │  │  (CDN)           │   │
│  └─────────────┘  └──────────┘  └──────────────────┘   │
└──────────────────────┬──────────────────────────────────┘
                       │ HTTP
┌──────────────────────▼──────────────────────────────────┐
│                  LARAVEL 13.8                            │
│  ┌──────────────────────────────────────────────────┐   │
│  │                    ROUTES                         │   │
│  │  web.php (147 lines, NO api.php)                  │   │
│  └───────────────────┬──────────────────────────────┘   │
│  ┌───────────────────▼──────────────────────────────┐   │
│  │               MIDDLEWARE                          │   │
│  │  auth │ guest │ admin │ SecurityHeaders │ throttle│   │
│  └───────────────────┬──────────────────────────────┘   │
│  ┌───────────────────▼──────────────────────────────┐   │
│  │              CONTROLLERS (10)                     │   │
│  │  AdminController (652 LOC) ← GOD CONTROLLER      │   │
│  │  AuthController (391 LOC)                         │   │
│  │  CheckoutController (196 LOC)                     │   │
│  │  CartController (122 LOC)                         │   │
│  │  KatalogController (127 LOC)                      │   │
│  │  TransaksiController (56 LOC)                     │   │
│  │  ProfileController (67 LOC)                       │   │
│  │  SearchController (48 LOC)                        │   │
│  │  PesanController (34 LOC)                         │   │
│  └───────────────────┬──────────────────────────────┘   │
│  ┌───────────────────▼──────────────────────────────┐   │
│  │                MODELS (8)                         │   │
│  │  User │ KatalogBuku │ TransaksiCheckout │         │   │
│  │  TransaksiDetail │ PesanMasuk │ Kategori │        │   │
│  │  Penerbit │ MetodePembayaran                      │   │
│  └───────────────────┬──────────────────────────────┘   │
│  ┌───────────────────▼──────────────────────────────┐   │
│  │              DATABASE (MySQL)                     │   │
│  │  16 migrations │ 3 seeders                        │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

### Penilaian Arsitektur

| Aspek | Status | Catatan |
|-------|--------|---------|
| Clean Architecture | ⚠️ Partial | Tidak ada Service/Repository layer |
| Modular Architecture | ❌ Tidak | Semua logic di Controller |
| Layer Separation | ⚠️ Minimal | Controller langsung akses Model |
| Domain Separation | ❌ Tidak | Tidak ada domain boundary |
| Feature Isolation | ❌ Tidak | AdminController menangani 15+ fitur |
| Dependency Direction | ⚠️ Partial | Controller → Model langsung |
| SOLID | ❌ Pelanggaran | SRP dilanggar (AdminController) |
| DRY | ⚠️ Partial | Image processing di-duplicate di 3 tempat |
| KISS | ✅ Ya | Flow sederhana dan mudah dipahami |
| YAGNI | ✅ Ya | Tidak ada over-engineering |
| Event Driven | ⚠️ Minimal | Hanya `PesanMasuk::booted()` event |
| CQRS Ready | ❌ Tidak | Read/Write tercampur |
| DDD Ready | ❌ Tidak | Tidak ada domain layer |
| Service Layer | ❌ Tidak Ada | Business logic langsung di controller |
| Repository Pattern | ❌ Tidak Ada | Eloquent langsung di controller |
| State Management | ⚠️ Session | Cart di session, tidak persistent |

---

# 3. Architecture Audit

## 3.1 Temuan Detail

### 🔴 CRITICAL: God Controller Pattern — AdminController
- **Lokasi:** [AdminController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php)
- **Bukti:** 652 baris, 18 public methods, menangani: dashboard, catalog CRUD, transactions, users CRUD, reports, PDF export, payment methods, settings
- **Dampak:** Sangat sulit di-maintain, test, dan scale. Setiap perubahan kecil berisiko merusak area lain.
- **Solusi:** Pecah menjadi minimal 6 controller terpisah:
  - `AdminDashboardController`
  - `AdminCatalogController`
  - `AdminTransactionController`
  - `AdminUserController`
  - `AdminReportController`
  - `AdminPaymentMethodController`
- **Estimasi Effort:** 2-3 hari

### 🔴 CRITICAL: Tidak Ada Service Layer
- **Lokasi:** Seluruh controller
- **Bukti:** Business logic (stock calculation, transaction processing, OTP generation) langsung di controller
- **Contoh kode bermasalah di** [CheckoutController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L84-L93):
```php
// Soft Booking: Kurangi stok saat checkout — langsung di controller
$buku = \App\Models\KatalogBuku::find($id);
if ($buku) {
    $newStok = max(0, $buku->stok_dibutuhkan - $details['qty']);
    $updateData = ['stok_dibutuhkan' => $newStok];
    if ($newStok == 0) {
        $updateData['status_buku'] = 'Tersedia';
    }
    $buku->update($updateData);
}
```
- **Dampak:** Logic bocor ke controller, tidak reusable, tidak testable
- **Solusi:** Buat `BookStockService`, `CheckoutService`, `AuthService`, `NotificationService`
- **Estimasi Effort:** 3-5 hari

### 🟡 HIGH: Duplikasi Kode Image Processing
- **Lokasi:** 
  - [AdminController.php L135-154](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L135-L154) (storeBook)
  - [AdminController.php L211-229](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L211-L229) (updateBook)
  - [CheckoutController.php L136-161](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L136-L161) (uploadProof)
- **Bukti:** Blok kode yang hampir identik di 3 tempat:
```php
$manager = new ImageManager(new Driver());
$image = $manager->decode($file->getRealPath());
$image->scale(width: 800);
$filename = time() . '_' . uniqid() . '.webp';
```
- **Dampak:** Perubahan harus dilakukan di 3 tempat, risiko inkonsistensi
- **Solusi:** Extract ke `ImageService` atau trait `HandlesImageUpload`
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: AppServiceProvider Global Query Pollution
- **Lokasi:** [AppServiceProvider.php](file:///d:/WILMARBOOKS/app/Providers/AppServiceProvider.php#L22-L35)
- **Bukti:**
```php
View::composer('*', function ($view) {
    $view->with('global_kategoris', Kategori::all());
    $view->with('global_penerbits', Penerbit::all());
    $totalBukuTerkumpul = TransaksiDetail::whereHas('transaksi', function($q) {
        $q->where('status_tracking', 'Selesai')->orWhere('status_pembayaran', 'Paid');
    })->sum('qty');
    $donaturAktif = User::where('role', '!=', 'admin')->count();
});
```
- **Dampak:** **4 query database tambahan di SETIAP request**, termasuk API, admin, halaman error, dll. Pada 1000 concurrent users = 4000 query tambahan yang tidak perlu.
- **Solusi:** 
  1. Gunakan View Composer yang targeted (hanya untuk views yang butuh)
  2. Cache hasilnya: `Cache::remember('global_kategoris', 3600, ...)`
- **Estimasi Effort:** 0.5 hari

---

# 4. Scalability Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Horizontal Scaling | ❌ Tidak Siap | Session cart di server, no Redis |
| Vertical Scaling | ⚠️ Terbatas | MySQL single instance |
| Load Balancer | ❌ Tidak Siap | Sticky sessions required karena cart |
| Redis | ❌ Configured tapi tidak digunakan | `.env` ada config Redis tapi tidak dipakai |
| Caching | ❌ Tidak Ada | Database cache driver, tidak ada cache implementasi |
| Queue | ⚠️ Partial | Configured (database driver) tapi email dikirim synchronously |
| Job/Background Worker | ❌ Tidak Ada | Tidak ada custom job class |
| CDN | ❌ Tidak Ada | Assets served locally |
| Image Optimization | ✅ Ada | WebP compression via Intervention |
| Pagination | ⚠️ Partial | Hanya di kategori page (12/page) |
| Infinite Scroll | ❌ Tidak Ada | — |
| Lazy Loading | ❌ Tidak Ada | Semua loaded upfront |
| Virtual List | ❌ Tidak Ada | — |
| API Rate Limit | ⚠️ Minimal | Hanya `throttle:5,1` pada OTP |
| Database Sharding | ❌ Tidak Ada | — |
| Connection Pool | ⚠️ Default | Laravel default MySQL pool |
| Stateless Deployment | ❌ Tidak Siap | Session cart = stateful |
| Docker | ❌ Tidak Ada | No Dockerfile |
| Kubernetes | ❌ Tidak Ada | — |
| Microservices Ready | ❌ Tidak | Monolith tanpa boundary |

### 🔴 CRITICAL: Session-Based Cart Tidak Scalable
- **Lokasi:** [CartController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/CartController.php)
- **Bukti:** `session()->get('cart', [])` dan `session()->put('cart', $cart)`
- **Dampak:** 
  - Tidak bisa horizontal scale tanpa sticky sessions
  - Cart hilang saat session expire (2 jam)
  - Tidak bisa share cart across devices
- **Solusi:** Pindahkan cart ke database table `carts` dengan relasi ke user
- **Estimasi Effort:** 2 hari

### 🔴 CRITICAL: Email Dikirim Synchronously
- **Lokasi:** [PesanMasuk.php L29-33](file:///d:/WILMARBOOKS/app/Models/PesanMasuk.php#L29-L33)
```php
static::created(function ($pesanMasuk) {
    if ($pesanMasuk->user && $pesanMasuk->user->email) {
        Mail::to($pesanMasuk->user->email)->send(new NotificationMail($pesanMasuk));
    }
});
```
- **Dampak:** Setiap pembuatan pesan akan menunggu email terkirim, blocking request user 2-10 detik. Jika email server down, seluruh notifikasi gagal.
- **Solusi:** `Mail::to(...)->queue(new NotificationMail(...))` atau dispatch via Job
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: Tidak Ada Pagination di Halaman Admin
- **Lokasi:** [AdminController.php L77](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L77) — `KatalogBuku::latest()->get()`
- **Lokasi:** [AdminController.php L278-280](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L278-L280) — `TransaksiCheckout::...->get()`
- **Lokasi:** [AdminController.php L436](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L436) — `User::latest()->get()`
- **Dampak:** Dengan 10.000 buku, 100.000 transaksi, atau 50.000 users, halaman admin akan timeout atau OOM
- **Solusi:** Implementasi `->paginate(25)` di semua query admin
- **Estimasi Effort:** 1 hari

---

# 5. Performance Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Initial Loading | ⚠️ Sedang | Loading overlay present, tapi CDN dependencies banyak |
| TTFB | ⚠️ Potensi lambat | 4 global query per request |
| Bundle Size | 🔴 Buruk | TailwindCSS CDN = ~350KB unoptimized |
| Code Splitting | ❌ Tidak Ada | Single bundle |
| Tree Shaking | ❌ Tidak | CDN-based, no tree shaking |
| Lazy Import | ❌ Tidak Ada | — |
| N+1 Query | 🔴 Ada | Dashboard, reports loading nested relations |
| Database Index | ⚠️ Partial | Ada index judul/pengarang, tapi kurang di transaksi |
| Slow Query | ⚠️ Potensi | `whereHas` nested tanpa index |
| Memory Leak | ⚠️ Potensi | `->get()` tanpa limit pada admin pages |
| Caching Strategy | ❌ Tidak Ada | Zero caching |
| Compression | ❌ Tidak Ada | No gzip/brotli config |
| Image Size | ✅ Ditangani | WebP compression |

### 🔴 CRITICAL: TailwindCSS via CDN di Production
- **Lokasi:** [user.blade.php L10](file:///d:/WILMARBOOKS/resources/views/layouts/user.blade.php#L10)
```html
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
```
- **Dampak:** 
  - CDN script = ~350KB JavaScript yang harus diparse di setiap page load
  - JIT compilation terjadi di browser = lambat
  - **Jika CDN down, seluruh styling hilang**
  - Tidak bisa di-cache efektif
  - Melanggar CSP best practice
- **Solusi:** Gunakan Vite build pipeline yang sudah ada (Tailwind sudah di `package.json`)
- **Estimasi Effort:** 0.5 hari

### 🔴 CRITICAL: External CDN Dependencies Tanpa Fallback
- **Lokasi:** [user.blade.php L10-25](file:///d:/WILMARBOOKS/resources/views/layouts/user.blade.php#L10-L25)
- **Daftar CDN dependencies:**
  1. `cdn.tailwindcss.com` — Styling engine
  2. `fonts.googleapis.com` — Google Fonts (Material Symbols + Poppins)
  3. `cdn.jsdelivr.net` — SweetAlert2
  4. `unpkg.com` — Lottie animation
  5. `lottie.host` — Lottie animation file
- **Dampak:** 5 external dependencies = 5 potential single points of failure. Di jaringan internal kampus yang restricted, CDN mungkin diblokir.
- **Solusi:** Bundle semua assets via Vite, self-host fonts
- **Estimasi Effort:** 1 hari

### 🟡 HIGH: AppServiceProvider Global Queries (N+1 Variant)
- **Lokasi:** [AppServiceProvider.php L22-35](file:///d:/WILMARBOOKS/app/Providers/AppServiceProvider.php#L22-L35)
- **Bukti:** 4 query berjalan di SETIAP request (termasuk admin pages, API, error pages)
- **Impact Calculation:**
  - 100 users × 10 page views = 1,000 requests × 4 queries = **4,000 unnecessary queries**
  - Di 10,000 users: **400,000 unnecessary queries per batch**
- **Solusi:** Caching + targeted View Composer
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: N+1 Query di Dashboard Admin
- **Lokasi:** [AdminController.php L44-55](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L44-L55)
```php
$transactions = TransaksiCheckout::with('details')
    ->where('status_pembayaran', 'Paid')
    ->get();
foreach ($transactions as $trx) {
    $months[$key]['books'] += $trx->details->sum('qty');
}
```
- **Dampak:** Menghitung chart data di PHP dengan loop, bukan aggregate SQL. Dengan 10,000 transaksi = memuat semua ke memory.
- **Solusi:** Gunakan `DB::raw('SUM(qty)')` dan `GROUP BY MONTH(created_at)`
- **Estimasi Effort:** 1 hari

---

# 6. Backend Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Folder Structure | ⚠️ Basic | Standard Laravel, tapi datar |
| API Design | ❌ Tidak Ada | Hanya web routes, no API routes |
| REST Standard | N/A | Bukan REST API |
| Naming Convention | ⚠️ Mixed | Indonesian/English mix |
| Validation | ⚠️ Partial | Ada di controller, tapi tidak konsisten |
| Business Logic | ❌ Di Controller | Tidak ada service layer |
| Error Handling | ⚠️ Minimal | Generic catch, stack trace di production |
| Exception Handling | 🔴 Buruk | Stack trace exposed di JSON response |
| Logging | ⚠️ Minimal | Hanya di Google login |
| Middleware | ✅ Cukup | Auth, admin, security headers |
| Authentication | ✅ Baik | OTP + Google OAuth |
| Authorization | ⚠️ Partial | Hanya role-based, no policy |
| Session | ✅ Database-backed | JSON serialization |
| Rate Limiter | ⚠️ Minimal | Hanya OTP verify |
| Input Validation | ⚠️ Partial | Ada tapi tidak semua field |
| File Upload | ⚠️ Partial | Validasi mime tapi no size limit |
| Transaction | ❌ Tidak Ada | Zero DB transactions |
| Repository Pattern | ❌ Tidak Ada | — |
| Dependency Injection | ❌ Tidak Ada | Direct model calls |
| Secret Management | 🔴 Buruk | Secrets in `.env`, tracked by git |

### 🔴 CRITICAL: Stack Trace Exposure di Production
- **Lokasi:** [AdminController.php L185](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L185)
```php
return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
```
- **Dampak:** Full stack trace terekspos ke client. Attacker bisa melihat:
  - Path file server
  - Versi library/framework
  - Internal method names
  - Database query structure
- **Severity:** CRITICAL (OWASP: Sensitive Data Exposure)
- **Solusi:** Hapus `trace`, gunakan generic error message di production, log detail ke server
- **Estimasi Effort:** 0.5 jam

### 🔴 CRITICAL: Tidak Ada Database Transaction pada Checkout
- **Lokasi:** [CheckoutController.php L36-103](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L36-L103)
- **Bukti:** Method `process()` melakukan:
  1. Create `TransaksiCheckout`
  2. Loop create `TransaksiDetail` (multiple inserts)
  3. Loop update `KatalogBuku` stock (multiple updates)
  4. Clear session cart
  - **Tanpa `DB::beginTransaction()` / `DB::commit()`**
- **Dampak:** Jika error terjadi di langkah 3, transaksi sudah dibuat tapi stok belum dikurangi, atau sebaliknya. **Data integrity rusak.**
- **Solusi:**
```php
DB::transaction(function () use ($cart, $user, ...) {
    $transaksi = TransaksiCheckout::create([...]);
    foreach ($cart as $id => $details) {
        TransaksiDetail::create([...]);
        KatalogBuku::where('id', $id)->lockForUpdate()->decrement('stok_dibutuhkan', $details['qty']);
    }
});
```
- **Estimasi Effort:** 0.5 hari

### 🔴 CRITICAL: Race Condition pada Stok Buku
- **Lokasi:** [CheckoutController.php L85-93](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L85-L93)
```php
$buku = KatalogBuku::find($id);
$newStok = max(0, $buku->stok_dibutuhkan - $details['qty']);
$buku->update($updateData);
```
- **Dampak:** Dua user checkout buku yang sama secara bersamaan:
  - User A: baca stok = 5, kurangi 3 → update stok = 2
  - User B: baca stok = 5 (sebelum A selesai), kurangi 3 → update stok = 2
  - **Stok seharusnya = -1 (oversold), tapi tertulis = 2**
- **Solusi:** `KatalogBuku::where('id', $id)->lockForUpdate()->first()` di dalam transaction
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: File Upload Tanpa Size Limit
- **Lokasi:** [AdminController.php L132](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L132)
```php
'cover_file' => 'nullable|image|mimes:jpeg,jpg,png,webp',
// Tidak ada max size!
```
- **Lokasi:** [CheckoutController.php L133](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L133)
```php
'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp',
// Tidak ada max size!
```
- **Dampak:** User bisa upload file 100MB+ → disk penuh, memory exhaustion
- **Solusi:** Tambahkan `max:2048` (2MB) pada validation rule
- **Estimasi Effort:** 10 menit

---

# 7. Frontend Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Folder Structure | ⚠️ Basic | Standard Blade views |
| Component Reusability | ❌ Minimal | 2 layout components saja |
| Atomic Design | ❌ Tidak | Tidak ada component library |
| State Management | ⚠️ Session | Cart via PHP session |
| Accessibility | ⚠️ Partial | Tidak ada ARIA labels konsisten |
| Responsive Design | ✅ Ada | Mobile-first dengan Tailwind |
| Loading Skeleton | ⚠️ Partial | Loading overlay ada, tapi bukan skeleton |
| Empty State | ⚠️ Partial | Beberapa halaman ada |
| Error State | ⚠️ Partial | Custom 403, 404, 419, 500 pages |
| Dark Mode | ❌ Tidak Ada | Meski darkMode di Tailwind config |
| SEO | ⚠️ Minimal | Title tag generic "WilmarBOOKS" di semua halaman |
| Meta Tags | ❌ Minimal | Tidak ada meta description, OG tags |

### 🟡 HIGH: Inline JavaScript & CSS di Blade Templates
- **Lokasi:** Seluruh view files (terutama yang besar)
  - [user.blade.php](file:///d:/WILMARBOOKS/resources/views/layouts/user.blade.php) — 537 lines termasuk JavaScript
  - [catalog.blade.php](file:///d:/WILMARBOOKS/resources/views/admins/catalog.blade.php) — 49,353 bytes
  - [transactions.blade.php](file:///d:/WILMARBOOKS/resources/views/admins/transactions.blade.php) — 24,282 bytes
- **Dampak:**
  - Tidak bisa di-cache oleh browser
  - Melanggar Content Security Policy
  - Sulit di-maintain dan di-test
- **Solusi:** Extract ke file `.js` terpisah, bundle via Vite
- **Estimasi Effort:** 3-5 hari

### 🟡 HIGH: SEO Tidak Optimal
- **Lokasi:** [user.blade.php L6](file:///d:/WILMARBOOKS/resources/views/layouts/user.blade.php#L6)
```html
<title>WilmarBOOKS</title>
```
- **Dampak:** Semua halaman memiliki title yang sama, tidak ada meta description, tidak ada OpenGraph tags
- **Solusi:** Dynamic title dengan `@yield('title')`, tambah meta tags
- **Estimasi Effort:** 0.5 hari

---

# 8. Database Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Normalization | 🔴 Pelanggaran | Kategori sebagai comma-separated string |
| Indexes | ⚠️ Partial | judul_buku, pengarang saja |
| Foreign Keys | ✅ Ada | user_id, buku_id, kode_tracking |
| Cascade | ✅ Ada | ON DELETE CASCADE |
| Constraints | ⚠️ Partial | Enum untuk status, tapi ada mismatch |
| Unique Index | ⚠️ Partial | Email unique, kode_tracking primary |
| Composite Index | ❌ Tidak Ada | — |
| Nullable Fields | ⚠️ Banyak | Banyak field nullable tanpa alasan jelas |
| Data Integrity | 🔴 Bermasalah | Enum mismatch antara migration dan controller |
| Migration | ✅ Ada | 16 migration files |
| Seeders | ⚠️ Partial | Hanya 3 seeders |
| Soft Delete | ❌ Tidak Ada | Hard delete everywhere |
| Audit Log | ❌ Tidak Ada | — |
| Search Performance | ⚠️ LIKE query | Menggunakan `LIKE '%..%'` — full table scan |

### 🔴 CRITICAL: Kategori Melanggar 1NF (First Normal Form)
- **Lokasi:** [KatalogBuku migration L18](file:///d:/WILMARBOOKS/database/migrations/2026_07_01_000001_create_katalog_buku_table.php#L18)
```php
$table->string('kategori')->nullable(); // "Fiksi, Edukasi, Sains"
```
- **Lokasi:** [AdminController.php L170](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L170)
```php
$validated['kategori'] = implode(', ', $categories);
```
- **Dampak:**
  - Tidak bisa query per kategori secara efisien
  - `WHERE kategori LIKE '%Fiksi%'` bisa match "Non-Fiksi"
  - Tidak bisa JOIN dengan tabel Kategori
  - Tidak bisa aggregate per kategori
- **Solusi:** Buat pivot table `buku_kategori` (many-to-many relationship)
```
katalog_buku ←→ buku_kategori ←→ kategoris
```
- **Estimasi Effort:** 2-3 hari

### 🔴 CRITICAL: Status Tracking Enum Mismatch
- **Migration mendefinisikan:**
```php
// transaksi_checkout migration
$table->enum('status_tracking', [
    'Menunggu Pembayaran', 'Dana Diterima', 'Dipesan Admin', 
    'Dikirim ke Perpus', 'Masuk Katalog'
]);
```
- **Controller menggunakan status berbeda:**
```php
// AdminController L370
'status_tracking' => 'required|in:Menunggu Pembayaran,Menunggu Konfirmasi,Dana Diterima,
                       Dalam Pengiriman,Selesai,Dibatalkan'
```
- **Dampak:** Migration enum dan actual values **tidak sesuai**. Ini berarti:
  - Ada ALTER TABLE yang tidak ter-track di migration
  - Atau ada data inconsistency di database
  - Status "Menunggu Konfirmasi", "Dalam Pengiriman", "Selesai", "Dibatalkan" **tidak ada di enum original**
- **Solusi:** Buat migration baru untuk update enum, atau ubah ke string column
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: Tidak Ada Soft Delete
- **Lokasi:** [AdminController.php L268-274](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L268-L274)
```php
public function destroyBook($id) {
    $book = KatalogBuku::findOrFail($id);
    $book->delete(); // Hard delete!
}
```
- **Dampak:** Data hilang permanen, tidak bisa di-restore, audit trail hilang
- **Solusi:** Implementasi `SoftDeletes` trait di semua model
- **Estimasi Effort:** 1 hari

### 🟡 HIGH: Tidak Ada Composite Index di Transaksi
- **Bukti:** Query yang sering dijalankan:
```php
TransaksiCheckout::where('user_id', auth()->id())
    ->where('status_tracking', 'Selesai')
    ->latest()->get();
```
- **Tapi tidak ada index pada `(user_id, status_tracking)` atau `(user_id, status_pembayaran)`**
- **Dampak:** Full table scan pada tabel transaksi yang akan tumbuh besar
- **Solusi:** Tambah composite index
- **Estimasi Effort:** 0.5 jam

### 🟡 HIGH: OTP Code Tersimpan Plain Text
- **Lokasi:** [users migration (add_otp)](file:///d:/WILMARBOOKS/database/migrations/2026_07_02_084104_add_otp_to_users_table.php)
```php
$table->string('otp_code')->nullable();
```
- **Dampak:** Siapa pun yang punya akses database bisa membaca OTP aktif semua user
- **Solusi:** Hash OTP sebelum simpan: `Hash::make($otpCode)`, verifikasi dengan `Hash::check()`
- **Estimasi Effort:** 1 hari

---

# 9. API Audit

> **Status:** Tidak dapat diverifikasi sepenuhnya — aplikasi **tidak memiliki API layer**.

| Aspek | Status |
|-------|--------|
| REST Standard | ❌ N/A — Tidak ada API routes |
| API Versioning | ❌ Tidak Ada |
| Error Response Standard | ❌ Inkonsisten |
| Pagination API | ❌ Tidak Ada |
| Rate Limiting API | ❌ Tidak Ada |
| API Documentation | ❌ Tidak Ada |

### Temuan
- **Lokasi:** [routes/web.php](file:///d:/WILMARBOOKS/routes/web.php) — Hanya web routes
- **Bukti:** Tidak ada file `routes/api.php` atau API resource controller
- **Dampak:** Tidak bisa digunakan oleh mobile app atau third-party integrations
- **Catatan:** Beberapa endpoint mengembalikan JSON (`CartController`, `SearchController`, `AdminController` via AJAX) tapi tanpa standard response format
- **Solusi:** Jika diperlukan, buat API layer terpisah dengan Laravel API Resources
- **Estimasi Effort:** 3-5 hari

### 🟡 Inkonsistensi Response Format
- **Contoh 1:** [CartController L66-69](file:///d:/WILMARBOOKS/app/Http/Controllers/CartController.php#L66-L69) — `{success: true, message, cart_count}`
- **Contoh 2:** [AdminController L95-98](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L95-L98) — `{success: true, kategori}`
- **Contoh 3:** [AdminController L185](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L185) — `{error, trace}`
- Tidak ada standard envelope: `{status, data, message, errors}`

---

# 10. Security Audit (OWASP Top 10)

## OWASP Mapping

| # | OWASP Category | Status | Severity |
|---|---------------|--------|----------|
| A01 | Broken Access Control | ⚠️ Partial | HIGH |
| A02 | Cryptographic Failures | 🔴 Bermasalah | CRITICAL |
| A03 | Injection | ⚠️ Low Risk | MEDIUM |
| A04 | Insecure Design | ⚠️ Bermasalah | HIGH |
| A05 | Security Misconfiguration | 🔴 Bermasalah | CRITICAL |
| A06 | Vulnerable Components | ⚠️ Perlu Review | MEDIUM |
| A07 | Auth Failures | ⚠️ Partial | HIGH |
| A08 | Data Integrity Failures | 🔴 Bermasalah | HIGH |
| A09 | Logging & Monitoring | ❌ Minimal | HIGH |
| A10 | SSRF | ⚠️ Low Risk | LOW |

### 🔴 CRITICAL: Credential Exposure (A02 + A05)
- **Lokasi:** [.env L68-69](file:///d:/WILMARBOOKS/.env#L68-L69)
```
GOOGLE_CLIENT_ID=[REDACTED]
GOOGLE_CLIENT_SECRET=[REDACTED]
```
- **Dampak:** Google OAuth Client Secret terekspos. Jika repository publik atau di-share, attacker bisa:
  - Impersonate aplikasi
  - Mendapat akses ke Google API
  - Melakukan OAuth phishing
- **Solusi:** 
  1. Segera rotate credentials di Google Cloud Console
  2. Pastikan `.env` ada di `.gitignore` (sudah ada)
  3. Gunakan secret manager (Vault, AWS Secrets Manager)
- **Estimasi Effort:** 1 jam (rotate) + 1 hari (secret manager)

### 🔴 CRITICAL: APP_DEBUG=true (A05)
- **Lokasi:** [.env L4](file:///d:/WILMARBOOKS/.env#L4) — `APP_DEBUG=true`
- **Dampak:** Di production, error pages akan menampilkan:
  - Full stack trace
  - Database credentials
  - Environment variables
  - Server path
- **Solusi:** Set `APP_DEBUG=false` di production
- **Estimasi Effort:** 1 menit

### 🔴 CRITICAL: Stack Trace di Error Response (A05)
- **Lokasi:** [AdminController.php L185](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L185)
- **Sudah dibahas di Backend Audit**

### 🟡 HIGH: IDOR (Insecure Direct Object Reference) — Track Tanpa Auth Check (A01)
- **Lokasi:** [TransaksiController.php L42-53](file:///d:/WILMARBOOKS/app/Http/Controllers/TransaksiController.php#L42-L53)
```php
public function track(Request $request) {
    $kode = $request->query('kode');
    if ($kode) {
        $transaksiDetail = TransaksiDetail::with(['buku', 'transaksi'])
            ->where('kode_tracking', $kode)
            ->first();
    }
    return view('users.track', compact('transaksiDetail', 'kode'));
}
```
- **Dampak:** Meskipun dalam route `auth`, tracking menampilkan data transaksi berdasarkan kode saja **tanpa memverifikasi `user_id`**. User A bisa melihat transaksi User B dengan menebak kode tracking.
- **Solusi:** Tambahkan `->whereHas('transaksi', fn($q) => $q->where('user_id', auth()->id()))`
- **Estimasi Effort:** 15 menit

### 🟡 HIGH: Tidak Ada Content Security Policy (A05)
- **Lokasi:** [SecurityHeaders.php](file:///d:/WILMARBOOKS/app/Http/Middleware/SecurityHeaders.php)
- **Bukti:** Header yang ada:
  - ✅ X-Frame-Options: SAMEORIGIN
  - ✅ X-Content-Type-Options: nosniff
  - ✅ Referrer-Policy
  - ✅ Strict-Transport-Security
  - ❌ **Content-Security-Policy: TIDAK ADA**
  - ❌ **Permissions-Policy: TIDAK ADA**
  - ❌ **X-XSS-Protection: TIDAK ADA** (deprecated tapi masih berguna)
- **Dampak:** Tanpa CSP, inline scripts dan external resources tidak dibatasi → XSS risk
- **Solusi:** Tambahkan CSP header yang ketat
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: Mass Assignment Risk (A04)
- **Lokasi:** [AdminController.php L251](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L251)
```php
$book->update($validated);
```
- **Bukti:** Meskipun menggunakan `$validated`, field `cover_image` dan `kategori` bisa di-inject melalui request karena ada di `$fillable`
- **Dampak:** Admin yang kurang berhati-hati bisa inject data yang tidak diinginkan
- **Solusi:** Explicit field assignment daripada bulk update dari validated data
- **Estimasi Effort:** 0.5 hari

### 🟡 HIGH: SSL Verification Disabled (A05)
- **Lokasi:** [AuthController.php L217-218](file:///d:/WILMARBOOKS/app/Http/Controllers/AuthController.php#L217-L218)
```php
$verifySSL = config('app.env') === 'production';
$guzzleClient = new \GuzzleHttp\Client(['verify' => $verifySSL]);
```
- **Dampak:** Di non-production, SSL verification dimatikan → Man-in-the-Middle attack
- **Solusi:** Hanya disable di local development, use proper CA bundle
- **Estimasi Effort:** 0.5 jam

### ⚠️ MEDIUM: Trusted Device Cookie Tanpa Encryption
- **Lokasi:** [AuthController.php L153](file:///d:/WILMARBOOKS/app/Http/Controllers/AuthController.php#L153)
```php
Cookie::queue('trusted_device_user_' . $user->id, '1', 60 * 24 * 30);
```
- **Dampak:** Cookie name mengandung user ID, value sederhana '1'. Attacker bisa forge cookie ini untuk bypass OTP.
- **Solusi:** Gunakan signed/encrypted cookie dengan random token, simpan token di database
- **Estimasi Effort:** 1 hari

### ⚠️ MEDIUM: Session Layout Detection via Referer
- **Lokasi:** [web.php L104-114](file:///d:/WILMARBOOKS/routes/web.php#L104-L114)
```php
$referer = request()->headers->get('referer');
if (str_ends_with($referer, '8000/') || str_contains($referer, '/login')) {
    session(['is_user' => false]);
}
```
- **Dampak:** Referer header bisa di-forge. Logic bisnis bergantung pada header yang tidak reliable. Port hardcoded `8000`.
- **Solusi:** Gunakan `auth()->check()` untuk menentukan layout
- **Estimasi Effort:** 1 jam

---

# 11. Business Logic Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Business Rule Konsisten | ⚠️ Partial | Stock management logic ada di 3 tempat |
| Logic Bocor | 🔴 Ya | Semua logic di controller |
| Mudah Dipelihara | ⚠️ Sedang | Untuk perubahan kecil ya, besar tidak |
| Duplicate Logic | 🔴 Ya | Stock update di 4 tempat berbeda |
| Future Feature | ⚠️ Sulit | Tidak ada abstraction layer |

### 🔴 CRITICAL: Stock Management Logic Tersebar (Scattered Business Logic)

Logika pengelolaan stok buku tersebar di **4 lokasi berbeda**:

1. **Checkout (kurangi stok):** [CheckoutController.php L84-93](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L84-L93)
2. **Cancel by admin (kembalikan stok):** [AdminController.php L329-341](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L329-L341)
3. **Status update cancel (kembalikan stok):** [AdminController.php L386-398](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L386-L398)
4. **Status update un-cancel (kurangi stok):** [AdminController.php L401-413](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L401-L413)

**Dampak:** Jika business rule berubah (misal: stok tidak boleh negatif, atau perlu logging perubahan stok), harus diubah di 4 tempat. Sangat rentan terhadap bug dan inkonsistensi.

**Solusi:** Buat `StockService` dengan method:
```php
class StockService {
    public function reserve(KatalogBuku $buku, int $qty): void;
    public function release(KatalogBuku $buku, int $qty): void;
}
```

---

# 12. Code Quality Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Naming | ⚠️ Mixed | Indonesian/English inconsistent |
| Cyclomatic Complexity | 🔴 Tinggi | AdminController `updateTransactionStatus` |
| Magic String | 🔴 Banyak | 'Selesai', 'Dibatalkan', 'Paid', 'Unpaid' |
| Dead Code | ⚠️ Ada | LoginRequest.php, ProfileUpdateRequest.php unused |
| Duplicate Code | 🔴 Ada | Image processing 3x, stock logic 4x |
| Function Length | 🔴 Terlalu panjang | `storeBook` 70 lines, `updateTransactionStatus` 70 lines |
| File Size | 🔴 Terlalu besar | AdminController 652 LOC, catalog.blade 49KB |
| Comment Quality | ⚠️ Minimal | Sedikit komentar, kebanyakan bahasa Indonesia |
| Readability | ⚠️ Sedang | Bisa dibaca tapi sulit di-maintain |
| Testability | 🔴 Rendah | Logic di controller, no interfaces |
| Code Smell | 🔴 Banyak | God class, feature envy, long method |
| Technical Debt | 🔴 Signifikan | Estimasi 2-4 minggu untuk membersihkan |
| Lint | ❌ Tidak jalan | `pint` ada tapi tidak ada CI integration |

### 🟡 HIGH: Magic Strings Everywhere
```php
// Status scattered across codebase:
'Menunggu Pembayaran'  // CheckoutController, AdminController
'Menunggu Konfirmasi'  // CheckoutController, TransaksiController
'Dana Diterima'        // AdminController
'Dalam Pengiriman'     // AdminController
'Selesai'              // AdminController, TransaksiController, AppServiceProvider
'Dibatalkan'           // AdminController, TransaksiController
'Paid'                 // Multiple files
'Unpaid'               // CheckoutController
'Failed'               // AdminController
'admin'                // Multiple files
'user_internal'        // Multiple files
'user_external'        // AuthController
'Dibutuhkan'           // KatalogController, AdminController
'Tersedia'             // CheckoutController, AdminController
'Prioritas'            // KatalogController
```
- **Solusi:** Buat Enum classes:
```php
enum TransactionStatus: string {
    case WAITING_PAYMENT = 'Menunggu Pembayaran';
    case WAITING_CONFIRMATION = 'Menunggu Konfirmasi';
    // ...
}
```
- **Estimasi Effort:** 1 hari

### 🟡 HIGH: Dead Code / Unused Files
- [LoginRequest.php](file:///d:/WILMARBOOKS/app/Http/Requests/Auth/LoginRequest.php) — Tidak digunakan, auth custom di AuthController
- [ProfileUpdateRequest.php](file:///d:/WILMARBOOKS/app/Http/Requests/ProfileUpdateRequest.php) — Tidak digunakan
- [fix_image.php](file:///d:/WILMARBOOKS/fix_image.php) — Script one-time di root project
- `wilmar` dan `wilmaru` files di root — Unknown purpose
- **Estimasi Effort:** 0.5 jam

---

# 13. DevOps Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Dockerfile | ❌ Tidak Ada | — |
| docker-compose | ❌ Tidak Ada | — |
| GitHub Actions | ❌ Tidak Ada | — |
| CI/CD | ❌ Tidak Ada | — |
| Monitoring | ❌ Tidak Ada | — |
| Metrics | ❌ Tidak Ada | — |
| Log Aggregation | ❌ Tidak Ada | Single file log |
| Sentry | ❌ Tidak Ada | — |
| Grafana | ❌ Tidak Ada | — |
| Prometheus | ❌ Tidak Ada | — |
| Backup Strategy | ❌ Tidak Ada | — |
| Disaster Recovery | ❌ Tidak Ada | — |

> **Status:** Tidak ada infrastruktur DevOps sama sekali. Ini adalah kelemahan KRITIS untuk production readiness.

---

# 14. Testing Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Unit Test | ❌ Tidak Ada | Hanya ExampleTest default |
| Integration Test | ❌ Tidak Ada | Auth tests dari scaffolding |
| E2E Test | ❌ Tidak Ada | — |
| Coverage | ~0% | Tidak ada test yang meaningful |
| Mock | ❌ Tidak Ada | — |
| Performance Test | ❌ Tidak Ada | — |
| Load Test | ❌ Tidak Ada | — |

### 🔴 CRITICAL: Zero Test Coverage untuk Business Logic

- **Lokasi:** [tests/](file:///d:/WILMARBOOKS/tests)
- **Bukti:** 
  - `tests/Unit/ExampleTest.php` — Default Laravel test (`assert true === true`)
  - `tests/Feature/Auth/` — 6 files dari Laravel Breeze scaffolding, **kemungkinan broken** karena auth system sudah di-custom
  - **Tidak ada test untuk:** Checkout flow, cart management, stock management, admin operations, notification system
- **Dampak:** Tidak ada safety net untuk refactoring. Setiap perubahan kode berisiko memperkenalkan bug tanpa terdeteksi.
- **Solusi:** Prioritas test:
  1. `CheckoutServiceTest` — Test stock management dan transaction integrity
  2. `AuthControllerTest` — Test OTP flow, Google OAuth
  3. `AdminTransactionTest` — Test status update dan stock reversal
- **Estimasi Effort:** 5-7 hari untuk critical coverage

---

# 15. Deployment Audit

| Aspek | Status | Detail |
|-------|--------|--------|
| Production Ready | ❌ Tidak | APP_DEBUG=true, secrets exposed |
| Docker Ready | ❌ Tidak | No Dockerfile |
| CI/CD Ready | ❌ Tidak | No pipeline |
| Environment Variable | ⚠️ Ada | Tapi secrets hardcoded |
| Logging | ⚠️ Minimal | Single channel |
| Monitoring | ❌ Tidak Ada | — |
| Health Check | ❌ Tidak Ada | No `/health` endpoint |
| Backup | ❌ Tidak Ada | — |
| Zero Downtime | ❌ Tidak Ada | — |
| Rollback | ❌ Tidak Ada | No versioning strategy |

---

# 16. Scalability Simulation

| Users | Status | Bottleneck yang Muncul |
|------:|--------|----------------------|
| 100 | ✅ Stabil | Tidak ada masalah signifikan |
| 500 | ✅ Stabil | Global queries mulai terasa (2,000 extra queries) |
| 1,000 | ⚠️ Mulai lambat | Session storage membesar, 4,000 extra queries per batch, sync email blocking |
| 5,000 | 🔴 Bermasalah | Database sessions tabel membengkak, email queue backup, memory usage tinggi di admin pages tanpa pagination |
| 10,000 | 🔴 Degradasi | Admin catalog page loading semua buku ke memory, synchronous email timeout, race condition pada stok mulai frequent |
| 50,000 | 🔴 Kritis | Database connection pool exhausted, session table > 1GB, admin pages timeout (loading 50K+ records) |
| 100,000 | ❌ Gagal | MySQL single instance tidak mampu handle concurrent writes, session store corrupt, memory OOM pada report generation |
| 500,000 | ❌ Gagal Total | Semua subsystem collapse tanpa caching, queue, atau horizontal scaling |
| 1,000,000 | ❌ Tidak Mungkin | Arsitektur saat ini tidak dirancang untuk skala ini |

### Bottleneck Utama (Urutan Severitas):
1. **Database sessions** — Grows linearly, no cleanup strategy
2. **Global view queries** — 4 queries × every request
3. **No pagination on admin** — `->get()` on growing tables
4. **Synchronous email** — Blocking main thread
5. **Session cart** — Lost on session expire, not horizontally scalable
6. **No caching** — Every data fetched from DB fresh
7. **No connection pooling** — Default MySQL config

---

# 17. Security Penetration Simulation

| Attack Vector | Vulnerable? | Evidence |
|--------------|-------------|----------|
| **SQL Injection** | ⚠️ Low Risk | Laravel Eloquent parameterizes queries. Tapi `orderByRaw` di [KatalogController L15](file:///d:/WILMARBOOKS/app/Http/Controllers/KatalogController.php#L15) dan [SearchController L27](file:///d:/WILMARBOOKS/app/Http/Controllers/SearchController.php#L27) menggunakan raw SQL dengan parameterized binding — **aman**. |
| **XSS** | ⚠️ Medium Risk | Blade `{{ }}` auto-escapes. TAPI `isi_pesan` di PesanMasuk menyimpan HTML (`<b>`, `<br>`, `<a>`) dan di-render tanpa sanitasi. Lihat [AdminController L308](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L308) — HTML langsung di-store. View kemungkinan menggunakan `{!! !!}` untuk render. |
| **CSRF** | ✅ Protected | Laravel CSRF middleware aktif secara default |
| **Broken Auth** | ⚠️ Partial | OTP tanpa hashing, trusted device cookie forgeable |
| **Broken Access Control** | 🔴 Ya | IDOR pada tracking — user bisa melihat transaksi user lain |
| **File Upload Attack** | ⚠️ Medium | Validasi mime type ada, tapi no size limit, no content inspection |
| **JWT Attack** | N/A | Tidak menggunakan JWT |
| **API Abuse** | ⚠️ Ya | Search endpoint tanpa rate limit, bisa di-spam |
| **Rate Limit Bypass** | 🔴 Ya | Hanya OTP verify yang di-throttle. Login, register, search, semua endpoint lain tanpa rate limit |
| **Privilege Escalation** | ⚠️ Low | Role check di middleware, tapi admin route POST-based actions tidak re-verify admin |
| **IDOR** | 🔴 Ya | Track endpoint, plus `findOrFail($kode_tracking)` tanpa user scope |
| **Command Injection** | ✅ Aman | Tidak ada shell execution |
| **Business Logic Abuse** | 🔴 Ya | User bisa checkout lebih dari stok (race condition), dan tidak ada price validation server-side (harga diambil dari cart session) |

### 🔴 HIGH: Stored XSS via PesanMasuk
- **Lokasi:** [AdminController.php L308](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php#L308)
```php
$pesanContent = "...<b>Donasi anda dikonfirmasi</b>...<a href='/track?kode=...' class='...'>";
PesanMasuk::create([
    'isi_pesan' => $pesanContent,
]);
```
- **Dampak:** Jika admin message di-render dengan `{!! !!}`, arbitrary HTML bisa di-inject. Meskipun admin-controlled, jika ada fitur user-generated messages di masa depan, ini menjadi XSS vector.
- **Solusi:** Gunakan Markdown atau sanitize HTML dengan HTMLPurifier

### 🔴 HIGH: Business Logic Abuse — Price Tampering
- **Lokasi:** [CheckoutController.php L60-63](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php#L60-L63)
```php
$total = 0;
foreach ($cart as $details) {
    $total += $details['harga_estimasi'] * $details['qty'];
}
```
- **Dampak:** `harga_estimasi` diambil dari session cart (yang diset saat add to cart). Jika attacker memanipulasi session atau harga berubah antara add-to-cart dan checkout, harga yang dipakai **bisa berbeda dari harga aktual**.
- **Solusi:** Re-fetch harga dari database saat checkout:
```php
$buku = KatalogBuku::find($id);
$total += $buku->harga_estimasi * $details['qty'];
```
- **Estimasi Effort:** 0.5 jam

---

# 18. Production Readiness Score

| Category | Score | Justifikasi |
|----------|------:|-------------|
| Architecture | 35/100 | God controller, no service layer, no DI |
| Scalability | 20/100 | Session cart, sync email, no cache, no queue |
| Performance | 30/100 | CDN dependencies, global queries, no pagination admin |
| Security | 35/100 | Credentials exposed, IDOR, no CSP, debug=true |
| Database | 40/100 | 1NF violation, enum mismatch, no soft delete |
| Backend | 40/100 | No transaction, no service layer, race conditions |
| Frontend | 45/100 | CDN dependencies, inline JS, no SEO |
| UX | 55/100 | Decent flow, loading states, mobile responsive |
| Maintainability | 30/100 | God controller, magic strings, no tests |
| DevOps | 5/100 | Zero infrastructure |
| Testing | 5/100 | Zero meaningful tests |
| Documentation | 25/100 | README exists, inline comments minimal |
| Developer Experience | 35/100 | Composer dev script, Vite, but no tooling |
| API Design | 15/100 | No API layer, inconsistent JSON responses |
| Business Logic | 35/100 | Logic scattered, race conditions, no validation |

---

# 19. Risk Assessment

## Risk Matrix

### 🔴 CRITICAL (Immediate Action Required)

| # | Issue | Dampak | Solusi |
|---|-------|--------|-------|
| C1 | Credentials exposed di .env (Google OAuth) | Account compromise, OAuth hijacking | Rotate credentials segera, use secret manager |
| C2 | APP_DEBUG=true untuk production | Full stack trace, env vars, DB credentials exposed | Set APP_DEBUG=false |
| C3 | Stack trace di JSON error response | Server internals exposed | Remove trace from responses |
| C4 | No database transaction di checkout | Data corruption, stok inconsistency | Wrap in DB::transaction() |
| C5 | Race condition pada stok buku | Overselling, negative stock | Use lockForUpdate() |
| C6 | Zero test coverage | No safety net, any change can break production | Write critical path tests |

### 🟡 HIGH (Fix Within 1 Week)

| # | Issue | Dampak | Solusi |
|---|-------|--------|-------|
| H1 | IDOR pada tracking endpoint | User privacy breach | Add user_id check |
| H2 | OTP stored plain text | OTP leakage via DB access | Hash OTP before storing |
| H3 | Synchronous email sending | Request blocking, user experience degradation | Use queue |
| H4 | Session-based cart | Not horizontally scalable, data loss | Migrate to database |
| H5 | No pagination on admin pages | OOM, timeout on large datasets | Implement pagination |
| H6 | TailwindCSS via CDN | Performance, SPOF, CSP violation | Use Vite build |
| H7 | God Controller (AdminController) | Maintainability nightmare | Split into multiple controllers |
| H8 | Kategori as comma-separated string | 1NF violation, query issues | Create pivot table |
| H9 | No Content Security Policy | XSS vulnerability | Add CSP header |
| H10 | Trusted device cookie forgeable | OTP bypass | Use encrypted signed tokens |
| H11 | File upload no size limit | Disk exhaustion, DoS | Add max:2048 validation |
| H12 | Status enum mismatch | Data integrity issues | Fix migration |
| H13 | Global view queries (4 per request) | Performance degradation at scale | Cache + targeted composers |
| H14 | Business logic price from session | Price tampering | Re-fetch from DB at checkout |

### 🟠 MEDIUM (Fix Within 1 Month)

| # | Issue | Dampak | Solusi |
|---|-------|--------|-------|
| M1 | No service layer | Poor testability, code duplication | Create service classes |
| M2 | Duplicate image processing code | Maintenance burden | Extract to service/trait |
| M3 | Magic strings everywhere | Typo-prone, hard to refactor | Use PHP Enums |
| M4 | No soft delete | Data loss, no audit trail | Add SoftDeletes trait |
| M5 | SSL verification disabled in dev | MITM risk | Use proper CA bundle |
| M6 | No rate limiting on most endpoints | DoS vulnerability | Add throttle middleware |
| M7 | Inline JavaScript in Blade | Not cacheable, CSP violation | Extract to JS files |
| M8 | No composite database indexes | Slow queries at scale | Add indexes |
| M9 | Dead code files | Confusion, maintenance burden | Clean up |

### 🔵 LOW (Fix Within 3 Months)

| # | Issue | Dampak | Solusi |
|---|-------|--------|-------|
| L1 | No API layer | Can't support mobile/third-party | Build API with resources |
| L2 | No Docker setup | Inconsistent environments | Create Dockerfile |
| L3 | No CI/CD pipeline | Manual deployments, error-prone | Set up GitHub Actions |
| L4 | No monitoring/alerting | Blind to issues | Set up Sentry + basic metrics |
| L5 | Mixed language naming | Confusion for international devs | Standardize to English |
| L6 | No SEO optimization | Poor search visibility | Add meta tags, OG tags |
| L7 | No dark mode implementation | UX gap (config exists but unused) | Implement dark mode |
| L8 | No backup strategy | Data loss risk | Automated DB backups |
| L9 | PWA service worker empty | No offline capability | Implement caching strategy |

### ℹ️ INFORMATIONAL

| # | Issue | Detail |
|---|-------|--------|
| I1 | Referer-based layout detection | Unreliable, should use auth check |
| I2 | Port 8000 hardcoded in referer check | Will break in production |
| I3 | Email config pointing to localhost:1025 | Need production SMTP config |
| I4 | APP_NAME still "Laravel" | Should be "WilmarBOOKS" |

**Total Issues: 6 Critical, 14 High, 9 Medium, 9 Low, 4 Informational = 42 Total**

---

# 20. Prioritized Improvement Roadmap

## 🚨 Immediate Fix (1-3 Hari)

| Priority | Task | Effort | Impact |
|----------|------|--------|--------|
| P0 | Rotate Google OAuth credentials | 1 jam | Prevents credential abuse |
| P0 | Set APP_DEBUG=false for production | 1 menit | Prevents info disclosure |
| P0 | Remove stack trace from error responses | 30 menit | Prevents info disclosure |
| P0 | Add DB::transaction() to checkout | 4 jam | Prevents data corruption |
| P0 | Add lockForUpdate() for stock | 2 jam | Prevents race conditions |
| P0 | Fix IDOR on tracking endpoint | 15 menit | Prevents data leakage |
| P0 | Add file upload size limit | 10 menit | Prevents DoS |
| P0 | Fix APP_NAME in .env | 1 menit | Branding |

## 📅 Short Term (1 Minggu)

| Priority | Task | Effort | Impact |
|----------|------|--------|--------|
| P1 | Hash OTP codes in database | 1 hari | Security improvement |
| P1 | Queue email sending | 4 jam | Performance boost |
| P1 | Add pagination to all admin pages | 1 hari | Prevents OOM |
| P1 | Replace TailwindCSS CDN with Vite build | 4 jam | Performance + reliability |
| P1 | Add Content Security Policy header | 4 jam | XSS prevention |
| P1 | Cache global view queries | 2 jam | Performance boost |
| P1 | Fix status_tracking enum mismatch | 2 jam | Data integrity |
| P1 | Re-fetch prices from DB at checkout | 30 menit | Prevents price tampering |

## 📆 Medium Term (1 Bulan)

| Priority | Task | Effort | Impact |
|----------|------|--------|--------|
| P2 | Split AdminController into 6 controllers | 3 hari | Maintainability |
| P2 | Create Service Layer | 5 hari | Architecture improvement |
| P2 | Migrate session cart to database | 2 hari | Scalability |
| P2 | Create PHP Enums for status values | 1 hari | Code quality |
| P2 | Normalize kategori (pivot table) | 3 hari | Data integrity |
| P2 | Add SoftDeletes to all models | 1 hari | Data safety |
| P2 | Write critical path tests | 5 hari | Quality assurance |
| P2 | Extract image processing to service | 4 jam | DRY principle |
| P2 | Add rate limiting globally | 4 jam | Security |
| P2 | Add composite database indexes | 2 jam | Performance |
| P2 | Extract inline JS to separate files | 3 hari | Maintainability |
| P2 | Implement encrypted trusted device tokens | 1 hari | Security |

## 📅 Long Term (3-6 Bulan)

| Priority | Task | Effort | Impact |
|----------|------|--------|--------|
| P3 | Build REST API layer | 1 minggu | Mobile/integration ready |
| P3 | Implement Redis caching | 3 hari | Performance + scalability |
| P3 | Docker + docker-compose setup | 2 hari | Deployment consistency |
| P3 | CI/CD pipeline (GitHub Actions) | 2 hari | Automation |
| P3 | Implement monitoring (Sentry + metrics) | 2 hari | Observability |
| P3 | Add SEO optimization | 2 hari | Discoverability |
| P3 | Implement backup strategy | 1 hari | Data safety |
| P3 | Full test suite (80% coverage target) | 2 minggu | Quality assurance |

## 🔮 Future Enhancement

| Task | Effort | Impact |
|------|--------|--------|
| Payment gateway integration (Midtrans) | 2 minggu | Automated payments |
| Real-time notifications (WebSocket/Pusher) | 1 minggu | Better UX |
| Full-text search (Meilisearch/Algolia) | 1 minggu | Better search experience |
| Admin dashboard analytics | 1 minggu | Better insights |
| Mobile app (API-first) | 1-2 bulan | Mobile access |
| Kubernetes deployment | 2 minggu | Enterprise scaling |
| Dark mode | 3 hari | UX improvement |
| PWA offline support | 1 minggu | Offline access |
| Multi-language support | 1 minggu | Internationalization |

---

# 21. Overall Report — Executive Summary

## Penilaian Keseluruhan

WilmarBOOKS adalah aplikasi donasi buku yang **fungsional untuk skala kecil** (< 500 users) dengan flow bisnis yang jelas dan UI yang cukup baik. Namun, dari perspektif enterprise readiness, aplikasi ini memiliki **kelemahan fundamental** di area security, scalability, testing, dan DevOps.

### Kelebihan Utama
1. **Flow bisnis terdefinisi dengan baik** — Dari browse → cart → checkout → payment → tracking
2. **Authentication lengkap** — Email/password + OTP + Google OAuth
3. **Image optimization** — WebP compression sudah implementasi
4. **Admin panel komprehensif** — Dashboard, catalog, transactions, users, reports, PDF export
5. **Notification system** — In-app messages + email notifications
6. **Error pages** — Custom 403, 404, 419, 500

### Kekurangan Utama
1. **Keamanan belum siap production** — Credentials exposed, debug mode on, IDOR, no CSP
2. **Arsitektur tidak scalable** — God controller, no service layer, session-based state
3. **Zero meaningful tests** — Tidak ada safety net
4. **Zero DevOps infrastructure** — No Docker, CI/CD, monitoring
5. **Data integrity berisiko** — No transactions, race conditions, enum mismatch

### Estimasi Biaya Perbaikan ke Production-Ready
- **Phase 1 (Critical + High):** 2-3 minggu, 1 developer senior
- **Phase 2 (Architecture refactor):** 3-4 minggu, 1-2 developer
- **Phase 3 (DevOps + Testing):** 2-3 minggu, 1 DevOps + 1 developer
- **Total:** ~2-3 bulan untuk production-ready

### Estimasi Kompleksitas Pengembangan Ke Depan
- **Minor features (< 1 minggu):** Mudah ditambahkan
- **Major features (> 1 minggu):** Akan sulit tanpa refactoring arsitektur
- **Scalability features:** Memerlukan significant rewrite

---

# 22. Final Scores

| Category | Score | Grade |
|----------|------:|-------|
| Architecture | **35**/100 | 🔴 F |
| Scalability | **20**/100 | 🔴 F |
| Performance | **30**/100 | 🔴 F |
| Backend | **40**/100 | 🟡 D |
| Frontend | **45**/100 | 🟡 D |
| Database | **40**/100 | 🟡 D |
| API | **15**/100 | 🔴 F |
| Security | **35**/100 | 🔴 F |
| DevOps | **5**/100 | 🔴 F |
| Testing | **5**/100 | 🔴 F |
| Maintainability | **30**/100 | 🔴 F |
| UX | **55**/100 | 🟡 D+ |
| Business Logic | **35**/100 | 🔴 F |
| Production Ready | **25**/100 | 🔴 F |
| **OVERALL** | **30**/100 | 🔴 **F** |

---

# 23. Final Verdict

## ⚠️ MVP Only

Aplikasi WilmarBOOKS **LAYAK untuk demonstrasi dan penggunaan internal terbatas** (< 100 users, non-critical data), namun **TIDAK SIAP untuk production** dalam kondisi saat ini.

### Prasyarat Minimum untuk Naik ke 🟡 Beta Ready:
- [ ] Fix semua 6 Critical issues
- [ ] Fix minimal 10 dari 14 High issues
- [ ] Achieve 30% test coverage pada critical paths
- [ ] Setup basic CI/CD pipeline
- [ ] Setup basic monitoring (Sentry)

### Prasyarat untuk 🟢 Production Ready:
- [ ] Semua prasyarat Beta Ready
- [ ] Service layer implemented
- [ ] 60% test coverage
- [ ] Docker deployment
- [ ] Monitoring + alerting aktif
- [ ] Database normalization complete
- [ ] Rate limiting on all endpoints
- [ ] Full security headers

---

# 24. Lampiran — Temuan Detail

## A. File Reference

| File | Lines | Role | Issues |
|------|------:|------|--------|
| [AdminController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/AdminController.php) | 652 | God Controller | SRP violation, duplicate code, no transaction |
| [AuthController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/AuthController.php) | 391 | Authentication | OTP plain text, SSL bypass, trusted device vuln |
| [CheckoutController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php) | 196 | Checkout flow | No transaction, race condition, price tampering |
| [CartController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/CartController.php) | 122 | Cart management | Session-based, not scalable |
| [KatalogController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/KatalogController.php) | 127 | Book catalog | LIKE queries, dummy logic |
| [TransaksiController.php](file:///d:/WILMARBOOKS/app/Http/Controllers/TransaksiController.php) | 56 | Transaction list | IDOR vulnerability |
| [AppServiceProvider.php](file:///d:/WILMARBOOKS/app/Providers/AppServiceProvider.php) | 38 | Service provider | Global query pollution |
| [PesanMasuk.php](file:///d:/WILMARBOOKS/app/Models/PesanMasuk.php) | 37 | Notification model | Sync email in model event |
| [.env](file:///d:/WILMARBOOKS/.env) | 70 | Environment | Credentials exposed |
| [SecurityHeaders.php](file:///d:/WILMARBOOKS/app/Http/Middleware/SecurityHeaders.php) | 28 | Security middleware | Missing CSP |
| [user.blade.php](file:///d:/WILMARBOOKS/resources/views/layouts/user.blade.php) | 537 | User layout | CDN dependencies, inline JS |

## B. Technology Stack Summary

| Layer | Technology | Version | Notes |
|-------|-----------|---------|-------|
| Backend | Laravel | 13.8 | Latest major version |
| PHP | PHP | 8.3+ | Modern |
| Database | MySQL | — | Via XAMPP/local |
| Frontend | TailwindCSS | 3.x/4.x (mixed) | CDN in templates, npm in package.json |
| JS Framework | AlpineJS | 3.x | Via npm (not used in templates?) |
| Build Tool | Vite | 8.0 | Configured but underutilized |
| PDF | DomPDF | 3.1 | For report export |
| Image | Intervention/Image | 4.1 | WebP compression |
| Auth | Laravel Socialite | 5.28 | Google OAuth |
| Email | SMTP | — | Configured for localhost:1025 (dev) |

## C. Database Schema Summary

```
users
├── id (PK, auto)
├── nama_lengkap
├── email (UNIQUE)
├── password (nullable)
├── google_id (nullable)
├── identitas_kampus (nullable)
├── role (enum: admin, user_internal, user_external)
├── otp_code (nullable, PLAIN TEXT ⚠️)
├── otp_expires_at (nullable)
└── timestamps

katalog_buku
├── id (PK, auto)
├── judul_buku (INDEXED)
├── pengarang (INDEXED)
├── penerbit (nullable)
├── kategori (nullable, COMMA-SEPARATED ⚠️)
├── deskripsi (text, nullable)
├── jumlah_halaman (string, nullable)
├── badge (nullable)
├── stok_dibutuhkan (default: 1)
├── cover_image (nullable)
├── harga_estimasi (decimal 15,2)
├── status_buku (enum: Dibutuhkan, Tersedia)
└── timestamps

transaksi_checkout
├── kode_tracking (PK, string)
├── user_id (FK → users, CASCADE)
├── total_harga (decimal 15,2)
├── midtrans_id (nullable, UNUSED)
├── status_pembayaran (enum, MISMATCH ⚠️)
├── bukti_pembayaran (nullable)
├── status_tracking (enum, MISMATCH ⚠️)
├── alasan_pembatalan (nullable)
├── validasi_lulus (boolean)
├── is_read_by_user (boolean)
├── tanggal_checkout (timestamp)
└── timestamps

transaksi_detail
├── id (PK, auto)
├── kode_tracking (FK → transaksi_checkout, CASCADE)
├── buku_id (FK → katalog_buku, CASCADE)
├── qty (default: 1)
├── harga_satuan (decimal 15,2)
├── pesan_dukungan (text, nullable)
└── timestamps

pesan_masuk
├── id (PK, auto)
├── user_id (FK → users, CASCADE)
├── judul
├── isi_pesan (text)
├── jenis (default: 'sistem')
├── is_read (boolean, default: false)
└── timestamps

kategoris
├── id (PK, auto)
├── nama_kategori (INDEXED)
└── timestamps

penerbits
├── id (PK, auto)
├── nama_penerbit (INDEXED)
├── icon
└── timestamps

metode_pembayarans
├── id (PK, auto)
├── tipe (default: 'Bank Transfer')
├── nama_bank
├── nomor_rekening
├── atas_nama
├── is_active (boolean, default: true)
└── timestamps
```

---

> **Dokumen ini disiapkan untuk keperluan Technical Due Diligence dan hanya boleh dibagikan kepada pihak yang berwenang. Semua temuan berdasarkan analisis source code aktual pada tanggal audit.**

---

*End of Report*
