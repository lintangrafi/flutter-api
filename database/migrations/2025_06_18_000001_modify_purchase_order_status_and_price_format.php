<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update status column to ENUM and remap old statuses
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('status', 50)->change();
        });

        DB::table('purchase_orders')->update([
            'status' => DB::raw("CASE
                WHEN status = 'Menunggu Persetujuan' THEN 'draft'
                WHEN status = 'Disetujui' THEN 'approved'
                WHEN status = 'Dikirim' THEN 'completed'
                ELSE 'draft'
                END")
        ]);

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->enum('status', ['draft', 'approved', 'completed', 'pending', 'paid'])->default('draft')->change();
        });

        // Ensure total_amount column exists before modifying
        Schema::table('purchase_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_orders', 'total_amount')) {
                $table->bigInteger('total_amount')->nullable();
            }
        });

        // Convert price columns to integer
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->bigInteger('total_amount')->nullable()->change();
        });

        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->bigInteger('price')->nullable()->change();
            $table->bigInteger('subtotal')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('status')->change();
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->decimal('total_amount', 15, 2)->nullable()->change();
        });

        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->nullable()->change();
            $table->decimal('subtotal', 15, 2)->nullable()->change();
        });
    }
};
