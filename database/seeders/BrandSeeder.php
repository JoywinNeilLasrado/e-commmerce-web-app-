<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Premium smartphones with iOS operating system',
                'is_active' => true,
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Wide range of Android smartphones',
                'is_active' => true,
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
                'description' => 'Pure Android experience with Pixel phones',
                'is_active' => true,
            ],
            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
                'description' => 'Flagship killer smartphones',
                'is_active' => true,
            ],
            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
                'description' => 'Value for money smartphones',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
