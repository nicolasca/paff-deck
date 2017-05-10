<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model {

  private $modes = array(
    "classique" => "Classique",
    "escarmouche" => "Escarmouche",
    "epique" => "Épique"
  );

  protected $table = "deck";

  public $timestamps = false;

  public function user() {
		return $this->belongsTo('App\User');
	}

  public function cartes()
	{
		return $this->belongsToMany('App\Carte', 'deck_carte')->withPivot('nombre');
	}

  public function faction() {
    return $this->belongsTo('App\Faction');
  }

  public function getMode() {
    return $this->modes[$this->mode];
  }

}
