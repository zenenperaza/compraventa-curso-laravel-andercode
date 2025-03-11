<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Administrador')->orWhere('name', 'Mantenedor');
        })->get();

        $products = [
            ['name' => 'Laptop', 'description' => 'Laptop', 'price' => 1000, 'quantity' => 10],
            ['name' => 'Desktop', 'description' => 'Desktop', 'price' => 800, 'quantity' => 10],
            ['name' => 'Mobile Phone', 'description' => 'Mobile Phone', 'price' => 500, 'quantity' => 10],
            ['name' => 'Tablet', 'description' => 'Tablet', 'price' => 300, 'quantity' => 10],
            ['name' => 'Headphones', 'description' => 'Headphones', 'price' => 100, 'quantity' => 10],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'status' => 'available',
            ]);
        }
    }
}
