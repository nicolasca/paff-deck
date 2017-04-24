<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreerDeckCarteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck_carte', function (Blueprint $table) {
            $table->primary(['carte_id', 'deck_id']);
            $table->integer('carte_id')->unsigned();
            $table->integer('deck_id')->unsigned();
            $table->integer('nombre');

            $table->foreign('carte_id')->references('id')->on('carte');
            $table->foreign('deck_id')->references('id')->on('deck');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deck_carte');
    }
}
