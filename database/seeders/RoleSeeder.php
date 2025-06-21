<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Buat roles
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        
        // === PERUBAHAN DI SINI: Buat role 'pemilik' ===
        $pemilikRole = Role::firstOrCreate(['name' => 'pemilik', 'guard_name' => 'web']);
        // =============================================

        // Buat user biasa (jika belum ada)
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'user',
                'password' => Hash::make('useruser'),
                'phone' => '081234567890',
            ]
        );
        $user->assignRole($userRole);

        // Buat user admin (jika belum ada)
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('adminadmin'),
                'phone' => '081111223344',
            ]
        );
        $admin->assignRole($adminRole);

        // === PERUBAHAN DI SINI: Buat user sander dan assign role 'pemilik' ===
        $sander = User::firstOrCreate(
            ['email' => 'sander@gmail.com'],
            [
                'name' => 'sander',
                'password' => Hash::make('sandersander'),
                'phone' => '089999888777',
            ]
        );
        // Tugaskan role 'pemilik' ke sander
        $sander->assignRole($pemilikRole);
        // ===================================================================
    }
}