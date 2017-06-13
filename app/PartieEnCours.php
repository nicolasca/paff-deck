<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartieEnCours extends Model {
  protected $table = "partie_en_cours";

  private $modes = array(
    "classique" => "Classique",
    "escarmouche" => "Escarmouche",
    "epique" => "Épique"
  );

  private $statuts = array(
    "attente_joueur" => "En attente d'un joueur",
    "choix_deck" => "Choix des decks",
    "choix_deploiement" => "Choix des déploiements",
    "en_cours" => "En cours motherfucker"
  );

  public $timestamps = false;

  public function deck_en_cours_1() {
    return $this->belongsTo('App\DeckEnCours');
  }

  public function deck_en_cours_2() {
    return $this->belongsTo('App\DeckEnCours');
  }
  public function user_1() {
    return $this->belongsTo('App\User');
  }
  public function user_2() {
    return $this->belongsTo('App\User');
  }

  public function getStatut() {
    return $this->statuts[$this->statut];
  }

  public function getMode() {
    return $this->modes[$this->mode];
  }
}
