<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemapOldStatusToNewStandard extends Migration
{
    public function up()
    {
        // Remap old statuses to new standardized values
        DB::table('purchase_orders')->update([
            'status' => DB::raw("CASE
                WHEN status = 'Menunggu Persetujuan' THEN 'draft'
                WHEN status = 'Disetujui' THEN 'approved'
                WHEN status = 'Dikirim' THEN 'completed'
                WHEN status = 'Dibatalkan' THEN 'paid'
                ELSE 'draft'
                END")
        ]);
    }

    public function down()
    {
        // Optionally revert changes if needed
        DB::table('purchase_orders')->update([
            'status' => DB::raw("CASE
                WHEN status = 'draft' THEN 'Menunggu Persetujuan'
                WHEN status = 'approved' THEN 'Disetujui'
                WHEN status = 'completed' THEN 'Dikirim'
                WHEN status = 'paid' THEN 'Dibatalkan'
                ELSE 'Menunggu Persetujuan'
                END")
        ]);
    }
}
