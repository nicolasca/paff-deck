<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = "user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function decks() {
      return $this->hasMany('App\Deck');
    }

    public function partiesEnCours() {
      return $this->hasMany('App\PartieEnCours');
    }

    public function isOnline() {
      return Cache::has('user-is-online-' . $this->id);
    }
}
