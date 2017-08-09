<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Deck;
use App\Faction;
use Auth;

class MembresController extends Controller
{

    /**
     * Affiche la page profil d'un user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
      $users = User::all()->where("userTest", 0);

      return view('membres')
        ->with("users", $users);
    }

}
