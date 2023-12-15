<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Setting extends Model
{

    use HasFactory;
    protected $fillable = ['title', 'site_name', 'icon', 'phone_number', 'email','logo'];
    public static function checkSettings()
    {
        $settings = Self::all();
        if (count($settings) < 1) {
            $data = [
                'id' => 1,
            ];
            Self::create($data);
        }
        return Self::first();
    }
}
