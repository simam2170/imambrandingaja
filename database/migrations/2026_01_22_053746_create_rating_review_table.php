<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rating_review', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('mitra_id')
                  ->constrained('mitra')
                  ->cascadeOnDelete();

            $table->foreignId('layanan_id')
                  ->constrained('layanan_branding')
                  ->cascadeOnDelete();

            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->cascadeOnDelete();

            $table->tinyInteger('rating')->comment('1 sampai 5');

            $table->text('review')->nullable();

            $table->timestamps();

            // 1 pesanan hanya boleh 1 review
            $table->unique('pesanan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rating_review');
    }
};

