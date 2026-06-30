<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_code', 
        'code_product', 
        'quantity', 
        'order_price', 
        'subtotal'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'order_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_code', 'order_code');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'code_product', 'code_product');
    }
}
