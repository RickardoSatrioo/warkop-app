<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'total_amount',
        'payment_method',
    ];

    /**
     * Get the order that owns the transaction.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
