<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('documentable_id')->nullable();
            $table->string('documentable_type')->nullable();

            $table->json('paths')->nullable();

            $table->unsignedinteger('priority')->default(0);

            $table->timestamps();
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('document', 'Documentos');
        $permissions_seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('document', 'Documentos');
        $permissions_seeder->delete();

        Schema::dropIfExists('documents');
    }
}
