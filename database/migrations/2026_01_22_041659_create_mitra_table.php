<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();

            $table->string('nama_mitra');
            $table->string('email')->unique();
            $table->string('password');

            $table->text('deskripsi')->nullable();

            // alamat
            $table->string('kota');
            $table->string('provinsi');

            // status & verifikasi
            $table->enum('status', ['aktif','nonaktif'])->default('aktif');
            $table->enum('status_verifikasi', ['terverifikasi', 'dalam_proses', 'belum_verifikasi'])->default('belum_verifikasi');

            // metode pembayaran mitra (diterima dari admin)
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_pemilik_rekening')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jaringan');
    }
};
