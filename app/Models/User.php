<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Import trait HasRoles

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Gunakan trait di sini

    /**
     * Atribut yang bisa diisi secara massal.
     * Disesuaikan dengan seeder dan database Anda.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // dari seeder
        'address', // dari kolom di tabel
        'alamat',  // dari kolom di tabel
        'nophone', // dari kolom di tabel
        'birthDate', // dari kolom di tabel
    ];

    /**
     * Atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthDate' => 'date',
        ];
    }
}
