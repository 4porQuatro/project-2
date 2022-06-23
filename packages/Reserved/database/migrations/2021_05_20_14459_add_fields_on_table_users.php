<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('reserved_area_id')->nullable();

            $table->foreign('reserved_area_id')->references('id')->on('reserved_areas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if(env('APP_ENV') !== 'testing')
            {
                $table->dropForeign(['reserved_area_id']);
            }
            $table->dropColumn(['reserved_area_id']);
        });
    }
}
