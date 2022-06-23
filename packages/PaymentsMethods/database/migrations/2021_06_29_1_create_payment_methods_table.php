<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->string('provider_method');
            $table->timestamps();
        });

        (new \Packages\PaymentsMethods\database\seeders\AddPermissionsToPaymentMethods())->run();
        (new \Packages\PaymentsMethods\database\seeders\AddModelSettings())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new \Packages\PaymentsMethods\database\seeders\AddPermissionsToPaymentMethods())->runInverse();
        (new \Packages\PaymentsMethods\database\seeders\AddModelSettings())->runInverse();
        Schema::dropIfExists('payment_methods');
    }
}
