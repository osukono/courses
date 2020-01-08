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
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('demo_lessons')->default(0);
            $table->decimal('price')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamps();

            $table->unique(['language_id', 'translation_id', 'level_id'], 'courses_unique');

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('translation_id')->references('id')->on('languages');
            $table->foreign('level_id')->references('id')->on('levels');
        });

        Schema::create('course_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::create('course_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_content_id');
            $table->string('title');
            $table->integer('number');
            $table->string('uuid');
            $table->string('checksum');
            $table->integer('exercises_count');
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();

            $table->foreign('course_content_id')->references('id')->on('course_contents');
        });

        Schema::create('user_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->boolean('demo')->default(true);
            $table->json('progress')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('course_contents');
        Schema::dropIfExists('courses');
    }
}
