<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            [
                'name' => 'Excellent',
                'slug' => 'excellent',
                'description' => 'Like new condition with minimal signs of use. Screen and body are in pristine condition.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Good',
                'slug' => 'good',
                'description' => 'Minor scratches or scuffs on body or screen. Fully functional with normal wear and tear.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Fair',
                'slug' => 'fair',
                'description' => 'Visible signs of use including scratches and dents. Fully functional but shows considerable wear.',
                'sort_order' => 3,
            ],
        ];

        foreach ($conditions as $condition) {
            Condition::create($condition);
        }
    }
}
