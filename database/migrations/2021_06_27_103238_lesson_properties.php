<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LessonProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('lesson_images', 'lesson_properties');

        Schema::table('lesson_properties', function (Blueprint $table) {
            $table->text('grammar_point')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('lesson_properties', 'grammar_point');
        Schema::rename('lesson_properties', 'lesson_images');
    }
}
