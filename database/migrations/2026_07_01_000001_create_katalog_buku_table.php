<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('katalog_buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul_buku');
            $table->string('pengarang');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jumlah_halaman')->nullable();
            $table->string('badge')->nullable();
            $table->integer('stok_dibutuhkan')->default(1);
            $table->string('cover_image')->nullable();
            $table->decimal('harga_estimasi', 15, 2);
            $table->enum('status_buku', ['Dibutuhkan', 'Tersedia'])->default('Dibutuhkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalog_buku');
    }
};
