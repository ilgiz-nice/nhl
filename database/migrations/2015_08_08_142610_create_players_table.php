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
            $table->string('name');
            $table->integer('current');
            $table->double('height');
            $table->double('weight');
            $table->date('birthday');
            $table->string('role');
            $table->string('hand');
            $table->string('city');
            $table->string('past_teams')->nullable();
            $table->string('photo');
<<<<<<< HEAD
            $table->timestamps();
=======
>>>>>>> f3ebb7fae61eb54b7013985d422aa4ddc691a024
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
