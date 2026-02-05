<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dompet_admin', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admin_id')
                  ->constrained('admins')
                  ->cascadeOnDelete();

            $table->decimal('saldo', 14, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dompet_admin');
    }
};

