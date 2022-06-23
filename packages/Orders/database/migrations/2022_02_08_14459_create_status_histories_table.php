<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->smallInteger('status');
            $table->text('text')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::table('orders', function(Blueprint $table){
           $table->text('status_note')->nullable();
        });

    }

    /**
     * Reverse the migrations.s
     *
     * @return void
     */
    public function down()
    {

        Schema::table('orders', function(Blueprint $table){
            $table->dropColumn('status_note');
        });
        Schema::dropIfExists('status_histories');
    }
}
