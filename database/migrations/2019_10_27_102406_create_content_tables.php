<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
            $table->timestamps();
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('data_type_id');
            $table->string('identifier')->unique();
            $table->string('name')->unique();
            $table->boolean('translatable');
            $table->boolean('audible');
            $table->timestamps();

            $table->foreign('data_type_id')->references('id')->on('data_types');
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('level_id');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['language_id', 'level_id'], 'contents_unique');

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('level_id')->references('id')->on('levels');
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('content_id');
            $table->string('uuid');
            $table->string('title');
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('content_id')->references('id')->on('contents');
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_id');
            $table->json('properties')->default(new Expression('(JSON_ARRAY())'));
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('lessons');
        });

        Schema::create('exercise_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exercise_id');
            $table->unsignedBigInteger('field_id');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exercise_id')->references('id')->on('exercises');
            $table->foreign('field_id')->references('id')->on('fields');
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exercise_field_id');
            $table->unsignedBigInteger('language_id');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();

            $table->foreign('exercise_field_id')->references('id')->on('exercise_fields');
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
        Schema::dropIfExists('translations');
        Schema::dropIfExists('exercise_fields');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('field');
        Schema::dropIfExists('data_types');
    }
}
