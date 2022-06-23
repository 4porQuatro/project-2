<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_families', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute_family', 'Família de atributos');
        $permissions_seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute_family', 'Família de atributos');
        $permissions_seeder->delete();

        Schema::dropIfExists('attribute_families');
    }
}
