<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisabledContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disabled_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('disabled');
            $table->unsignedBigInteger('language_id');
            $table->timestamps();

            $table->primary(['disabled_type', 'disabled_id', 'language_id']);

            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disabled_content');
    }
}
