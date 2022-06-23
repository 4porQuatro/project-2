<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyAndVoucherFieldsOnTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->float('currency_rate')->default(1);
            $table->json('voucher_object')->nullable();
            $table->float('voucher_discount', 10, 2)->default(0);
        });

    }

    /**
     * Reverse the migrations.s
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropColumn(['currency_id']);
        });
    }
}
