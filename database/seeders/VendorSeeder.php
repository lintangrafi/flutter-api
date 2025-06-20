<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('products')->truncate();
        DB::table('vendors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        \App\Models\Vendor::create([
            'name' => 'Toko Mie Ayam Pak Kumis',
            'phone' => '081234567890',
            'address' => 'Jl. Bakmi No. 1, Serang',
            'email' => 'pak.kumis@miayam.com',
        ]);
        \App\Models\Vendor::create([
            'name' => 'Supplier Mie & Bumbu',
            'phone' => '081298765432',
            'address' => 'Jl. Bumbu Rasa No. 2, Cilegon',
            'email' => 'bumbu@miayam.com',
        ]);
        \App\Models\Vendor::create([
            'name' => 'Ayam Segar Jaya',
            'phone' => '081212345678',
            'address' => 'Jl. Ayam Segar No. 3, Lebak',
            'email' => 'ayam@miayam.com',
        ]);
    }
}
