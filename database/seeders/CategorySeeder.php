<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptops', 'description' => 'Laptops'],
            ['name' => 'Desktops', 'description' => 'Desktops'],
            ['name' => 'Mobile Phones', 'description' => 'Mobile Phones'],
            ['name' => 'Tablets', 'description' => 'Tablets'],
            ['name' => 'Accessories', 'description' => 'Accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
