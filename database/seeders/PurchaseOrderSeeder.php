<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;

class PurchaseOrderSeeder extends Seeder
{
    public function run()
    {
        $po = PurchaseOrder::create([
            'po_number' => 'PO-001',
            'vendor_id' => 1,
            'date' => now(),
            'status' => 'Menunggu Persetujuan',
            'total' => 0,
            'created_by' => 1,
        ]);

        $items = [
            [
                'product_id' => 1,
                'name' => 'Kertas A4',
                'price' => 45000,
                'quantity' => 2,
                'unit' => 'Pack',
            ],
            [
                'product_id' => 2,
                'name' => 'Tinta Printer',
                'price' => 75000,
                'quantity' => 1,
                'unit' => 'Botol',
            ],
        ];

        $total = 0;

        foreach ($items as $item) {
            $po->items()->create($item);
            $total += $item['price'] * $item['quantity'];
        }

        $po->update(['total' => $total]);
    }
}
