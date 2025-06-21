<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom 'notes' setelah kolom 'snap_token'
            // Kolom ini bisa kosong (nullable) karena bersifat opsional.
            $table->text('notes')->nullable()->after('snap_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom 'notes' jika migrasi di-rollback
            $table->dropColumn('notes');
        });
    }
};