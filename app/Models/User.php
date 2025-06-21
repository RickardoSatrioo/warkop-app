<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- TAMBAHKAN IMPORT INI
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'birthDate',
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

    /**
     * === TAMBAHKAN FUNGSI DI BAWAH INI ===
     * Mendefinisikan relasi one-to-many dari User ke Order.
     * Seorang User bisa memiliki banyak Order.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    // =======================================
}