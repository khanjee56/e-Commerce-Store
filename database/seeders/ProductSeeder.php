<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create Categories
        $electronics = Category::create(['name' => 'Electronics']);
        $clothes = Category::create(['name' => 'Clothes']);
        $shoes = Category::create(['name' => 'Shoes']);
        

        // Create Products
        Product::create([
            'name' => 'Samsung Phone',
            'description' => 'Latest Samsung smartphone with great camera',
            'price' => 50000,
            'stock' => 10,
            'category_id' => $electronics->id,
        ]);

        Product::create([
            'name' => 'Laptop',
            'description' => 'High performance laptop for students',
            'price' => 120000,
            'stock' => 5,
            'category_id' => $electronics->id,
        ]);

        Product::create([
            'name' => 'Nike T-Shirt',
            'description' => 'Comfortable cotton t-shirt',
            'price' => 2500,
            'stock' => 20,
            'category_id' => $clothes->id,
        ]);

        Product::create([
            'name' => 'Jeans',
            'description' => 'Stylish slim fit jeans',
            'price' => 3500,
            'stock' => 15,
            'category_id' => $clothes->id,
         
        ]);

        Product::create([
            'name' => 'Nike Shoes',
            'description' => 'Comfortable sports shoes',
            'price' => 8000,
            'stock' => 8,
            'category_id' => $shoes->id,
        ]);
    }
}