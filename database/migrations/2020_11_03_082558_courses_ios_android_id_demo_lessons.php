<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoursesIosAndroidIdDemoLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('android_product_id')->nullable()->after('review_exercises');
            $table->string('ios_product_id')->nullable()->after('android_product_id');
            $table->integer('demo_lessons')->default(0)->after('ios_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('android_product_id');
            $table->dropColumn('ios_product_id');
            $table->dropColumn('demo_lessons');
        });
    }
}
