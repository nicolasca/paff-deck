<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultat extends Model {
  protected $table = "resultat";

  private $modes = array(
    "classique" => "Classique",
    "escarmouche" => "Escarmouche",
    "epique" => "Épique"
  );

  private $types = array(
    "controleBase" => "Contrôle des bases",
    "points" => "Points",
    "abandon" => "Abandon"
  );

  private $resultats = array(
    "1" => "Victoire Faction 1",
    "0" => "Match nul",
    "-1" => "Victoire Faction 2"
  );


  public function user_1() {
    return $this->belongsTo('App\User');
  }

  public function user_2() {
    return $this->belongsTo('App\User');
  }

  public function faction_1() {
    return $this->belongsTo('App\Faction');
  }
  public function faction_2() {
    return $this->belongsTo('App\Faction');
  }

  public function getType() {
    return $this->types[$this->type_victoire];
  }

  public function getMode() {
    return $this->modes[$this->mode];
  }

  public function getResultat() {
    return $this->resultats[$this->resultat];
  }

}
