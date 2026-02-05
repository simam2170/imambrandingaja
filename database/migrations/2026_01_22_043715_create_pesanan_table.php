<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            // nomor pesanan (ditampilkan ke user, admin, jaringan)
            $table->string('order_number')->unique();

            // relasi aktor
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('layanan_branding_id')
                  ->constrained('layanan_branding')
                  ->onDelete('cascade');

            // admin yang mereview (nullable karena awalnya belum direview)
            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('admins')
                  ->nullOnDelete();

            // mitra penerima pesanan
            $table->foreignId('mitra_id')
                  ->nullable()
                  ->constrained('mitra')
                  ->nullOnDelete();

            // status pesanan (FINAL)
            $table->enum('status', [
                'direview',
                'diproses',
                'selesai',
                'ditolak'
            ])->default('direview');

            // catatan dari admin / jaringan
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
