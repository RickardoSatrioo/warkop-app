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
        Schema::create('products', function (Blueprint $table) {
            $table->id();  // ID untuk produk
            $table->string('name');  // Nama produk
            $table->text('description')->nullable();  // Deskripsi produk
            $table->decimal('price', 8, 2);  // Harga produk
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');  // Menghapus tabel products
    }
};
