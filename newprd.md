Product Requirements Document (PRD)

Wilmar Literacy Hub - Book Checkout & Tracking System

Version: 1.0 (Pembaruan Role Management & Syarat Kelulusan)

Project Type: Web Application

Document Status: Draft for Development

1. Executive Summary

Platform ini berfungsi sebagai sistem e-commerce donasi literasi. Perpustakaan menampilkan daftar kebutuhan buku (Wishlist Katalog). Sistem ini melayani dua jenis donatur: masyarakat umum (publik) dan civitas akademika (mahasiswa/internal kampus) yang diwajibkan berdonasi sebagai salah satu syarat kelulusan.

Pengguna dapat login (via Google/Email), memilih buku, dan melakukan transfer pembayaran ke rekening Admin. Setelah itu, pengguna wajib mengunggah bukti transfer yang akan divalidasi oleh Admin. Setelah disetujui, Sistem akan menerbitkan Kode Tracking untuk memantau proses hingga buku masuk ke rak perpustakaan, sekaligus menjadi bukti validasi kelulusan bagi pengguna internal.

2. Alur Utama Sistem (Workflow)

Otentikasi & Pemisahan Role: Pengguna mendaftar dan memilih apakah mereka pengguna Eksternal (Publik) atau Internal (Mahasiswa/Dosen). Pengguna internal wajib melengkapi Nomor Induk Mahasiswa (NIM) untuk pendataan.

Pemilihan Buku: Pengguna melihat daftar buku yang dibutuhkan perpustakaan di halaman Katalog Publik dan menekan tombol Checkout.

Pembayaran & Upload Bukti: Pengguna melakukan pembayaran manual melalui transfer bank ke rekening Admin, lalu mengunggah screenshot bukti transfer yang valid di sistem.

Validasi Admin & Tracking: Admin akan menerima dan memeriksa bukti transfer tersebut. Jika dana tervalidasi dan disetujui, barulah sistem menerbitkan Kode Tracking (contoh: WLH-202310-001) dan donasi resmi diterima. Mulai tahap ini, pengguna dapat melacak pesanan dari akunnya. Khusus pengguna internal, transaksi yang berhasil ini akan tercatat sebagai pemenuhan syarat kelulusan.

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

Ringkasan pesanan, instruksi rekening tujuan, dan form upload bukti transfer/pembayaran (screenshot).

Halaman Pelacakan & Dashboard User:

Kolom pelacakan menggunakan Kode Tracking.

Riwayat donasi buku.

Sertifikat digital yang berfungsi sebagai Surat Keterangan Bebas Pustaka / Syarat Kelulusan (khusus user_internal) yang bisa diunduh setelah buku berstatus "Tersedia".

👑 Sisi Manajemen (Backend / Dashboard)

Sistem memiliki otorisasi bertingkat untuk mengelola operasional:

Super Admin (Developer/IT):

Akses penuh ke seluruh konfigurasi sistem, API Keys (Google OAuth), dan manajemen akun semua level.

Admin (Petugas Perpustakaan):

Manajemen Katalog Buku (menambah wishlist, mengupdate status ketersediaan di rak).

Manajemen Checkout (memvalidasi bukti transfer yang diunggah, melihat daftar pesanan, memproses pembelian, mengubah status tracking).

Rekapitulasi laporan donasi mahasiswa untuk validasi ke bagian akademik.

4. Rancangan Database (Tabel Utama)

1. Tabel users

| Column Name      | Data Type     | Keterangan                                                        |
| ---------------- | ------------- | ----------------------------------------------------------------- |
| id               | PK (UUID/Int) | Primary Key                                                       |
| nama_lengkap     | Varchar       | Nama donatur                                                      |
| email            | Varchar       | Email untuk notifikasi & login                                    |
| password         | Varchar       | Hash password (kosong jika login via Google)                      |
| google_id        | Varchar       | Nullable, ID unik dari Google OAuth                               |
| identitas_kampus | Varchar       | Nullable, berisi NIM/NIDN (Wajib diisi jika role = user_internal) |
| role             | Enum          | 'super_admin', 'admin', 'user_internal', 'user_external'          |

2. Tabel transaksi_checkout (Sistem Tracking & Payment)

| Column Name       | Data Type    | Keterangan                                                                                    |
| ----------------- | ------------ | --------------------------------------------------------------------------------------------- |
| kode_tracking     | PK (Varchar) | Primary Key (Contoh: WLH-XXXX)                                                                |
| user_id           | FK (Int)     | Relasi ke tabel users                                                                         |
| buku_id           | FK (Int)     | Buku apa yang dibelikan                                                                       |
| bukti_pembayaran  | Varchar      | Path/URL file screenshot bukti transfer                                                       |
| status_pembayaran | Enum         | 'Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Paid', 'Failed'                                |
| status_tracking   | Enum         | 'Menunggu Pembayaran', 'Dana Diterima', 'Dipesan Admin', 'Dikirim ke Perpus', 'Masuk Katalog' |
| validasi_lulus    | Boolean      | true jika status_tracking mencapai 'Masuk Katalog'                                            |
| tanggal_checkout  | Timestamp    | Waktu user melakukan checkout                                                                 |

3. Tabel katalog_buku (Wishlist & Inventaris)

| Column Name    | Data Type     | Keterangan                                                 |
| -------------- | ------------- | ---------------------------------------------------------- |
| id             | PK (UUID/Int) | Primary Key                                                |
| judul_buku     | Varchar       | Judul buku                                                 |
| pengarang      | Varchar       | Nama penulis                                               |
| harga_estimasi | Decimal/Int   | Harga buku untuk acuan checkout                            |
| status_buku    | Enum          | 'Dibutuhkan' (Bisa di-checkout), 'Tersedia' (Sudah di rak) |
| donatur_id     | FK (Varchar)  | Relasi ke kode_tracking penyumbang                         |

5. Non-Functional Requirements

Manual Payment Validation: Pembayaran dilakukan secara manual via transfer bank. User harus mengunggah bukti bayar yang kemudian akan dicek/divalidasi oleh admin di dashboard.

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
