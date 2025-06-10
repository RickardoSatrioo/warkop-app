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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // ID untuk pesanan
            $table->unsignedBigInteger('user_id');  // ID pengguna (tanpa relasi foreign key)
            $table->unsignedBigInteger('product_id');  // ID produk (tanpa relasi foreign key)
            $table->integer('quantity');  // Jumlah produk yang dipesan
            $table->decimal('price', 8, 2);  // Harga total
            $table->string('status')->default('konfirmasi');
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');  // Menghapus tabel orders
    }
};
