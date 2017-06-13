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

  public function create() {
    // Création du deck
    $partie = new PartieEnCours();
    $partie->statut = "attente_joueur";
    $partie->user_1_id = Auth::user()->id;
    
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

}
