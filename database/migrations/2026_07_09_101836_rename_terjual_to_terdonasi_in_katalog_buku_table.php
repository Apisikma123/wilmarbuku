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
            $table->renameColumn('terjual', 'terdonasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_buku', function (Blueprint $table) {
            $table->renameColumn('terdonasi', 'terjual');
        });
    }
};
