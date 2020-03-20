<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeechSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speech_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('content_id');
            $table->unsignedBigInteger('language_id');
            $table->string('voice_name');
            $table->integer('sample_rate');
            $table->decimal('speaking_rate');
            $table->decimal('pitch');
            $table->decimal('volume_gain_db');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speech_settings');
    }
}
