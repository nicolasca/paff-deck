<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\PartieLancee;

use App\Http\Helpers\DeckUtils;

use App\PartieEnCours;
use App\Resultat;
use App\User;

class ResultatsController extends Controller {


  public function index(Request $request) {

    $resultats = Resultat::orderBy("created_at")->take(10)->get();

    return view('resultats.resultats')->with("resultats", $resultats);
  }

  public function ajouterResultat(Request $request) {
    $partieId = $request->input("idPartie");
    $partie = PartieEnCours::find($partieId);

    $data = array(
      "J1" => $partie->user_1(),
      "J2" => $partie->user_2(),
      "mode" => $partie->mode
    );

    return view('resultats.resultatEdit')->with("partie", $partie);
  }

  public function create(Request $request) {
    $partieId = $request->input("idPartie");
    $partie = PartieEnCours::find($partieId);
    $resultat = new Resultat();

    $resultat->mode = $partie->mode;
    $resultat->user_1_id = $partie->user_1_id;
    $resultat->user_2_id = $partie->user_2_id;
    $resultat->faction_1_id = $partie->deck_1->faction->id;
    $resultat->faction_2_id = $partie->deck_2->faction->id;
    $resultat->resultat = $request->input("resultat");
    $resultat->type_victoire = $request->input("type");
    if ($resultat->type_victoire ==" points") {
      $resultat->score_1 = $request->input("scoreJ1");
      $resultat->score_2 = $request->input("scoreJ2");
    }
    $resultat->tour = $request->input("tour");

    $resultat->save();
    return redirect()->route('resultats');
  }
}
