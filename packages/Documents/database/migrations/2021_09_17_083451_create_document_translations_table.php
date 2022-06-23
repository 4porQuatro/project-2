<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('document_id');
            $table->string('locale', 5);

            $table->string('name');

            $table->timestamps();

            $table->unique(['document_id', 'locale']);
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_translations');
    }
}
