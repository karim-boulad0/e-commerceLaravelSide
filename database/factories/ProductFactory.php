<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'category_id' => function () {
                return Category::factory()->create()->id;
            },
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discount' => $this->faker->randomFloat(2, 0, 10),
            'About' => $this->faker->text,
            'delivery_price' => $this->faker->randomFloat(2, 5, 20),
            'quantity' => 100,
            'status' => "published",
        ];
    }
}
