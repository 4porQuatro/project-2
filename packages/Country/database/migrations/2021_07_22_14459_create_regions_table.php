<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->string('code', 10);
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->unique(['country_code', 'code']);
            $table->timestamps();

            //$table->foreign('country_code')->references('code')->table('countries')->onDelete('cascade');
        });

        /**
        Schema::create('region_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id');
            $table->string('locale');
            $table->string('name');
            //$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });
         * **/
        (new \Packages\Country\database\seeders\PopulateRegionsTable())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('region_translations');
        Schema::dropIfExists('regions');
    }
}
