<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceFormatInPurchaseOrderItemsAndProducts extends Migration
{
    public function up()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->bigInteger('price')->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('price')->change();
        });
    }
}
