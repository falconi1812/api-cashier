<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('players');
            $table->integer('hour_end');
            $table->integer('hour_start');
            $table->date('day');
            $table->integer('type_id')->unsigned();
            $table->integer('terrain_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('type');
            $table->foreign('terrain_id')->references('id')->on('terrain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
