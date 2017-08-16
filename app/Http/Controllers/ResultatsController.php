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


  // Afficher la liste des résultats
  public function index(Request $request) {
    $resultats = Resultat::orderBy("updated_at", "desc")->take(10)->get();

    return view('resultats.resultats')->with("resultats", $resultats);
  }

  // Quand on clique sur ajout d'un résultat, on redirige vers l'editResultat
  public function ajouterResultat(Request $request) {
    $partieId = $request->input("idPartie");
    $partie = PartieEnCours::find($partieId);

    $resultat = new Resultat();
    $resultat->nom = $partie->nom;
    $resultat->mode = $partie->mode;
    $resultat->user_1_id = $partie->user_1_id;
    $resultat->user_2_id = $partie->user_2_id;
    $resultat->faction_1_id = $partie->deck_1->faction->id;
    $resultat->faction_2_id = $partie->deck_2->faction->id;
    $resultat->tour = $partie->nb_tour;

    return view('resultats.creer-resultat')
    ->with("partie", $partie)
    ->with("resultat", $resultat);
  }

  // Creer et enregistrer un résultat
  public function enregistrer(Request $request) {
    $partieId = $request->input("idPartie");
    $partie = PartieEnCours::find($partieId);
    $resultat = new Resultat();

    $resultat->mode = $partie->mode;
    $resultat->user_1_id = $partie->user_1_id;
    $resultat->user_2_id = $partie->user_2_id;
    $resultat->faction_1_id = $partie->deck_1->faction->id;
    $resultat->faction_2_id = $partie->deck_2->faction->id;
    $resultat->version = config('paff.faqVersion');
    $resultat->resultat = $request->input("resultat");
    $type = $request->input("type");

    if (!empty($type)) {
      $resultat->type_victoire = $request->input("type");
    } else {
      $resultat->type_victoire = null;
    }
    $resultat->tour = $partie->nb_tour;

    $resultat->save();
    return redirect()->route('resultats');
  }

  // Edit d'un résultat déjà existant
  public function afficherEditResultat(Request $request) {
    $resultatId = $request->input("resultatId");
    $resultat = Resultat::find($resultatId);

    return view('resultats.edit-resultat')
    ->with("resultat", $resultat);
  }

  // Sauvegarde d'une maj d'un résultat existant
  public function majResultat(Request $request) {
    $resultatId = $request->input("resultatId");
    $resultat = Resultat::find($resultatId);

    $resultat->resultat = $request->input("resultat");
    $type = $request->input("type");

    if (!empty($type)) {
      $resultat->type_victoire = $request->input("type");
    } else {
      $resultat->type_victoire = null;
    }

    $resultat->save();
    return redirect()->route('resultats');
  }

  // On supprime le résultat
  public function detruireResultat(Request $request) {
    $resultatId = $request->input("resultatId");
    $resultat = Resultat::find($resultatId);

    $resultat->delete();

    return "OK";
  }
}
