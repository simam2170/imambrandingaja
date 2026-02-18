<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('layanan_branding', function (Blueprint $table) {
            $table->string('klasifikasi')->nullable()->after('kategori');
            $table->json('detail_klasifikasi')->nullable()->after('harga_json');
        });
    }

    public function down(): void
    {
        Schema::table('layanan_branding', function (Blueprint $table) {
            $table->dropColumn(['klasifikasi', 'detail_klasifikasi']);
        });
    }
};
