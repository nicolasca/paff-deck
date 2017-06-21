<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarteEnCours extends Model
{
  protected $table = "carte_en_cours";

  public $timestamps = false;

  public function carte() {
    return $this->belongsTo('App\Carte');
  }

  public function decksEnCours() {
  return $this->belongsToMany('App\DeckEnCours', 'deck_carte_en_cours');
}
}
