<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $brand = Brand::first() ?? Brand::create(['name' => 'Apple', 'slug' => 'apple']);
        $model = PhoneModel::first() ?? PhoneModel::create(['brand_id' => $brand->id, 'name' => 'iPhone 13', 'slug' => 'iphone-13']);
        
        $title = $this->faker->words(3, true);
        
        return [
            'phone_model_id' => $model->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'base_price' => $this->faker->randomFloat(2, 20000, 80000),
            'description' => $this->faker->paragraph(),
            'warranty_months' => 12,
            'is_active' => true,
        ];
    }
}
