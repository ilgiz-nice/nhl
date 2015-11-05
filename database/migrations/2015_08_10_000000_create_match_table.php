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
            $table->integer('season_id')->unsigned();
            $table->integer('num');
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->date('date');
            $table->time('start')->nullable();
            $table->time('finish')->nullable();
            $table->integer('home_id')->unsigned();
            $table->integer('guest_id')->unsigned();
            $table->integer('audience')->nullable();
            $table->string('home_participants')->nullable();
            $table->string('guest_participants')->nullable();
            $table->integer('home_goals')->nullable();
            $table->integer('guest_goals')->nullable();
            $table->integer('win_main_time')->nullable();
            $table->integer('win_additional_time')->nullable();
            $table->integer('win_bullitt')->nullable();
            $table->integer('lose_main_time')->nullable();
            $table->integer('lose_additional_time')->nullable();
            $table->integer('lose_bullitt')->nullable();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons');
            $table->foreign('home_id')->references('id')->on('teams');
            $table->foreign('guest_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match');
    }
}
