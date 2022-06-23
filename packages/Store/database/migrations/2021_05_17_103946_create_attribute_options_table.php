<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('attribute_id');

            $table->unsignedinteger('priority')->default(0);
            $table->string('swatch_value')->nullable();
            $table->json('images')->nullable();

            $table->timestamps();

            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute_option', 'Opções de atributos');
        $permissions_seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute_option', 'Opções de atributos');
        $permissions_seeder->delete();

        Schema::dropIfExists('attribute_options');
    }
}
