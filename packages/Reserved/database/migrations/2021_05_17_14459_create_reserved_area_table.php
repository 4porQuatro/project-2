<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservedAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prefix');
            $table->unsignedBigInteger('login_page_id');
            $table->timestamps();
        });

        (new \Packages\Reserved\database\seeders\AddPermissionsToReservedArea())->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new \Packages\Reserved\database\seeders\AddPermissionsToReservedArea())->runInverse();
        Schema::dropIfExists('reserved_area');
    }
}
