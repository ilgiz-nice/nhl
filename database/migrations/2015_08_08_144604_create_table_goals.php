<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGoals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id');
            $table->integer('team_id');
            $table->integer('player_id');
            $table->integer('player_goalkeeper_id');
            $table->integer('player_assist_1_id');
            $table->integer('player_assist_2_id')->nullable();
            $table->time('time');
            $table->boolean('bullitt');
            $table->boolean('win_bullitt');
            $table->boolean('win_goal');
            $table->string('disparity')->nullable();
            $table->string('win_composition');
            $table->string('lose_composition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Goals');
    }
}
