<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
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
            $table->integer('match_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('player_goalkeeper_id')->unsigned();
            $table->integer('player_assist_1_id')->nullable()->unsigned();
            $table->integer('player_assist_2_id')->nullable()->unsigned();
            $table->time('time');
            $table->boolean('bullitt');
            $table->boolean('win_bullitt');
            $table->boolean('win_goal');
            $table->string('disparity')->nullable();
            $table->string('win_composition');
            $table->string('lose_composition');
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('match');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('player_id')->references('friendly')->on('players');
            $table->foreign('player_goalkeeper_id')->references('friendly')->on('players');
            $table->foreign('player_assist_1_id')->references('friendly')->on('players');
            $table->foreign('player_assist_2_id')->references('friendly')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goals');
    }
}