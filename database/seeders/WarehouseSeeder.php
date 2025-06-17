<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::insert([
            [
                'name' => 'Gudang Serang 1',
                'address' => 'Jl. Raya Serang No.1, Serang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Serang 2',
                'address' => 'Jl. Serang Timur No.2, Serang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Lebak',
                'address' => 'Jl. Rangkasbitung No.3, Lebak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Jakarta',
                'address' => 'Jl. Sudirman No.4, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Cilegon',
                'address' => 'Jl. Cilegon Barat No.5, Cilegon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
