<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;

use App\Deck;

class MesDecksController extends Controller {

  // Affichage de la vue principale. Aucun deck affiché.
  public function index() {
    $decks = Auth::user()->decks;
    $deckShow = '';
    return view('mes-decks')->with('decks', $decks)->with('deckShow', $deckShow);
  }

  // Appel Ajax pour l'affichage d'un deck
  public function updateDeck() {
    $id = $_GET['id_deck'];
    $deckShow = Deck::find($id);
    $cartesByType = $deckShow->cartes->groupBy('type');

    return view('layouts.deckShow')->with("cartesByType",$cartesByType)->with('deckShow', $deckShow);
  }

}
