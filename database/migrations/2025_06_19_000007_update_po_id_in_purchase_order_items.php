<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePoIdInPurchaseOrderItems extends Migration
{
    public function up()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_order_items', 'po_id')) {
                $table->unsignedBigInteger('po_id')->nullable();
                $table->foreign('po_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->dropForeign(['po_id']);
            $table->dropColumn('po_id');
        });
    }
}
