<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneAndAddressToUsersTable extends Migration
{
    /**
     * Menjalankan migrasi untuk menambahkan kolom phone dan address.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();  // Kolom nomor telepon
            $table->text('address')->nullable();  // Kolom alamat
        });
    }

    /**
     * Membalikkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address']);
        });
    }
}
