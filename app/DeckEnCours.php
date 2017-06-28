<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeckEnCours extends Model
{
  protected $table = "deck_en_cours";

  public $timestamps = false;

  public function deck() {
    return $this->belongsTo('App\Deck');
  }

  public function cartes_en_cours()
  {
    return $this->hasMany('App\CarteEnCours');
  }
}
