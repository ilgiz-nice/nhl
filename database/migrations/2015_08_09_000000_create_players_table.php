<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('friendly')->index()->unsigned();
            $table->string('name');
            $table->integer('current_team')->unsigned();
            $table->string('num');
            $table->double('height');
            $table->double('weight');
            $table->date('birthday');
            $table->string('role');
            $table->string('hand');
            $table->string('city');
            $table->string('past_teams')->nullable();
            $table->string('photo');
            $table->timestamps();

            $table->foreign('current_team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('players');
    }
}
