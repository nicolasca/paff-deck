<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Deck;
use App\Faction;
use Auth;

class ProfilController extends Controller
{

    /**
     * Affiche la page profil d'un user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId) {
      $user = User::find($userId);
      $nbDecks = Deck::where('user_id',$userId)->count();

      return view('profil')
        ->with("user", $user)
        ->with("nbDecks", $nbDecks);
    }

    public function getChartData($userId) {
      $decks = Deck::all()->where('user_id', $userId)->groupBy("faction_id");

      $deckGroupByFactionName = array();
      foreach ($decks as $key => $value) {
        $faction = Faction::find($key);
        $deckGroupByFactionName[$faction->nom] = $value;
      }

      return $deckGroupByFactionName;
    }
}
