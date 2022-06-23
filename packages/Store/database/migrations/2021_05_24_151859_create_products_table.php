<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('attribute_family_id')->nullable();

            $table->string('sku')->nullable();
            $table->string('ref')->nullable();

            $table->boolean('default_layout')->default(true);
            $table->bigInteger('layout_id')->unsigned()->nullable();

            $table->json('images')->nullable();
            $table->json('images_detail')->nullable();
            $table->json('docs')->nullable();
            $table->json('videos')->nullable();

            $table->double('price', 8, 2)->nullable();
            $table->double('promoted_price', 8, 2)->nullable();

            $table->integer('stock')->nullable();

            $table->boolean('has_variants')->default(false);

            $table->unsignedinteger('priority')->default(0);

            $table->timestamps();

            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('attribute_family_id')->references('id')->on('attribute_families')->onDelete('cascade');
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('product', 'Produtos');
        $permissions_seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('product', 'Produtos');
        $permissions_seeder->delete();

        Schema::dropIfExists('products');
    }
}
