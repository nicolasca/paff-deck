<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreerEnCoursTables extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('partie', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nom', 50);
      $table->dateTime('date');
      $table->enum('mode', ['classique', 'escarmouche', 'epique']);
      $table->integer('deck_1_id')->unsigned();
      $table->integer('deck_2_id')->unsigned();
      $table->integer('score_1');
      $table->integer('score_2');

      $table->foreign('deck_1_id')->references('id')->on('deck');
      $table->foreign('deck_2_id')->references('id')->on('deck');
    });

    Schema::create('deck_en_cours', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('deck_id')->unsigned();
      $table->integer('partie_en_cours_id')->unsigned();

      $table->foreign('deck_id')->references('id')->on('deck');
    });

    Schema::create('carte_en_cours', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('carte_id')->unsigned();
      $table->integer('deck_en_cours_id')->unsigned();
      $table->string('identifiant_partie', 20);
      $table->integer('position')->nullable();
      $table->enum('statut', ['MAIN', 'DEPLOIEMENT', 'ZONE_JEU', 'DECK', 'DEFAUSSE'])->nullable();

      $table->foreign('carte_id')->references('id')->on('carte');
    });

    Schema::create('partie_en_cours', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nom', 50);
      $table->integer('user_1_id')->nullable()->unsigned();
      $table->integer('user_2_id')->nullable()->unsigned();
      $table->integer('deck_1_id')->nullable()->unsigned();
      $table->integer('deck_2_id')->nullable()->unsigned();
      $table->integer('deck_en_cours_1_id')->nullable()->unsigned();
      $table->integer('deck_en_cours_2_id')->nullable()->unsigned();
      $table->enum('mode', ['classique', 'escarmouche', 'epique']);
      $table->enum('statut', ['attente_joueur', 'choix_deck', 'choix_deploiement', 'attente_lancement', 'en_cours']);

      $table->foreign('deck_en_cours_1_id')->references('id')->on('deck_en_cours')->onDelete('cascade');;
      $table->foreign('deck_en_cours_2_id')->references('id')->on('deck_en_cours')->onDelete('cascade');;
      $table->foreign('deck_1_id')->references('id')->on('deck');
      $table->foreign('deck_2_id')->references('id')->on('deck');
      $table->foreign('user_1_id')->references('id')->on('user');
      $table->foreign('user_2_id')->references('id')->on('user');
    });

    Schema::table('deck_en_cours', function($table) {
      $table->foreign('partie_en_cours_id')->references('id')->on('partie_en_cours');
  });
  Schema::table('carte_en_cours', function($table) {
      $table->foreign('deck_en_cours_id')->references('id')->on('deck_en_cours')->onDelete('cascade');
});

  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('partie_en_cours');
    Schema::drop('deck_en_cours');
    Schema::drop('carte_en_cours');
    Schema::drop('partie');
  }
}
