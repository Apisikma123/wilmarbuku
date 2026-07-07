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
        Schema::table('katalog_buku', function (Blueprint $table) {
            $table->index('judul_buku');
            $table->index('pengarang');
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->index('nama_kategori');
        });

        Schema::table('penerbits', function (Blueprint $table) {
            $table->index('nama_penerbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_buku', function (Blueprint $table) {
            $table->dropIndex(['judul_buku']);
            $table->dropIndex(['pengarang']);
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropIndex(['nama_kategori']);
        });

        Schema::table('penerbits', function (Blueprint $table) {
            $table->dropIndex(['nama_penerbit']);
        });
    }
};
