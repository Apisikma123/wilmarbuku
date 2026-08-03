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
        Schema::table('transaksi_checkout', function (Blueprint $table) {
            $table->string('nama_pengirim')->nullable()->after('metode_pembayaran_id');
            $table->string('bank_pengirim')->nullable()->after('nama_pengirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_checkout', function (Blueprint $table) {
            $table->dropColumn(['nama_pengirim', 'bank_pengirim']);
        });
    }
};

