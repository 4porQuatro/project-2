<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('alpha3')->unique()->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('country_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->string('locale');
            $table->string('name');
            //$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });

        (new \Packages\Country\database\seeders\PopulateCountriesTable())->run();
        (new \Packages\Country\database\seeders\AddPermissionsToCountry())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('countries');
        (new \Packages\Country\database\seeders\AddPermissionsToCountry())->runInverse();

    }
}
