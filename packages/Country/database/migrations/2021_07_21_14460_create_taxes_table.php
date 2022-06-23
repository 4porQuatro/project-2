<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taxable_id');
            $table->string('taxable_type');
            $table->float('percentage')->default(0);
            $table->timestamps();
        });

        (new \Packages\Country\database\seeders\AddPermissionsToTaxes())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
        (new \Packages\Country\database\seeders\AddPermissionsToTaxes())->runInverse();
    }
}
