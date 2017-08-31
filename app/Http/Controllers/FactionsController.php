<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Faction;

class FactionsController extends Controller
{

  /**
   * Affiche le classement des arènes
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $factions = Faction::all();
    return view('factions.factions')->with('factions', $factions);
  }

  public function afficherFaction() {
    $id = $_GET['id_faction'];

    $faction = Faction::find($id);

    return view('factions.description-faction')->with('faction', $faction);
  }
}
