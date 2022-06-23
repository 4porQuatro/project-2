<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotspotTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotspot_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hotspot_id');
            $table->string('locale', 5);

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();

            $table->timestamps();

            $table->unique(['hotspot_id', 'locale']);
            $table->foreign('hotspot_id')->references('id')->on('hotspots')->onDelete('cascade');

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
        Schema::dropIfExists('hotspot_translations');
    }
}
