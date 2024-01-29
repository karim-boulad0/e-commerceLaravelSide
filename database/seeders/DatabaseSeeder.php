<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::factory()->count(5)->create();
        User::factory()->count(30)->create();
        // Product::factory()->count(5)->create();
        ProductImage::factory()->count(150)->create();

        User::create([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role' => '1995',
            'password' => Hash::make('admin123$%'), // password
            'remember_token' => Str::random(10),
        ]);
        Setting::create([
            'id' => 1,
            'icon' => "http://127.0.0.1:8000/RequiredImages/logo.jpg",
            'logo' => "http://127.0.0.1:8000/RequiredImages/logo.jpg",
        ]);
    }
}
