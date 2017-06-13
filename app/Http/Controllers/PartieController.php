<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\PartieCreated;

use App\PartieEnCours;


class PartieController extends Controller {


  public function index(Request $request) {
    $parties = PartieEnCours::all();
    return view('parties', compact('parties'));
  }

  public function create(Request $request) {
    // Création du deck
    $partie = new PartieEnCours();
    $partie->statut = "attente_joueur";
    $partie->user_1_id = Auth::user()->id;
    $partie->nom = $request->input('nom_partie');
    $partie->mode = $request->input('mode_partie');

    $partie->save();
    return redirect()->route('parties');
  }

  public function rejoindrePartie($id) {
    $partie = PartieEnCours::find($id);
    $partie->user_2_id = Auth::user()->id;
    $partie->statut = "choix_deck";
    $partie->save();

    return redirect()->route('parties');
  }

  public function choixDeck($id) {
    $partie = PartieEnCours::find($id);
    $decksByMode = Auth::user()->decks->where("mode", $partie->mode);
    $deckShow = '';

    return view('creation-partie.choix-deck')->with('decksByMode', $decksByMode)
    ->with('deckShow', $deckShow);
  }

}
