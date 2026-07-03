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
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tracking');
            $table->foreign('kode_tracking')->references('kode_tracking')->on('transaksi_checkout')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('katalog_buku')->onDelete('cascade');
            $table->integer('qty')->default(1);
            $table->decimal('harga_satuan', 15, 2);
            $table->text('pesan_dukungan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
