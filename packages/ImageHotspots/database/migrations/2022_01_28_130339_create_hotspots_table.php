<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotspotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotspots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotspot_image_id');

            $table->json('coordinates');

            $table->json('images')->nullable();
            $table->json('images_detail')->nullable();
            $table->unsignedinteger('priority')->default(0);

            $table->timestamps();

            $table->foreign('hotspot_image_id')->references('id')->on('hotspot_images')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotspots');
    }
}
