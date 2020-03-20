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
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('native');
            $table->string('code')->unique();
            $table->string('icon')->nullable();
            $table->string('slug');
            $table->string('firebase_id')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('scale')->unique();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier')->unique();
            $table->string('name')->unique();
            $table->string('firebase_id')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('topic_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('version');
            $table->integer('player_version')->default(0);
            $table->integer('review_exercises')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['language_id', 'level_id', 'topic_id', 'version'], 'courses_unique');

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('topic_id')->references('id')->on('topics');
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('content_id');
            $table->string('title');
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('content_id')->references('id')->on('contents');
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_id');
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('lessons');
        });

        Schema::create('exercise_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exercise_id');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->boolean('translatable')->default(true);
            $table->integer('index');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exercise_id')->references('id')->on('exercises');
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exercise_data_id');
            $table->unsignedBigInteger('language_id');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->foreign('exercise_data_id')->references('id')->on('exercise_data');
            $table->foreign('language_id')->references('id')->on('languages');
        });

        Schema::create('disabled_content', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id');
            $table->morphs('disabled');
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
        Schema::dropIfExists('translations');
        Schema::dropIfExists('exercise_data');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('languages');
    }
}
