<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_code', 'user_id', 'payment_id', 'status',
        'total_price', 'payment_proof', 'expired_at' 
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_code', 'order_code');
    }
}
