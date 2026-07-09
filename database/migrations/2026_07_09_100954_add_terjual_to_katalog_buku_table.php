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
            $table->integer('terjual')->default(0)->after('stok_dibutuhkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_buku', function (Blueprint $table) {
            $table->dropColumn('terjual');
        });
    }
};
