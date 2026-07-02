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
        Schema::create('transaksi_checkout', function (Blueprint $table) {
            $table->string('kode_tracking')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->string('midtrans_id')->nullable();
            $table->enum('status_pembayaran', ['Unpaid', 'Paid', 'Expired', 'Failed'])->default('Unpaid');
            $table->enum('status_tracking', ['Menunggu Pembayaran', 'Dana Diterima', 'Dipesan Admin', 'Dikirim ke Perpus', 'Masuk Katalog'])->default('Menunggu Pembayaran');
            $table->boolean('validasi_lulus')->default(false);
            $table->timestamp('tanggal_checkout')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_checkout');
    }
};
