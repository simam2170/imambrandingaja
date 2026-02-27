<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('layanan_id');
            $table->string('file_portofolio');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('mitra_id')->references('id')->on('mitra')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('layanan_id')->references('id')->on('layanan_branding')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
