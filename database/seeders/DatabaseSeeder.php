<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder yang akan membuat roles dan users
        $this->call([
            RoleSeeder::class,
        ]);
    }
}
