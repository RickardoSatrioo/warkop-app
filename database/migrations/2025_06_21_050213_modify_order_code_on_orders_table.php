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
            // Hapus constraint unique dari kolom order_code
            $table->dropUnique('orders_order_code_unique');
            // Tambahkan index biasa untuk performa pencarian
            $table->index('order_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus index biasa
            $table->dropIndex('orders_order_code_index');
            // Kembalikan constraint unique jika migrasi di-rollback
            $table->unique('order_code');
        });
    }
};