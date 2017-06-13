<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
  protected $table = "partie";

  public $timestamps = false;

  public function deck_1() {
    return $this->belongsTo('App\Deck');
  }

  public function deck_2() {
    return $this->belongsTo('App\Deck');
  }
}
