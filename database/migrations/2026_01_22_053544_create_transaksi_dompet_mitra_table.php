<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi_dompet_mitra', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dompet_mitra_id')
                  ->constrained('dompet_mitra')
                  ->onDelete('cascade');

            $table->foreignId('pesanan_id')
                  ->nullable()
                  ->constrained('pesanan')
                  ->nullOnDelete();

            $table->string('order_number')->nullable();

            $table->decimal('jumlah', 14, 2);

            $table->enum('tipe', ['masuk'])->default('masuk');

            $table->string('keterangan');

            $table->timestamp('tanggal_transaksi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_dompet_mitra');
    }
};


