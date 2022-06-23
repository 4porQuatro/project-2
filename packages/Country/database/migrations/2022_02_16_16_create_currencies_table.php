<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\Country\database\seeders\ZoneSeeder;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('name');
            $table->string('name_plural')->nullable();
            $table->string('symbol', 10);
            $table->string('symbol_native', 10);
            $table->integer('decimal_digits');
            $table->string('code', 10);
            $table->float('rate')->default(1);

            $table->timestamps();

        });

        (new \Packages\Country\database\seeders\PopulateCurrenciesTable())->run();

        $id_eur = \Illuminate\Support\Facades\DB::table('currencies')->where('code', 'EUR')->first()->id;

        Schema::table('countries', function(Blueprint $table) use ($id_eur)
        {
            $table->unsignedBigInteger('currency_id')->default($id_eur);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function(Blueprint $table) {
            $table->dropColumn('currency_id');
        });
        Schema::dropIfExists('currencies');
    }
}
