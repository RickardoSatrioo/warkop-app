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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();  // ID untuk transaksi
            $table->unsignedBigInteger('order_id');  // ID pesanan (tanpa relasi foreign key)
            $table->decimal('total_amount', 10, 2);  // Total jumlah transaksi
            $table->enum('payment_method', ['cash', 'credit', 'qr']);  // Metode pembayaran
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');  // Menghapus tabel transactions
    }
};
