<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenaltyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalty', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('penalty_code');
            $table->boolean('penalty_goal');
            $table->integer('goal_id')->unsigned();
            $table->string('duration');
            $table->time('start');
            $table->time('finish');
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('match');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('goal_id')->references('id')->on('goals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('penalty');
    }
}
