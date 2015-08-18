<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id');
            $table->integer('num');
            $table->string('stage');
            $table->string('status');
            $table->date('date');
            $table->time('start');
            $table->time('finish');
            $table->integer('home_id');
            $table->integer('guest_id');
            $table->integer('audience');
            $table->string('home_participants');
            $table->string('guest_participants');
            $table->integer('home_goals');
            $table->integer('guest_goals');
            $table->integer('win_main_time')->nullable();
            $table->integer('win_additional_time')->nullable();
            $table->integer('lose_main_time')->nullable();
            $table->integer('lose_additional_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Match');
    }
}
