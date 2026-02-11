<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify ENUM column because Doctrine DBAL doesn't support ENUM modifications well
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('menunggu_pembayaran', 'direview', 'diproses', 'selesai', 'ditolak', 'dibatalkan') DEFAULT 'menunggu_pembayaran'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original ENUM values (be careful if data exists with new values)
        // We might not want to strictly revert if data would be lost, but for correctness:
        // DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('direview', 'diproses', 'selesai', 'ditolak') DEFAULT 'direview'");
    }
};
