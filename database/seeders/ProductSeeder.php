<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Kertas A4',
            'price' => 45000,
            'unit' => 'Pack',
            'description' => 'Kertas ukuran A4 80gsm',
            'stock' => 100,
        ]);

        Product::create([
            'name' => 'Tinta Printer',
            'price' => 75000,
            'unit' => 'Botol',
            'description' => 'Tinta printer hitam 100ml',
            'stock' => 50,
        ]);
    }
}
