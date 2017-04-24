<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreerCarteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carte', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100)->unique();
            $table->enum('type', ['troupe', 'tir', 'cavalerie', 'artillerie','elite', 'unique', 'ordre']);
            $table->integer('nombre_max');
            $table->integer('armure');
            $table->integer('cout_deploiement');
            $table->integer('deplacement');
            $table->integer('regiment');
            $table->integer('moral');
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carte');
    }
}
