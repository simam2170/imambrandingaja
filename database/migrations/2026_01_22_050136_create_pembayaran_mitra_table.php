<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran_mitra', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->onDelete('cascade');

            // nomor pesanan (human readable)
            $table->string('order_number');

            $table->foreignId('mitra_id')
                  ->constrained('mitra')
                  ->onDelete('cascade');

            $table->foreignId('admin_id')
                  ->constrained('admins')
                  ->onDelete('cascade');

            $table->decimal('jumlah', 12, 2);

            $table->string('metode_pembayaran');

            // bukti transfer admin ke jaringan
            $table->string('bukti_transfer')->nullable();

            $table->enum('status', ['pending', 'berhasil'])
                  ->default('pending');

            $table->timestamp('tanggal_transfer')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_mitra');
    }
};
