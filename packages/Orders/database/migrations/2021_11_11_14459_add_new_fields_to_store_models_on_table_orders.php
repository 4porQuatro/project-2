<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Packages\Orders\App\Models\Order;

class AddNewFieldsToStoreModelsOnTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('original_shipping_method')->nullable();
            $table->json('original_payment_method')->nullable();

        });

        $orders = Order::all();
        foreach($orders as $order)
        {
            if(!empty($order->shippingMethod) && empty($order->original_shipping_method))
            {
                $order->original_shipping_method = $order->shippingMethod->toArray();
            } else {
                $order->original_shipping_method = [];
            }
            if(!empty($order->paymentMethod) && empty($order->original_payment_method))
            {
                $order->original_payment_method = $order->paymentMethod->toArray();
            } else {
                $order->original_payment_method = [];
            }
            $order->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['original_shipping_method', 'original_payment_method']);
        });

    }
}
