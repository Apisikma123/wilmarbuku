Product Requirements Document (PRD)

Wilmar Literacy Hub - Book Checkout & Tracking System



Version: 1.0 (Pembaruan Role Management & Syarat Kelulusan)

Project Type: Web Application

Document Status: Draft for Development

1. Executive Summary



Platform ini berfungsi sebagai sistem e-commerce donasi literasi. Perpustakaan menampilkan daftar kebutuhan buku (Wishlist Katalog). Sistem ini melayani dua jenis donatur: masyarakat umum (publik) dan civitas akademika (mahasiswa/internal kampus) yang diwajibkan berdonasi sebagai salah satu syarat kelulusan.



Pengguna dapat login (via Google/Email), memilih buku, dan membayar otomatis menggunakan Payment Gateway (Midtrans). Sistem akan menerbitkan Kode Tracking untuk memantau proses hingga buku masuk ke rak perpustakaan, sekaligus menjadi bukti validasi kelulusan bagi pengguna internal.



2. Alur Utama Sistem (Workflow)



Otentikasi & Pemisahan Role: Pengguna mendaftar dan memilih apakah mereka pengguna Eksternal (Publik) atau Internal (Mahasiswa/Dosen). Pengguna internal wajib melengkapi Nomor Induk Mahasiswa (NIM) untuk pendataan.

Pemilihan Buku: Pengguna melihat daftar buku yang dibutuhkan perpustakaan di halaman Katalog Publik dan menekan tombol Checkout.

Pembayaran Otomatis (Midtrans): Pengguna diarahkan ke halaman pembayaran Midtrans. Status pembayaran terverifikasi otomatis via Webhook.

Generate Kode Tracking & Validasi: Sistem menerbitkan Kode Tracking (Contoh: WLH-202310-001). Khusus pengguna internal, transaksi yang berhasil otomatis tercatat sebagai pemenuhan syarat kelulusan.

Proses Pembelian (Oleh Admin): Admin membelikan buku fisik menggunakan dana yang masuk dan mengubah status menjadi "Sedang Dipesan Admin".

Penerimaan & Katalogisasi: Saat fisik buku tiba, admin mengubah status menjadi "Diterima & Masuk Rak".

Pelacakan (Tracking) & Sertifikat: Pengguna melacak pesanan menggunakan Kode Tracking. Setelah buku masuk rak, e-sertifikat (bukti donasi/bukti kelulusan) dapat diunduh.

3. Fitur Utama Halaman Website (Scope)



👤 Sisi Pengguna (Frontend / Public Portal)



Sistem Login & Registrasi:

Form Pendaftaran dengan opsi tipe pengguna: Publik atau Internal Kampus.

Input tambahan khusus Internal Kampus (NIM/NIDN).

Tombol "Login with Google" (SSO - Single Sign-On).

Katalog Kebutuhan Buku (Wishlist):

Daftar buku yang ingin diadakan oleh perpustakaan beserta estimasi harga.

Tombol "Belikan Buku Ini" (Add to Cart / Checkout).

Halaman Checkout & Pembayaran:

Ringkasan pesanan dan integrasi Midtrans (Snap API) untuk pembayaran instan.

Halaman Pelacakan & Dashboard User:

Kolom pelacakan menggunakan Kode Tracking.

Riwayat donasi buku.

Sertifikat digital yang berfungsi sebagai Surat Keterangan Bebas Pustaka / Syarat Kelulusan (khusus user_internal) yang bisa diunduh setelah buku berstatus "Tersedia".

👑 Sisi Manajemen (Backend / Dashboard)



Sistem memiliki otorisasi bertingkat untuk mengelola operasional:



Super Admin (Developer/IT):

Akses penuh ke seluruh konfigurasi sistem, API Keys (Midtrans, Google OAuth), dan manajemen akun semua level.

Admin (Petugas Perpustakaan):

Manajemen Katalog Buku (menambah wishlist, mengupdate status ketersediaan di rak).

Manajemen Checkout (melihat daftar pesanan, memproses pembelian, mengubah status tracking).

Rekapitulasi laporan donasi mahasiswa untuk validasi ke bagian akademik.

4. Rancangan Database (Tabel Utama)



1. Tabel users



Column NameData TypeKeteranganidPK (UUID/Int)Primary Keynama_lengkapVarcharNama donaturemailVarcharEmail untuk notifikasi & loginpasswordVarcharHash password (kosong jika login via Google)google_idVarcharNullable, ID unik dari Google OAuthidentitas_kampusVarcharNullable, berisi NIM/NIDN (Wajib diisi jika role = user_internal)roleEnum'super_admin', 'admin', 'user_internal', 'user_external'

2. Tabel transaksi_checkout (Sistem Tracking & Payment)



Column NameData TypeKeterangankode_trackingPK (Varchar)Primary Key (Contoh: WLH-XXXX)user_idFK (Int)Relasi ke tabel usersbuku_idFK (Int)Buku apa yang dibelikanmidtrans_idVarcharNullable, ID Transaksi dari Midtransstatus_pembayaranEnum'Unpaid', 'Paid', 'Expired', 'Failed'status_trackingEnum'Menunggu Pembayaran', 'Dana Diterima', 'Dipesan Admin', 'Dikirim ke Perpus', 'Masuk Katalog'validasi_lulusBooleantrue jika status_tracking mencapai 'Masuk Katalog' (Khusus mempermudah filter mahasiswa lulus)tanggal_checkoutTimestampWaktu user melakukan checkout

3. Tabel katalog_buku (Wishlist & Inventaris)



Column NameData TypeKeteranganidPK (UUID/Int)Primary Keyjudul_bukuVarcharJudul bukupengarangVarcharNama penulisharga_estimasiDecimal/IntHarga buku untuk acuan checkout via Midtransstatus_bukuEnum'Dibutuhkan' (Bisa di-checkout), 'Tersedia' (Sudah di rak)donatur_idFK (Varchar)Relasi ke kode_tracking untuk menampilkan nama penyumbang di detail katalog

5. Non-Functional Requirements



Payment Gateway Integration: Sistem menggunakan Midtrans Snap API dan Webhook/Callback di backend untuk mendengarkan perubahan status pembayaran secara real-time.

Authentication: Google OAuth 2.0 untuk menangani otentikasi.

Role-Based Access Control (RBAC): Middleware yang ketat untuk memisahkan hak akses antara super_admin, admin, dan users.

Public Tracking: Endpoint /track harus bisa diakses publik dengan menggunakan Kode Tracking.

Email Gateway: SMTP untuk mengirimkan struk, Kode Tracking, dan E-Sertifikat ke email user.

6. Suggested Technology Stack



Frontend & Backend: Laravel (PHP).

Paket Laravel Socialite (Integrasi Google Login).

Paket Spatie Laravel Permission (Sangat disarankan untuk mengelola 4 roles ini).

Database: MySQL.

UI Framework: Tailwind CSS