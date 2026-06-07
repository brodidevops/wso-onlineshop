<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if categories already exist
        if (DB::table('categories')->count() > 0) {
            echo "Categories already exist. Skipping...\n";
            return;
        }

        $categories = [
            [
                'name' => 'Elektronik',
                'icon' => '📱',
                'description' => 'Produk elektronik dan gadget terbaru',
                'is_active' => true,
                'sort' => 1,
                'children' => [
                    ['name' => 'Smartphone', 'icon' => '📱', 'sort' => 1],
                    ['name' => 'Laptop', 'icon' => '💻', 'sort' => 2],
                    ['name' => 'Tablet', 'icon' => '📲', 'sort' => 3],
                    ['name' => 'Aksesoris', 'icon' => '🎧', 'sort' => 4],
                ],
            ],
            [
                'name' => 'Fashion',
                'icon' => '👕',
                'description' => 'Pakaian dan aksesoris fashion',
                'is_active' => true,
                'sort' => 2,
                'children' => [
                    ['name' => 'Pria', 'icon' => '👔', 'sort' => 1],
                    ['name' => 'Wanita', 'icon' => '👗', 'sort' => 2],
                    ['name' => 'Anak-anak', 'icon' => '🧒', 'sort' => 3],
                ],
            ],
            [
                'name' => 'Rumah Tangga',
                'icon' => '🏠',
                'description' => 'Perlengkapan rumah tangga',
                'is_active' => true,
                'sort' => 3,
                'children' => [
                    ['name' => 'Dapur', 'icon' => '🍳', 'sort' => 1],
                    ['name' => 'Kamar Tidur', 'icon' => '🛏️', 'sort' => 2],
                    ['name' => 'Dekorasi', 'icon' => '🖼️', 'sort' => 3],
                ],
            ],
            [
                'name' => 'Kecantikan',
                'icon' => '💄',
                'description' => 'Produk kecantikan dan skincare',
                'is_active' => true,
                'sort' => 4,
                'children' => [
                    ['name' => 'Skincare', 'icon' => '✨', 'sort' => 1],
                    ['name' => 'Makeup', 'icon' => '💋', 'sort' => 2],
                    ['name' => 'Parfum', 'icon' => '🌸', 'sort' => 3],
                ],
            ],
            [
                'name' => 'Olahraga',
                'icon' => '⚽',
                'description' => 'Peralatan dan apparel olahraga',
                'is_active' => true,
                'sort' => 5,
                'children' => [
                    ['name' => 'Fitness', 'icon' => '🏋️', 'sort' => 1],
                    ['name' => 'Outdoor', 'icon' => '🏕️', 'sort' => 2],
                    ['name' => 'Olahraga Air', 'icon' => '🏊', 'sort' => 3],
                ],
            ],
            [
                'name' => 'Makanan & Minuman',
                'icon' => '🍕',
                'description' => 'Makanan dan minuman sehat',
                'is_active' => true,
                'sort' => 6,
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $child) {
                $category->children()->create($child);
            }
        }
    }
}
