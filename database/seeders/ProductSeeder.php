<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PhoneModel;
use App\Models\Condition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $phoneModels = PhoneModel::all();
        $conditions = Condition::all();

        $storageOptions = ['64GB', '128GB', '256GB', '512GB'];
        $colorOptions = ['Black', 'White', 'Blue', 'Gold', 'Silver'];

        foreach ($phoneModels->take(4) as $index => $phoneModel) {
            // Get images for this model
            $images = $this->getPhoneImages($phoneModel->name);

            // Create 2 products per phone model
            for ($i = 1; $i <= 2; $i++) {
                $product = Product::create([
                    'phone_model_id' => $phoneModel->id,
                    'title' => $phoneModel->name . ' (Refurbished)',
                    'slug' => Str::slug($phoneModel->name . ' ' . $i . ' ' . Str::random(5)),
                    'description' => 'Certified refurbished ' . $phoneModel->name . '. Fully tested and comes with warranty.',
                    'base_price' => rand(15000, 60000),
                    'imei' => '35' . rand(1000000000000, 9999999999999),
                    'warranty_months' => 6,
                    'whats_in_box' => 'Phone, Charger, USB Cable, SIM Ejector Tool, Documentation',
                    'is_featured' => $i == 1,
                    'is_active' => true,
                    'published_at' => now(),
                    'primary_image' => $images[0],
                ]);

                // Create Gallery Images
                foreach ($images as $index => $imageUrl) {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imageUrl,
                        'sort_order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }

                // Create variants for each product
                foreach ($conditions->take(2) as $condition) {
                    foreach (array_slice($storageOptions, 0, 3) as $storage) {
                        foreach (array_slice($colorOptions, 0, 2) as $color) {
                            $basePrice = $product->base_price;
                            
                            // Adjust price based on storage
                            $storageMultiplier = match($storage) {
                                '64GB' => 1.0,
                                '128GB' => 1.15,
                                '256GB' => 1.30,
                                '512GB' => 1.50,
                                default => 1.0,
                            };
                            
                            // Adjust price based on condition
                            $conditionMultiplier = match($condition->slug) {
                                'excellent' => 1.0,
                                'good' => 0.85,
                                'fair' => 0.70,
                                default => 1.0,
                            };

                            $finalPrice = round($basePrice * $storageMultiplier * $conditionMultiplier, -2);
                            $originalPrice = round($finalPrice * 1.25, -2);

                            ProductVariant::create([
                                'product_id' => $product->id,
                                'condition_id' => $condition->id,
                                'storage' => $storage,
                                'color' => $color,
                                'price' => $finalPrice,
                                'original_price' => $originalPrice,
                                'stock' => rand(1, 10),
                                'sku' => strtoupper(Str::random(8)),
                                'is_available' => true,
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function getPhoneImages(string $modelName): array
    {
        // Unsplash Image IDs
        $iphoneImages = [
            'https://images.unsplash.com/photo-1663499482523-1c0c166eb840?q=80&w=800&auto=format&fit=crop', // iPhone 14 Pro ish
            'https://images.unsplash.com/photo-1591337676887-a217a6970a8a?q=80&w=800&auto=format&fit=crop', // iPhone back
            'https://images.unsplash.com/photo-1696446701796-da61225697cc?q=80&w=800&auto=format&fit=crop', // iPhone titanium
        ];

        $samsungImages = [
            'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?q=80&w=800&auto=format&fit=crop', // Samsung S21
            'https://images.unsplash.com/photo-1678911820864-e2c567c655d7?q=80&w=800&auto=format&fit=crop', // Samsung S23
            'https://images.unsplash.com/photo-1610945265078-d86f3d297df2?q=80&w=800&auto=format&fit=crop', // Samsung Back
        ];

        $pixelImages = [
            'https://images.unsplash.com/photo-1598327105666-5b89351aff23?q=80&w=800&auto=format&fit=crop', // Pixel
            'https://images.unsplash.com/photo-1695200679808-14421b83d1c9?q=80&w=800&auto=format&fit=crop', // Pixel 8
        ];

        $genericImages = [
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop', // Generic phone
            'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?q=80&w=800&auto=format&fit=crop', // Mobile holding
        ];

        if (stripos($modelName, 'iPhone') !== false) {
            return $iphoneImages;
        } elseif (stripos($modelName, 'Samsung') !== false || stripos($modelName, 'Galaxy') !== false) {
            return $samsungImages;
        } elseif (stripos($modelName, 'Pixel') !== false || stripos($modelName, 'Google') !== false) {
            return $pixelImages;
        }

        return $genericImages;
    }
}
