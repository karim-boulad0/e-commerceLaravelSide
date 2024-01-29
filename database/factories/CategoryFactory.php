<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->word; // Generate a random sentence for the title
        $imageNumber = $this->faker->numberBetween(1, 12); // Assuming you have 47 images

        return [
            'title' => $title,
            'image' => "http://127.0.0.1:8000/RequiredImages/" . $imageNumber . ".jpg",
        ];
    }
}
