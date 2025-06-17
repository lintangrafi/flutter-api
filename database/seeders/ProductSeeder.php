<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Data produk akan dihapus oleh VendorSeeder.
        $vendor1 = \App\Models\Vendor::where('name', 'Toko Mie Ayam Pak Kumis')->first();
        $vendor2 = \App\Models\Vendor::where('name', 'Supplier Mie & Bumbu')->first();
        $vendor3 = \App\Models\Vendor::where('name', 'Ayam Segar Jaya')->first();

        // Produk untuk Toko Mie Ayam Pak Kumis
        \App\Models\Product::create([
            'name' => 'Mie Basah Spesial',
            'price' => 15000,
            'unit' => 'kg',
            'description' => 'Mie basah untuk mi ayam, kualitas premium',
            'stock' => 50,
            'vendor_id' => $vendor1 ? $vendor1->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Mie Telur Kuning',
            'price' => 17000,
            'unit' => 'kg',
            'description' => 'Mie telur kuning, kenyal dan gurih',
            'stock' => 40,
            'vendor_id' => $vendor1 ? $vendor1->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Mie Kering Instan',
            'price' => 12000,
            'unit' => 'paket',
            'description' => 'Mie kering siap saji untuk mi ayam',
            'stock' => 60,
            'vendor_id' => $vendor1 ? $vendor1->id : 1,
        ]);

        // Produk untuk Supplier Mie & Bumbu
        \App\Models\Product::create([
            'name' => 'Bumbu Mi Ayam Komplit',
            'price' => 10000,
            'unit' => 'paket',
            'description' => 'Bumbu racikan siap pakai untuk mi ayam',
            'stock' => 100,
            'vendor_id' => $vendor2 ? $vendor2->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Kecap Manis Spesial',
            'price' => 8000,
            'unit' => 'botol',
            'description' => 'Kecap manis untuk pelengkap mi ayam',
            'stock' => 70,
            'vendor_id' => $vendor2 ? $vendor2->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Minyak Ayam Gurih',
            'price' => 9000,
            'unit' => 'botol',
            'description' => 'Minyak ayam gurih untuk topping mi ayam',
            'stock' => 80,
            'vendor_id' => $vendor2 ? $vendor2->id : 1,
        ]);

        // Produk untuk Ayam Segar Jaya
        \App\Models\Product::create([
            'name' => 'Daging Ayam Fillet',
            'price' => 40000,
            'unit' => 'kg',
            'description' => 'Daging ayam fillet segar',
            'stock' => 30,
            'vendor_id' => $vendor3 ? $vendor3->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Ceker Ayam Segar',
            'price' => 20000,
            'unit' => 'kg',
            'description' => 'Ceker ayam segar untuk topping mi ayam',
            'stock' => 25,
            'vendor_id' => $vendor3 ? $vendor3->id : 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Tulang Ayam Untuk Kaldu',
            'price' => 15000,
            'unit' => 'kg',
            'description' => 'Tulang ayam segar untuk kaldu mi ayam',
            'stock' => 20,
            'vendor_id' => $vendor3 ? $vendor3->id : 1,
        ]);
    }
}
