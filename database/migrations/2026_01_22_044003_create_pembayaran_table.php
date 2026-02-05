<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            // relasi ke pesanan
            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->onDelete('cascade');

            // metode pembayaran (dipilih user, disediakan admin)
            $table->string('metode_pembayaran');

            // total yang dibayar
            $table->decimal('total_bayar', 12, 2);

            // bukti pembayaran (gambar)
            $table->string('bukti_pembayaran')->nullable();

            // status pembayaran
            $table->enum('status', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            // waktu pembayaran
            $table->timestamp('tanggal_bayar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

