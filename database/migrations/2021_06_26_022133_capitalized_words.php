<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CapitalizedWords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
           $table->text('capitalized_words')->nullable()->after('slug');
        });

        Schema::table('contents', function (Blueprint $table) {
           $table->text('capitalized_words')->nullable()->after('review_exercises');
        });

        Schema::table('courses', function (Blueprint $table) {
           $table->text('capitalized_words')->nullable()->after('audio_storage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('courses', ['capitalized_words']);
        Schema::dropColumns('contents', ['capitalized_words']);
        Schema::dropColumns('languages', ['capitalized_words']);
    }
}
