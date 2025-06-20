<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceFieldInPurchaseOrderItems extends Migration
{
    public function up()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable(false)->change();
        });
    }
}
