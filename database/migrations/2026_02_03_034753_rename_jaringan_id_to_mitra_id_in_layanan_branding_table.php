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
        Schema::table('layanan_branding', function (Blueprint $table) {
            $table->renameColumn('jaringan_id', 'mitra_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan_branding', function (Blueprint $table) {
            $table->renameColumn('mitra_id', 'jaringan_id');
        });
    }
};
