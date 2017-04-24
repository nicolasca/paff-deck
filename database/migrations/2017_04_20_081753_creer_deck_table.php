<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreerDeckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100)->unique();
            $table->mediumText('description');
            $table->integer('fk_user_id')->unsigned();
            $table->integer('fk_faction_id')->unsigned();

            $table->foreign('fk_user_id')->references('id')->on('user');
            $table->foreign('fk_faction_id')->references('id')->on('faction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deck');
    }
}
