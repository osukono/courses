<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoursesAddAdMobBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function(Blueprint $table) {
            $table->string('ad_mob_banner_unit_id_android')->nullable()->after('ios_product_id');
            $table->string('ad_mob_banner_unit_id_ios')->nullable()->after('ad_mob_banner_unit_id_android');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('courses', [
            'ad_mob_banner_unit_id_android',
            'ad_mob_banner_unit_id_ios'
        ]);
    }
}
