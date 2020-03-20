<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id')->unique();
            $table->decimal('pause_after_exercise');
            $table->decimal('pause_between');
            $table->decimal('pause_practice_1');
            $table->decimal('pause_practice_2');
            $table->decimal('pause_practice_3');
            $table->timestamps();

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
        Schema::dropIfExists('player_settings');
    }
}
