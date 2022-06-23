<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditShippingPricesAddPriceableColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_prices', function (Blueprint $table) {
            $table->dropColumn(['country_id', 'region_id']);
        });
        Schema::table('shipping_prices', function (Blueprint $table) {
            $table->string('priceable_type')->nullable();
            $table->unsignedBigInteger('priceable_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_prices', function (Blueprint $table) {
            $table->dropColumn(['priceable_type', 'priceable_id']);
        });
        Schema::table('shipping_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
        });
    }
}
