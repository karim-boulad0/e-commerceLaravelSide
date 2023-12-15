<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
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
        User::create([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role' => '1995',
            'password' => Hash::make('admin123$%'), // password
            'remember_token' => Str::random(10),
        ]);
        Setting::create([
            'id' => 1
        ]);
    }
}
