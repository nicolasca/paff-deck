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
}
