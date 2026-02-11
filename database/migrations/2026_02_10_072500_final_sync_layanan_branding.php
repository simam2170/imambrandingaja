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
            if (!Schema::hasColumn('layanan_branding', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_layanan');
            }
            if (!Schema::hasColumn('layanan_branding', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('layanan_branding', 'harga_json')) {
                $table->json('harga_json')->nullable()->after('harga');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan_branding', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'thumbnail', 'harga_json']);
        });
    }
};
