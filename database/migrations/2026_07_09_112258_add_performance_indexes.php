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
            $table->index('status_buku');
            $table->index('badge');
            $table->index('kategori');
        });

        Schema::table('transaksi_checkout', function (Blueprint $table) {
            $table->index('status_pembayaran');
            $table->index('status_tracking');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_buku', function (Blueprint $table) {
            $table->dropIndex(['status_buku']);
            $table->dropIndex(['badge']);
            $table->dropIndex(['kategori']);
        });

        Schema::table('transaksi_checkout', function (Blueprint $table) {
            $table->dropIndex(['status_pembayaran']);
            $table->dropIndex(['status_tracking']);
            $table->dropIndex(['created_at']);
        });
    }
};
