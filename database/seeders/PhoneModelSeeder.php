<?php

namespace Database\Seeders;

use App\Models\PhoneModel;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class PhoneModelSeeder extends Seeder
{
    public function run(): void
    {
        $apple = Brand::where('slug', 'apple')->first();
        $samsung = Brand::where('slug', 'samsung')->first();
        $google = Brand::where('slug', 'google')->first();
        $oneplus = Brand::where('slug', 'oneplus')->first();

        $phoneModels = [
            // Apple
            [
                'brand_id' => $apple->id,
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'description' => 'Pro camera system, A16 Bionic chip, Always-On display',
                'display_size' => '6.1 inches',
                'display_type' => 'Super Retina XDR OLED',
                'processor' => 'A16 Bionic',
                'ram' => '6GB',
                'camera' => '48MP + 12MP + 12MP',
                'battery' => '3200 mAh',
                'os' => 'iOS 16',
                'dimensions' => '147.5 x 71.5 x 7.9 mm',
                'weight' => '206g',
            ],
            [
                'brand_id' => $apple->id,
                'name' => 'iPhone 13',
                'slug' => 'iphone-13',
                'description' => 'Advanced dual-camera system, A15 Bionic chip',
                'display_size' => '6.1 inches',
                'display_type' => 'Super Retina XDR OLED',
                'processor' => 'A15 Bionic',
                'ram' => '4GB',
                'camera' => '12MP + 12MP',
                'battery' => '3240 mAh',
                'os' => 'iOS 15',
                'dimensions' => '146.7 x 71.5 x 7.7 mm',
                'weight' => '174g',
            ],
            // Samsung
            [
                'brand_id' => $samsung->id,
                'name' => 'Galaxy S23 Ultra',
                'slug' => 'galaxy-s23-ultra',
                'description' => '200MP camera, S Pen, Snapdragon 8 Gen 2',
                'display_size' => '6.8 inches',
                'display_type' => 'Dynamic AMOLED 2X',
                'processor' => 'Snapdragon 8 Gen 2',
                'ram' => '12GB',
                'camera' => '200MP + 12MP + 10MP + 10MP',
                'battery' => '5000 mAh',
                'os' => 'Android 13',
                'dimensions' => '163.4 x 78.1 x 8.9 mm',
                'weight' => '234g',
            ],
            [
                'brand_id' => $samsung->id,
                'name' => 'Galaxy S22',
                'slug' => 'galaxy-s22',
                'description' => 'Flagship performance, compact design',
                'display_size' => '6.1 inches',
                'display_type' => 'Dynamic AMOLED 2X',
                'processor' => 'Snapdragon 8 Gen 1',
                'ram' => '8GB',
                'camera' => '50MP + 12MP + 10MP',
                'battery' => '3700 mAh',
                'os' => 'Android 12',
                'dimensions' => '146 x 70.6 x 7.6 mm',
                'weight' => '168g',
            ],
            // Google  
            [
                'brand_id' => $google->id,
                'name' => 'Pixel 8 Pro',
                'slug' => 'pixel-8-pro',
                'description' => 'Google Tensor G3, AI-powered camera',
                'display_size' => '6.7 inches',
                'display_type' => 'LTPO OLED',
                'processor' => 'Google Tensor G3',
                'ram' => '12GB',
                'camera' => '50MP + 48MP + 48MP',
                'battery' => '5050 mAh',
                'os' => 'Android 14',
                'dimensions' => '162.6 x 76.5 x 8.8 mm',
                'weight' => '213g',
            ],
            // OnePlus
            [
                'brand_id' => $oneplus->id,
                'name' => 'OnePlus 11',
                'slug' => 'oneplus-11',
                'description' => 'Snapdragon 8 Gen 2, Hasselblad camera',
                'display_size' => '6.7 inches',
                'display_type' => 'Fluid AMOLED',
                'processor' => 'Snapdragon 8 Gen 2',
                'ram' => '16GB',
                'camera' => '50MP + 48MP + 32MP',
                'battery' => '5000 mAh',
                'os' => 'Android 13',
                'dimensions' => '163.1 x 74.1 x 8.5 mm',
                'weight' => '205g',
            ],
        ];

        foreach ($phoneModels as $model) {
            PhoneModel::create($model);
        }
    }
}
