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
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // ID untuk pengguna
            $table->string('name');  // Nama pengguna
            $table->string('email')->unique();  // Email pengguna
            $table->timestamp('email_verified_at')->nullable();  // Verifikasi email
            $table->string('password');  // Password pengguna
            $table->rememberToken();  // Token untuk "remember me"
            $table->string('alamat')->nullable();  // Menambahkan kolom alamat
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');  // Menghapus tabel users
    }
};
