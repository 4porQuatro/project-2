<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelSettingIdOnProductsAndSeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('model_setting_id')->unsigned()->nullable();

            $table->foreign('model_setting_id')->references('id')->on('model_settings')->onDelete('set null');
        });

        $product_model_setting = new \Packages\Store\database\seeders\ProductModelSettingSeeder();
        $product_model_setting->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() !== 'sqlite') {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['model_setting_id']);
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('model_setting_id');
        });
    }
}
