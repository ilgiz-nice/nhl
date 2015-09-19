<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenaltyShotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalty_shots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('goal_id')->unsigned();
            $table->integer('num');
            $table->string('home_score');
            $table->string('guest_score');
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
        Schema::drop('penalty_shots');
    }
}
