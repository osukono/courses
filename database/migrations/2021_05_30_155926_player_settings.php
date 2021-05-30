<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_settings', function(Blueprint $table) {
           $table->renameColumn('pause_between', 'listening_rate');
           $table->renameColumn('pause_practice_1', 'practice_rate');
           $table->dropColumn('pause_practice_2');
           $table->dropColumn('pause_practice_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_settings', function(Blueprint $table) {
           $table->renameColumn('listening_rate', 'pause_between');
           $table->renameColumn('practice_rate', 'pause_practice_1');
           $table->decimal('pause_practice_2');
           $table->decimal('pause_practice_3');
        });
    }
}
