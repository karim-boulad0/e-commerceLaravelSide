<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'note',
        'status',
    ];

    // Define a relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Define a relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
