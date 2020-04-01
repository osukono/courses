<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocaleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locale_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('app_locales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('locale_group_id')->nullable();
            $table->string('description')->nullable();
            $table->string('key')->unique();
            $table->json('values')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();

            $table->foreign('locale_group_id')->references('id')->on('locale_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locale_keys');
        Schema::dropIfExists('locale_tables');
    }
}
