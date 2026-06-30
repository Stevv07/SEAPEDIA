<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'product_code',
        'product',
        'category',
        'merk',
        'piece',
        'price_per_piece',
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_code', 'order_code');
    }

    // SalesReport.php
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function merk()
{
    return $this->belongsTo(Merk::class, 'merk_id');
}

}

