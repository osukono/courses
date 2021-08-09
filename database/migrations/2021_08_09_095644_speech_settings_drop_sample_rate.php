<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpeechSettingsDropSampleRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speech_settings', function (Blueprint $table) {
            $table->dropColumn('sample_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('speech_settings', function (Blueprint $table) {
            $table->integer('sample_rate')->after('voice_name')->default(0);
        });
    }
}
