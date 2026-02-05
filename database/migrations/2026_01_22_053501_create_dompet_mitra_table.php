<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dompet_mitra', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mitra_id')
                  ->constrained('mitra')
                  ->onDelete('cascade');

            $table->decimal('saldo', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dompet_mitra');
    }
};
