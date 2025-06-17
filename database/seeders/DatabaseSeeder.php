<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
            PurchaseOrderSeeder::class,
        ]);
    }
}
