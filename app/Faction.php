<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $table = "faction";

    public $timestamps = false;

    public function cartes()
    {
    return $this->hasMany('App\Carte');
    }
}
