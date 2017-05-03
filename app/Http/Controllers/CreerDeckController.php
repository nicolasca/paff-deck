<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;

use App\Deck;
use App\Carte;
use App\Faction;

class CreerDeckController extends Controller {

  // Affichage de la vue principale. Aucun deck affiché.
  public function index() {
    $factions = Faction::all();
    return view('creerDeck')->with('factions', $factions);
  }


  public function createDeck() {

    // Cartes de la faction
    $listeCartesPourFaction = Carte::where("faction_id", $deckShow->faction_id)->get();
    return view('layouts.deckEdit');
  }

  public function afficherFaction() {
    $id = $_GET['id_faction'];

    $faction = Faction::find($id);
    $cartesByType = $faction->cartes->groupBy('type');

    return view('layouts.deckEdit')
    ->with("cartesByType",$cartesByType)
    ->with('faction', $faction);
  }



}
