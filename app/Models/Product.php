<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','quantity', 'delivery_price','title', 'description', 'rating', 'ratings_number','status','About', 'price', 'discount'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class,'product_id');
    }

}
