<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
  protected $table = "carte";

  public $timestamps = false;


  public function decks() {
  return $this->belongsToMany('App\Deck', 'deck_carte')->withPivot('nombre');
}

  public function faction() {
    return $this->belongsTo('App\Faction');
  }

}
