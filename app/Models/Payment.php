<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'category', 'method_name', 'account_name', 'account_number', 'logo_path'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}