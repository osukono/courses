<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('translation_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('topic_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('major_version');
            $table->unsignedInteger('minor_version');
            $table->unsignedInteger('player_version')->default(0);
            $table->string('image')->nullable();
            $table->integer('review_exercises')->default(0);
            $table->string('audio_storage')->nullable();
            $table->string('firebase_id')->nullable()->unique();
            $table->boolean('is_updating')->default(true);
            $table->timestamps();
            $table->timestamp('committed_at')->nullable();
            $table->timestamp('uploaded_at')->nullable();

            $table->unique(['language_id', 'translation_id', 'level_id', 'topic_id', 'major_version'], 'firebase_courses_unique');

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('translation_id')->references('id')->on('translations');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('topic_id')->references('id')->on('topics');
        });

        Schema::create('course_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->string('title');
            $table->integer('exercises_count');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->integer('index');
            $table->timestamps();

            $table->unique(['course_id', 'index'], 'course_lessons_unique');

            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_lessons');
        Schema::dropIfExists('courses');
    }
}
