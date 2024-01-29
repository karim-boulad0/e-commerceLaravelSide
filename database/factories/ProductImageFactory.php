<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        $imageNumber = $this->faker->numberBetween(1, 12); // Assuming you have 47 images

        return [
            'image' => "http://127.0.0.1:8000/RequiredImages/" . $imageNumber . ".jpg",
            'product_id' => function () {
                return Product::factory()->create()->id;
            },
        ];
    }
}
