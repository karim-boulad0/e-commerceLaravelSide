<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'note',
        'status',
        'payment_method',
        'delivery_time',
    ];

    // Define a relationship with OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Define a relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
