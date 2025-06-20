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
            // Kolom 'status' yang ada kita anggap sebagai status pemrosesan (dikonfirmasi, disiapkan, dikirim)
            // Kita tambahkan kolom baru untuk status PEMBAYARAN
            $table->string('order_code')->unique()->after('id'); // Kode unik untuk setiap transaksi/invoice
            $table->string('payment_status')->default('pending')->after('status'); // Status dari Midtrans: pending, success, failed
            $table->string('snap_token')->nullable()->after('payment_status'); // Token dari Midtrans Snap
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'payment_status', 'snap_token']);
        });
    }
};
