<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_branding', function (Blueprint $table) {
            $table->id();

            // relasi ke mitra (pemilik layanan)
            $table->foreignId('mitra_id')
                  ->constrained('mitra')
                  ->onDelete('cascade');

            $table->string('nama_layanan');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);

            // estimasi pengerjaan (hari)
            $table->integer('estimasi_hari');

            // status layanan
            $table->enum('status', ['aktif', 'nonaktif'])
                  ->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_branding');
    }
};
