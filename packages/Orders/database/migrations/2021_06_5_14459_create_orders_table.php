<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->smallInteger('status')->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('total_taxes', 10,2)->default(0);
            $table->decimal('total_shipping', 10,2)->default(0);
            $table->decimal('total_discount', 10,2)->default(0);

            $table->json('billing_address_keys')->nullable();
            $table->json('billing_address_data')->nullable();

            $table->timestamps();
        });

        (new \Packages\Orders\database\seeders\AddPermissionsSeeder())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new \Packages\Orders\database\seeders\AddPermissionsSeeder())->runInverse();
        Schema::dropIfExists('orders');
    }
}
