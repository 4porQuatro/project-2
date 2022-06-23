<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addCountryIdAndRegionIdAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();

        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable();

        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('email')->nullable();

        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('city')->nullable();

        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('phone')->nullable();

        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('post_code')->nullable();

        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['country', 'location', 'contact', 'postal_code', 'postal_code_prefix']);

        });

        Schema::table('addresses', function(Blueprint $table){
            $table->string('post_code_prefix')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function(Blueprint $table) {
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('contact')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('postal_code_prefix')->nullable();
            if(env('APP_ENV') !== 'testing')
            {
                $table->dropColumn(['country_id', 'region_id', 'phone', 'email', 'city', 'post_code', 'post_code_prefix']);
            }

        });
    }
}
