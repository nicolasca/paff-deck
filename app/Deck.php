<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
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


}
