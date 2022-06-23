<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('type');

            $table->string('name');
            $table->string('nif')->nullable();
            $table->string('address');
            $table->string('postal_code')->nullable();
            $table->string('postal_code_prefix')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('contact')->nullable();

            $table->text('additional_data')->nullable();
            $table->boolean('default')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
