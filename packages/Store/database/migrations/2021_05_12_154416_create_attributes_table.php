<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->string('admin_title')->unique();
            $table->boolean('unique_per_product')->default(true);
            $table->string('swatch_type')->nullable();
            $table->unsignedinteger('priority')->default(0);

            $table->timestamps();
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute', 'Atributos');
        $permissions_seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('attribute', 'Atributos');
        $permissions_seeder->delete();

        Schema::dropIfExists('attributes');
    }
}
