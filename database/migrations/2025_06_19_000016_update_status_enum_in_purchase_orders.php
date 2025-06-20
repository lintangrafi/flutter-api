<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInPurchaseOrders extends Migration
{
    public function up()
    {
        // Update status column to new ENUM values
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Dikirim', 'Dibatalkan'])
                  ->default('Menunggu Persetujuan')
                  ->change();
        });

        // Remap old statuses to new standardized values
        DB::table('purchase_orders')->update([
            'status' => DB::raw("CASE
                WHEN status = 'draft' THEN 'Menunggu Persetujuan'
                WHEN status = 'approved' THEN 'Disetujui'
                WHEN status = 'completed' THEN 'Dikirim'
                WHEN status = 'pending' THEN 'Menunggu Persetujuan'
                WHEN status = 'paid' THEN 'Dibatalkan'
                ELSE 'Menunggu Persetujuan'
                END")
        ]);
    }

    public function down()
    {
        // Revert status column to original ENUM values
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->enum('status', ['draft', 'approved', 'completed', 'pending', 'paid'])
                  ->default('draft')
                  ->change();
        });
    }
}
