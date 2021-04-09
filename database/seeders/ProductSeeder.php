<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::query()->create([
            'name' => 'Sepatu Merah',
            'price' => 1000000,
            'quantity' => 10,
            'image_url' => 'products/a.jpg',
        ]);

        Product::query()->create([
            'name' => 'Celana Pendek Jingga',
            'price' => 30000,
            'quantity' => 40,
            'image_url' =>  'products/b.jpg',
        ]);

        Product::query()->create([
            'name' => 'Kaos Hitam',
            'price' => 50000,
            'quantity' => 50,
            'image_url' => 'products/c.jpg',
        ]);
    }
}
