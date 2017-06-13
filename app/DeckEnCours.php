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

  public function cartesEnCours()
  {
    return $this->belongsToMany('App\CarteEnCours', 'deck_carte_en_cours');
  }
}
