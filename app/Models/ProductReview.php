<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'comment', 'rate','product_id'
    ];
    public function Product()
    {
        return $this->belongsTo(Product::class)->onDelete('cascade');
    }
}
