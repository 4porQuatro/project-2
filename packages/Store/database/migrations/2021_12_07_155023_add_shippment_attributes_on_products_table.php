<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippmentAttributesOnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->bigInteger('shippment_length')->default(0);
           $table->bigInteger('shippment_weight')->default(0);
           $table->bigInteger('shippment_width')->default(0);
           $table->bigInteger('shippment_height')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shippment_length', 'shippment_weight', 'shippment_width', 'shippment_height']);
        });
    }
}
