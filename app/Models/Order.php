<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'status',
        'order_code',
        'payment_status',
        'snap_token',
    ];

    /**
     * Relasi untuk mengambil data user yang memesan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi untuk mengambil data produk yang dipesan.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
