<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ── Phone Models per Brand ──────────────────────────────────────
        // Each phone model has: name, specs, and a list of product variants
        $catalog = [
            // ─── APPLE ──────────────────────────────────────────────────
            'Apple' => [
                [
                    'model' => 'iPhone 15 Pro Max',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'Super Retina XDR OLED', 'processor' => 'A17 Pro', 'ram' => '8GB', 'camera' => '48MP + 12MP + 12MP', 'battery' => '4441 mAh', 'os' => 'iOS 17'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Natural Titanium', 'price' => 119900, 'original_price' => 159900, 'condition' => 1, 'stock' => 5],
                        ['storage' => '512GB', 'color' => 'Blue Titanium', 'price' => 134900, 'original_price' => 179900, 'condition' => 1, 'stock' => 3],
                        ['storage' => '256GB', 'color' => 'Black Titanium', 'price' => 99900, 'original_price' => 159900, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'iPhone 15 Pro',
                    'specs' => ['display_size' => '6.1"', 'display_type' => 'Super Retina XDR OLED', 'processor' => 'A17 Pro', 'ram' => '8GB', 'camera' => '48MP + 12MP + 12MP', 'battery' => '3274 mAh', 'os' => 'iOS 17'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Natural Titanium', 'price' => 104900, 'original_price' => 134900, 'condition' => 1, 'stock' => 6],
                        ['storage' => '256GB', 'color' => 'White Titanium', 'price' => 112900, 'original_price' => 144900, 'condition' => 2, 'stock' => 4],
                    ],
                ],
                [
                    'model' => 'iPhone 14',
                    'specs' => ['display_size' => '6.1"', 'display_type' => 'Super Retina XDR OLED', 'processor' => 'A15 Bionic', 'ram' => '6GB', 'camera' => '12MP + 12MP', 'battery' => '3279 mAh', 'os' => 'iOS 16'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Midnight', 'price' => 52900, 'original_price' => 79900, 'condition' => 1, 'stock' => 10],
                        ['storage' => '128GB', 'color' => 'Starlight', 'price' => 44900, 'original_price' => 79900, 'condition' => 2, 'stock' => 7],
                        ['storage' => '256GB', 'color' => 'Purple', 'price' => 59900, 'original_price' => 89900, 'condition' => 1, 'stock' => 4],
                    ],
                ],
                [
                    'model' => 'iPhone 13',
                    'specs' => ['display_size' => '6.1"', 'display_type' => 'Super Retina XDR OLED', 'processor' => 'A15 Bionic', 'ram' => '4GB', 'camera' => '12MP + 12MP', 'battery' => '3240 mAh', 'os' => 'iOS 15'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Midnight', 'price' => 39900, 'original_price' => 69900, 'condition' => 1, 'stock' => 12],
                        ['storage' => '128GB', 'color' => 'Blue', 'price' => 34900, 'original_price' => 69900, 'condition' => 2, 'stock' => 9],
                        ['storage' => '256GB', 'color' => 'Pink', 'price' => 42900, 'original_price' => 79900, 'condition' => 3, 'stock' => 5],
                    ],
                ],
                [
                    'model' => 'iPhone 12',
                    'specs' => ['display_size' => '6.1"', 'display_type' => 'Super Retina XDR OLED', 'processor' => 'A14 Bionic', 'ram' => '4GB', 'camera' => '12MP + 12MP', 'battery' => '2815 mAh', 'os' => 'iOS 14'],
                    'products' => [
                        ['storage' => '64GB', 'color' => 'Black', 'price' => 24900, 'original_price' => 65900, 'condition' => 2, 'stock' => 15],
                        ['storage' => '128GB', 'color' => 'White', 'price' => 29900, 'original_price' => 74900, 'condition' => 1, 'stock' => 8],
                        ['storage' => '64GB', 'color' => 'Green', 'price' => 19900, 'original_price' => 65900, 'condition' => 3, 'stock' => 6],
                    ],
                ],
            ],

            // ─── SAMSUNG ────────────────────────────────────────────────
            'Samsung' => [
                [
                    'model' => 'Galaxy S24 Ultra',
                    'specs' => ['display_size' => '6.8"', 'display_type' => 'Dynamic AMOLED 2X', 'processor' => 'Snapdragon 8 Gen 3', 'ram' => '12GB', 'camera' => '200MP + 12MP + 50MP + 10MP', 'battery' => '5000 mAh', 'os' => 'Android 14 (One UI 6.1)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Titanium Gray', 'price' => 109900, 'original_price' => 131999, 'condition' => 1, 'stock' => 5],
                        ['storage' => '512GB', 'color' => 'Titanium Violet', 'price' => 124900, 'original_price' => 144999, 'condition' => 1, 'stock' => 3],
                        ['storage' => '256GB', 'color' => 'Titanium Yellow', 'price' => 89900, 'original_price' => 131999, 'condition' => 2, 'stock' => 7],
                    ],
                ],
                [
                    'model' => 'Galaxy S24',
                    'specs' => ['display_size' => '6.2"', 'display_type' => 'Dynamic AMOLED 2X', 'processor' => 'Exynos 2400', 'ram' => '8GB', 'camera' => '50MP + 12MP + 10MP', 'battery' => '4000 mAh', 'os' => 'Android 14 (One UI 6.1)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Onyx Black', 'price' => 59900, 'original_price' => 79999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '256GB', 'color' => 'Marble Gray', 'price' => 64900, 'original_price' => 89999, 'condition' => 2, 'stock' => 6],
                    ],
                ],
                [
                    'model' => 'Galaxy S23 Ultra',
                    'specs' => ['display_size' => '6.8"', 'display_type' => 'Dynamic AMOLED 2X', 'processor' => 'Snapdragon 8 Gen 2', 'ram' => '12GB', 'camera' => '200MP + 12MP + 10MP + 10MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (One UI 5.1)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Phantom Black', 'price' => 74900, 'original_price' => 124999, 'condition' => 1, 'stock' => 8],
                        ['storage' => '256GB', 'color' => 'Cream', 'price' => 64900, 'original_price' => 124999, 'condition' => 2, 'stock' => 10],
                        ['storage' => '512GB', 'color' => 'Green', 'price' => 79900, 'original_price' => 136999, 'condition' => 3, 'stock' => 4],
                    ],
                ],
                [
                    'model' => 'Galaxy A54 5G',
                    'specs' => ['display_size' => '6.4"', 'display_type' => 'Super AMOLED', 'processor' => 'Exynos 1380', 'ram' => '8GB', 'camera' => '50MP + 12MP + 5MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (One UI 5.1)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Awesome Graphite', 'price' => 24900, 'original_price' => 38999, 'condition' => 1, 'stock' => 15],
                        ['storage' => '128GB', 'color' => 'Awesome Violet', 'price' => 19900, 'original_price' => 38999, 'condition' => 2, 'stock' => 12],
                        ['storage' => '256GB', 'color' => 'Awesome Lime', 'price' => 27900, 'original_price' => 42999, 'condition' => 1, 'stock' => 6],
                    ],
                ],
                [
                    'model' => 'Galaxy Z Flip 5',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'Dynamic AMOLED 2X', 'processor' => 'Snapdragon 8 Gen 2', 'ram' => '8GB', 'camera' => '12MP + 12MP', 'battery' => '3700 mAh', 'os' => 'Android 13 (One UI 5.1.1)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Lavender', 'price' => 69900, 'original_price' => 99999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '256GB', 'color' => 'Mint', 'price' => 59900, 'original_price' => 99999, 'condition' => 2, 'stock' => 5],
                    ],
                ],
            ],

            // ─── GOOGLE ─────────────────────────────────────────────────
            'Google' => [
                [
                    'model' => 'Pixel 9 Pro',
                    'specs' => ['display_size' => '6.3"', 'display_type' => 'LTPO OLED', 'processor' => 'Google Tensor G4', 'ram' => '16GB', 'camera' => '50MP + 48MP + 48MP', 'battery' => '4700 mAh', 'os' => 'Android 14'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Obsidian', 'price' => 89900, 'original_price' => 109900, 'condition' => 1, 'stock' => 5],
                        ['storage' => '256GB', 'color' => 'Porcelain', 'price' => 94900, 'original_price' => 119900, 'condition' => 1, 'stock' => 3],
                        ['storage' => '128GB', 'color' => 'Hazel', 'price' => 74900, 'original_price' => 109900, 'condition' => 2, 'stock' => 6],
                    ],
                ],
                [
                    'model' => 'Pixel 8 Pro',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'LTPO OLED', 'processor' => 'Google Tensor G3', 'ram' => '12GB', 'camera' => '50MP + 48MP + 48MP', 'battery' => '5050 mAh', 'os' => 'Android 14'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Obsidian', 'price' => 64900, 'original_price' => 106999, 'condition' => 1, 'stock' => 7],
                        ['storage' => '256GB', 'color' => 'Bay', 'price' => 69900, 'original_price' => 116999, 'condition' => 2, 'stock' => 5],
                    ],
                ],
                [
                    'model' => 'Pixel 8',
                    'specs' => ['display_size' => '6.2"', 'display_type' => 'OLED', 'processor' => 'Google Tensor G3', 'ram' => '8GB', 'camera' => '50MP + 12MP', 'battery' => '4575 mAh', 'os' => 'Android 14'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Obsidian', 'price' => 44900, 'original_price' => 75999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '128GB', 'color' => 'Rose', 'price' => 39900, 'original_price' => 75999, 'condition' => 2, 'stock' => 8],
                        ['storage' => '256GB', 'color' => 'Hazel', 'price' => 49900, 'original_price' => 85999, 'condition' => 1, 'stock' => 5],
                    ],
                ],
                [
                    'model' => 'Pixel 7a',
                    'specs' => ['display_size' => '6.1"', 'display_type' => 'OLED 90Hz', 'processor' => 'Google Tensor G2', 'ram' => '8GB', 'camera' => '64MP + 13MP', 'battery' => '4385 mAh', 'os' => 'Android 13'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Charcoal', 'price' => 24900, 'original_price' => 43999, 'condition' => 1, 'stock' => 12],
                        ['storage' => '128GB', 'color' => 'Sea', 'price' => 19900, 'original_price' => 43999, 'condition' => 2, 'stock' => 9],
                        ['storage' => '128GB', 'color' => 'Snow', 'price' => 16900, 'original_price' => 43999, 'condition' => 3, 'stock' => 6],
                    ],
                ],
            ],

            // ─── ONEPLUS ────────────────────────────────────────────────
            'OnePlus' => [
                [
                    'model' => 'OnePlus 12',
                    'specs' => ['display_size' => '6.82"', 'display_type' => 'LTPO AMOLED 120Hz', 'processor' => 'Snapdragon 8 Gen 3', 'ram' => '12GB', 'camera' => '50MP + 48MP + 64MP', 'battery' => '5400 mAh', 'os' => 'Android 14 (OxygenOS 14)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Flowy Emerald', 'price' => 54900, 'original_price' => 69999, 'condition' => 1, 'stock' => 7],
                        ['storage' => '512GB', 'color' => 'Silky Black', 'price' => 62900, 'original_price' => 79999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '256GB', 'color' => 'Silky Black', 'price' => 44900, 'original_price' => 69999, 'condition' => 2, 'stock' => 9],
                    ],
                ],
                [
                    'model' => 'OnePlus 11',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'Snapdragon 8 Gen 2', 'ram' => '16GB', 'camera' => '50MP + 32MP + 48MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (OxygenOS 13)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Eternal Green', 'price' => 39900, 'original_price' => 61999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '256GB', 'color' => 'Titan Black', 'price' => 34900, 'original_price' => 61999, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'OnePlus Nord CE 3',
                    'specs' => ['display_size' => '6.72"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'Snapdragon 782G', 'ram' => '8GB', 'camera' => '50MP + 8MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (OxygenOS 13.1)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Aqua Surge', 'price' => 17900, 'original_price' => 26999, 'condition' => 1, 'stock' => 15],
                        ['storage' => '256GB', 'color' => 'Gray Shimmer', 'price' => 19900, 'original_price' => 29999, 'condition' => 2, 'stock' => 10],
                    ],
                ],
                [
                    'model' => 'OnePlus Nord 3',
                    'specs' => ['display_size' => '6.74"', 'display_type' => 'Super Fluid AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 9000', 'ram' => '8GB', 'camera' => '50MP + 8MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (OxygenOS 13.1)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Tempest Gray', 'price' => 21900, 'original_price' => 33999, 'condition' => 1, 'stock' => 11],
                        ['storage' => '256GB', 'color' => 'Misty Green', 'price' => 24900, 'original_price' => 36999, 'condition' => 1, 'stock' => 6],
                        ['storage' => '128GB', 'color' => 'Tempest Gray', 'price' => 17900, 'original_price' => 33999, 'condition' => 3, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'OnePlus 10 Pro',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'LTPO2 AMOLED 120Hz', 'processor' => 'Snapdragon 8 Gen 1', 'ram' => '12GB', 'camera' => '48MP + 50MP + 8MP', 'battery' => '5000 mAh', 'os' => 'Android 12 (OxygenOS 12.1)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Volcanic Black', 'price' => 29900, 'original_price' => 66999, 'condition' => 2, 'stock' => 7],
                        ['storage' => '256GB', 'color' => 'Emerald Forest', 'price' => 24900, 'original_price' => 66999, 'condition' => 3, 'stock' => 5],
                    ],
                ],
            ],

            // ─── XIAOMI ─────────────────────────────────────────────────
            'Xiaomi' => [
                [
                    'model' => 'Xiaomi 14 Ultra',
                    'specs' => ['display_size' => '6.73"', 'display_type' => 'LTPO AMOLED 120Hz', 'processor' => 'Snapdragon 8 Gen 3', 'ram' => '16GB', 'camera' => '50MP + 50MP + 50MP + 50MP (Leica)', 'battery' => '5000 mAh', 'os' => 'Android 14 (HyperOS)'],
                    'products' => [
                        ['storage' => '512GB', 'color' => 'Black', 'price' => 79900, 'original_price' => 99999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '512GB', 'color' => 'White', 'price' => 69900, 'original_price' => 99999, 'condition' => 2, 'stock' => 5],
                    ],
                ],
                [
                    'model' => 'Xiaomi 14',
                    'specs' => ['display_size' => '6.36"', 'display_type' => 'LTPO AMOLED 120Hz', 'processor' => 'Snapdragon 8 Gen 3', 'ram' => '12GB', 'camera' => '50MP + 50MP + 50MP (Leica)', 'battery' => '4610 mAh', 'os' => 'Android 14 (HyperOS)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Jade Green', 'price' => 49900, 'original_price' => 69999, 'condition' => 1, 'stock' => 6],
                        ['storage' => '512GB', 'color' => 'Black', 'price' => 54900, 'original_price' => 79999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '256GB', 'color' => 'White', 'price' => 42900, 'original_price' => 69999, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'Redmi Note 13 Pro+',
                    'specs' => ['display_size' => '6.67"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 7200', 'ram' => '8GB', 'camera' => '200MP + 8MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 13 (MIUI 14)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Midnight Black', 'price' => 22900, 'original_price' => 32999, 'condition' => 1, 'stock' => 14],
                        ['storage' => '256GB', 'color' => 'Aurora Purple', 'price' => 24900, 'original_price' => 35999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '128GB', 'color' => 'Fusion White', 'price' => 18900, 'original_price' => 32999, 'condition' => 2, 'stock' => 12],
                    ],
                ],
                [
                    'model' => 'Poco F6 Pro',
                    'specs' => ['display_size' => '6.67"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'Snapdragon 8s Gen 3', 'ram' => '12GB', 'camera' => '50MP + 8MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 14 (HyperOS)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Black', 'price' => 29900, 'original_price' => 42999, 'condition' => 1, 'stock' => 9],
                        ['storage' => '512GB', 'color' => 'White', 'price' => 34900, 'original_price' => 49999, 'condition' => 1, 'stock' => 5],
                        ['storage' => '256GB', 'color' => 'Black', 'price' => 24900, 'original_price' => 42999, 'condition' => 3, 'stock' => 7],
                    ],
                ],
                [
                    'model' => 'Redmi Note 12 Pro',
                    'specs' => ['display_size' => '6.67"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 1080', 'ram' => '6GB', 'camera' => '50MP + 8MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 12 (MIUI 13)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Glacier Blue', 'price' => 14900, 'original_price' => 24999, 'condition' => 1, 'stock' => 18],
                        ['storage' => '128GB', 'color' => 'Onyx Black', 'price' => 11900, 'original_price' => 24999, 'condition' => 2, 'stock' => 14],
                        ['storage' => '256GB', 'color' => 'Stardust Purple', 'price' => 16900, 'original_price' => 27999, 'condition' => 1, 'stock' => 8],
                    ],
                ],
            ],

            // ─── NOTHING ────────────────────────────────────────────────
            'Nothing' => [
                [
                    'model' => 'Nothing Phone (2a) Plus',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'Flexible AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 7350 Pro', 'ram' => '12GB', 'camera' => '50MP + 50MP', 'battery' => '5000 mAh', 'os' => 'Android 14 (Nothing OS 2.6)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Gray', 'price' => 27900, 'original_price' => 31999, 'condition' => 1, 'stock' => 6],
                        ['storage' => '256GB', 'color' => 'Gray', 'price' => 22900, 'original_price' => 31999, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'Nothing Phone (2)',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'LTPO OLED 120Hz', 'processor' => 'Snapdragon 8+ Gen 1', 'ram' => '12GB', 'camera' => '50MP + 50MP', 'battery' => '4700 mAh', 'os' => 'Android 13 (Nothing OS 2.0)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Dark Gray', 'price' => 32900, 'original_price' => 44999, 'condition' => 1, 'stock' => 5],
                        ['storage' => '256GB', 'color' => 'White', 'price' => 37900, 'original_price' => 49999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '128GB', 'color' => 'White', 'price' => 27900, 'original_price' => 44999, 'condition' => 2, 'stock' => 7],
                    ],
                ],
                [
                    'model' => 'Nothing Phone (2a)',
                    'specs' => ['display_size' => '6.7"', 'display_type' => 'Flexible AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 7200 Pro', 'ram' => '8GB', 'camera' => '50MP + 50MP', 'battery' => '5000 mAh', 'os' => 'Android 14 (Nothing OS 2.5)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Black', 'price' => 19900, 'original_price' => 23999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '256GB', 'color' => 'Milk', 'price' => 22900, 'original_price' => 27999, 'condition' => 1, 'stock' => 7],
                        ['storage' => '128GB', 'color' => 'Milk', 'price' => 16900, 'original_price' => 23999, 'condition' => 2, 'stock' => 9],
                    ],
                ],
                [
                    'model' => 'Nothing Phone (1)',
                    'specs' => ['display_size' => '6.55"', 'display_type' => 'OLED 120Hz', 'processor' => 'Snapdragon 778G+', 'ram' => '8GB', 'camera' => '50MP + 50MP', 'battery' => '4500 mAh', 'os' => 'Android 12 (Nothing OS 1.0)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'White', 'price' => 14900, 'original_price' => 32999, 'condition' => 2, 'stock' => 8],
                        ['storage' => '256GB', 'color' => 'Black', 'price' => 17900, 'original_price' => 35999, 'condition' => 1, 'stock' => 5],
                        ['storage' => '128GB', 'color' => 'Black', 'price' => 11900, 'original_price' => 32999, 'condition' => 3, 'stock' => 6],
                    ],
                ],
                [
                    'model' => 'Nothing CMF Phone 1',
                    'specs' => ['display_size' => '6.67"', 'display_type' => 'Super AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 7300', 'ram' => '8GB', 'camera' => '50MP + Depth', 'battery' => '5000 mAh', 'os' => 'Android 14 (Nothing OS 2.6)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Orange', 'price' => 13900, 'original_price' => 15999, 'condition' => 1, 'stock' => 12],
                        ['storage' => '128GB', 'color' => 'Blue', 'price' => 11900, 'original_price' => 15999, 'condition' => 2, 'stock' => 10],
                    ],
                ],
            ],

            // ─── VIVO ───────────────────────────────────────────────────
            'Vivo' => [
                [
                    'model' => 'Vivo X100 Pro',
                    'specs' => ['display_size' => '6.78"', 'display_type' => 'LTPO AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 9300', 'ram' => '16GB', 'camera' => '50MP + 50MP + 50MP (ZEISS)', 'battery' => '5400 mAh', 'os' => 'Android 14 (Funtouch 14)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Asteroid Black', 'price' => 74900, 'original_price' => 89999, 'condition' => 1, 'stock' => 5],
                        ['storage' => '256GB', 'color' => 'Stardust Blue', 'price' => 64900, 'original_price' => 89999, 'condition' => 2, 'stock' => 6],
                    ],
                ],
                [
                    'model' => 'Vivo X100',
                    'specs' => ['display_size' => '6.78"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 9300', 'ram' => '12GB', 'camera' => '50MP + 50MP + 64MP (ZEISS)', 'battery' => '5000 mAh', 'os' => 'Android 14 (Funtouch 14)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Asteroid Black', 'price' => 54900, 'original_price' => 65999, 'condition' => 1, 'stock' => 7],
                        ['storage' => '512GB', 'color' => 'Stardust Blue', 'price' => 59900, 'original_price' => 72999, 'condition' => 1, 'stock' => 4],
                        ['storage' => '256GB', 'color' => 'Asteroid Black', 'price' => 44900, 'original_price' => 65999, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'Vivo V30 Pro',
                    'specs' => ['display_size' => '6.78"', 'display_type' => 'Curved AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 8200', 'ram' => '12GB', 'camera' => '50MP + 50MP + 8MP (ZEISS)', 'battery' => '5000 mAh', 'os' => 'Android 14 (Funtouch 14)'],
                    'products' => [
                        ['storage' => '256GB', 'color' => 'Peacock Green', 'price' => 34900, 'original_price' => 46999, 'condition' => 1, 'stock' => 8],
                        ['storage' => '256GB', 'color' => 'Classic Black', 'price' => 29900, 'original_price' => 46999, 'condition' => 2, 'stock' => 9],
                    ],
                ],
                [
                    'model' => 'Vivo T3 Ultra',
                    'specs' => ['display_size' => '6.78"', 'display_type' => 'Curved AMOLED 120Hz', 'processor' => 'MediaTek Dimensity 9200+', 'ram' => '12GB', 'camera' => '50MP + 8MP', 'battery' => '5500 mAh', 'os' => 'Android 14 (Funtouch 14)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Lunar Gray', 'price' => 27900, 'original_price' => 35999, 'condition' => 1, 'stock' => 10],
                        ['storage' => '256GB', 'color' => 'Frost Green', 'price' => 29900, 'original_price' => 39999, 'condition' => 1, 'stock' => 6],
                        ['storage' => '128GB', 'color' => 'Lunar Gray', 'price' => 22900, 'original_price' => 35999, 'condition' => 2, 'stock' => 8],
                    ],
                ],
                [
                    'model' => 'Vivo Y200e',
                    'specs' => ['display_size' => '6.67"', 'display_type' => 'AMOLED 120Hz', 'processor' => 'Snapdragon 4 Gen 2', 'ram' => '8GB', 'camera' => '50MP + 2MP', 'battery' => '5000 mAh', 'os' => 'Android 14 (Funtouch 14)'],
                    'products' => [
                        ['storage' => '128GB', 'color' => 'Saffron Delight', 'price' => 12900, 'original_price' => 18999, 'condition' => 1, 'stock' => 18],
                        ['storage' => '128GB', 'color' => 'Crystal Black', 'price' => 9900, 'original_price' => 18999, 'condition' => 2, 'stock' => 15],
                        ['storage' => '128GB', 'color' => 'Saffron Delight', 'price' => 7900, 'original_price' => 18999, 'condition' => 3, 'stock' => 10],
                    ],
                ],
            ],
        ];

        // ── Seed Phone Models + Products ────────────────────────────────
        $now = Carbon::now();
        $productCount = 0;

        foreach ($catalog as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            if (!$brand) {
                echo "  ⚠ Brand '{$brandName}' not found, skipping.\n";
                continue;
            }

            echo "🏷  {$brandName}\n";

            foreach ($models as $modelData) {
                // Create or find phone model
                $phoneModel = PhoneModel::updateOrCreate(
                    ['name' => $modelData['model'], 'brand_id' => $brand->id],
                    array_merge(
                        ['slug' => Str::slug($modelData['model']), 'is_active' => true],
                        $modelData['specs']
                    )
                );

                echo "   📱 {$phoneModel->name}\n";

                foreach ($modelData['products'] as $p) {
                    $title = $modelData['model'] . ' ' . $p['storage'] . ' ' . $p['color'];
                    $slug = Str::slug($title);

                    // Ensure unique slug
                    $baseSlug = $slug;
                    $counter = 1;
                    while (Product::withTrashed()->where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $counter++;
                    }

                    $conditionLabel = match($p['condition']) {
                        1 => 'Excellent',
                        2 => 'Good',
                        3 => 'Fair',
                        default => 'Good',
                    };

                    $sku = strtoupper(substr($brandName, 0, 2)) . '-' . strtoupper(Str::random(8));

                    Product::create([
                        'phone_model_id' => $phoneModel->id,
                        'condition_id'   => $p['condition'],
                        'title'          => $title,
                        'slug'           => $slug,
                        'description'    => "Refurbished {$modelData['model']} in {$conditionLabel} condition. {$p['storage']} storage, {$p['color']} color. Fully tested and certified.",
                        'primary_image'  => null,
                        'base_price'     => $p['price'],
                        'original_price' => $p['original_price'],
                        'storage'        => $p['storage'],
                        'color'          => $p['color'],
                        'price'          => $p['price'],
                        'stock'          => $p['stock'],
                        'sku'            => $sku,
                        'is_available'   => true,
                        'imei'           => null,
                        'warranty_months' => rand(3, 12),
                        'whats_in_box'   => 'Phone, Charger, USB Cable, Documentation',
                        'views'          => rand(50, 500),
                        'is_featured'    => rand(0, 3) === 0,
                        'is_active'      => true,
                        'published_at'   => $now->copy()->subDays(rand(0, 30)),
                    ]);

                    $productCount++;
                    echo "      ✅ {$title} ({$conditionLabel}) — ₹" . number_format($p['price'], 0) . "\n";
                }
            }
        }

        echo "\n🎉 Created {$productCount} products across all brands!\n";
    }
}
