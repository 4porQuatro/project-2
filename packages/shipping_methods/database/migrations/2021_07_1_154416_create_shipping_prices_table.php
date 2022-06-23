<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipping_method_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->bigInteger('min_volume')->default(0);
            $table->bigInteger('max_volume')->default(0);
            $table->bigInteger('min_weight')->default(0);
            $table->bigInteger('max_weight')->default(0);
            $table->double('price', 2)->default(0)->nullable();
            $table->double('free_order_price', 2)->default(0)->nullable();

            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
}
