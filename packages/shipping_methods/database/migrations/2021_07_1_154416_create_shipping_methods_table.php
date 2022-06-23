<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('default_price', 2)->default(0)->nullable();
            $table->double('default_free_order_price', 2)->default(0)->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        $permissions_seeder = new \Packages\shipping_methods\database\seeders\AddShippingMethodArea();
        $permissions_seeder->run();
        (new \Packages\shipping_methods\database\seeders\AddModelSettings())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Packages\shipping_methods\database\seeders\AddShippingMethodArea();
        $permissions_seeder->runInverse();
        (new \Packages\shipping_methods\database\seeders\AddModelSettings())->runInverse();


        Schema::dropIfExists('shipping_methods');
    }
}
