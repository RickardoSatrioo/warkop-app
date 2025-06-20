<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'status',
        // Tambahkan kolom baru
        'order_code',
        'payment_status',
        'snap_token',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the order.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
