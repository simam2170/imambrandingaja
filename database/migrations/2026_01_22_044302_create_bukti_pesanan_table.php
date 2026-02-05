<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bukti_pesanan', function (Blueprint $table) {
            $table->id();

            // relasi ke pesanan
            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->onDelete('cascade');

            // file bukti hasil kerja (gambar / pdf)
            $table->string('file_bukti');

            // keterangan tambahan
            $table->text('deskripsi')->nullable();

            // waktu upload bukti
            $table->timestamp('uploaded_at')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_pesanan');
    }
};
