<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusInPurchaseOrders extends Migration
{
    public function up()
    {
        // Update status column to ENUM and remap old statuses
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->enum('status', ['Draft', 'Menunggu Persetujuan', 'Disetujui', 'Dikirim', 'Dibatalkan'])
                  ->default('Draft')
                  ->change();
        });

        // Remap old statuses to new standardized values
        DB::table('purchase_orders')->update([
            'status' => DB::raw("CASE
                WHEN status = 'Approved' THEN 'Disetujui'
                WHEN status = 'Rejected' THEN 'Dibatalkan'
                WHEN status = 'Pending' THEN 'Menunggu Persetujuan'
                WHEN status = 'Draft' THEN 'Draft'
                ELSE 'Draft'
                END")
        ]);
    }

    public function down()
    {
        // Revert status column to original state
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }
}
