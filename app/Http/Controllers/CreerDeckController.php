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

  // Afficher les cartes d'une faction
  public function afficherFaction() {
    $id = $_GET['id_faction'];

    $faction = Faction::find($id);
    $cartesByType = $faction->cartes->groupBy('type');
        $cartesByType = $this->orderArrayByType($cartesByType);

    $recapitulatif = array();
    $recapitulatif["nbCartes"] = 0;
    $recapitulatif["ptsDeploiement"] = 0;
    $recapitulatif["deplacement"] = 0;
    $recapitulatif["recap"] = array();

    return view('layouts.deckEdit')
    ->with("recapitulatif",$recapitulatif)
    ->with("cartesByType",$cartesByType)
    ->with('faction', $faction);
  }

  // Enregistrer un nouveau deck avec les cartes associées
  public function createDeck(Request $request) {

    // Création du deck
    $deck = new Deck();
    $deck->nom = $request->input('nom_deck');
    $deck->description = $request->input('description');
    $deck->mode = $request->input('mode');
    $deck->user_id = Auth::user()->id;
    $deck->faction_id = $request->input('faction_id');
    // On enregistre le deck avant d'y associer des cartes
    $deck->save();

    // Maintenant nous allons associer le deck avec les cartes (table deck_carte)
    // Nous allons itérer sur toutes les cartes de la faction présentes dans le formulaire.
    //  Quand on trouve une carte avec un nombre != 0, on l'ajoute
    foreach ($request->all() as $idCarte => $nombre) {
      //Les input ayant pour 'name' l'id de la carte
      if(is_numeric($idCarte)) {
        //Si on a ajouté la carte au deck
        if ($nombre != 0) {
          $carte = Carte::where("id", $idCarte)->get();
          $deck->cartes()->attach($carte, ['nombre' => $nombre]);
        }
      }
    }
    //If no error, display the show deck view
    return redirect()->back()->with('message', 'Vous avez créé le plus beau deck du monde !!');
  }

  // Trier le tableau par type dans l'ordre de clé suivant:
  // "troupe", "tir", cavalerie, "artillerie", elite, unique, ordre
  public function orderArrayByType($cartesByType) {
    $cartesAvecBonOrdre = array();
    $ordreType = array("troupe", "tir", "cavalerie", "artillerie", "elite", "unique", "ordre");
    foreach ($ordreType as $type) {
      if(isset($cartesByType[$type])) {
        $cartesAvecBonOrdre[$type] = $cartesByType[$type];
      }
    }
    return $cartesAvecBonOrdre;
  }

}
