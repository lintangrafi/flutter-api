<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run()
    {
        Vendor::create([
            'name' => 'PT. Sumber Makmur',
            'phone' => '081234567890',
            'address' => 'Jl. Raya Industri No. 123',
            'email' => 'vendor1@example.com',
        ]);
    }
}
