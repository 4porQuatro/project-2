<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('type');
            $table->string('name');
            $table->timestamps();
        });

        (new \Packages\Orders\database\seeders\AddCheckoutPermissionsSeeder())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new \Packages\Orders\database\seeders\AddCheckoutPermissionsSeeder())->runInverse();
        Schema::dropIfExists('checkouts');
    }
}
