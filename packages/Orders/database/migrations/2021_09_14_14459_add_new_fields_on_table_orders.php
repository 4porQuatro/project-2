<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddNewFieldsOnTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('checkout_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->unsignedBigInteger('user_id')->change()->nullable();

            $table->decimal('percentage_taxes')->nullable();
            $table->json('shipping_address_keys')->nullable();
            $table->json('shipping_address_data')->nullable();
            $table->json('provider_payment_data')->nullable();
            $table->uuid('uuid')->nullable();
        });

        foreach(\Packages\Orders\App\Models\Order::all() as $order)
        {
            $order->uuid = Str::uuid()->toString();
            $order->save();
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['provider_payment_data','checkout_id','country_id', 'region_id', 'payment_method_id', 'shipping_method_id', 'percentage_taxes', 'shipping_address_keys', 'shipping_address_data']);
            //$table->unsignedBigInteger('user_id')->change()->nullable(false);
        });

    }
}
