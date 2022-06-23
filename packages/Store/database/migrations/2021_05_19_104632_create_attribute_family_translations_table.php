<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFamilyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_family_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('attribute_family_id');
            $table->string('locale', 5);

            $table->string('title');

            $table->timestamps();

            $table->unique(['attribute_family_id', 'locale']);
            $table->foreign('attribute_family_id')->references('id')->on('attribute_families')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_family_translations');
    }
}
