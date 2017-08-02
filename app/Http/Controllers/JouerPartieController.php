<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\DeplacerCarteDefausse;
use App\Events\DragCarteZoneJeu;
use App\Events\PartieLancee;
use App\Events\UpdateInfos;
use App\Events\UpdateEtatCarte;
use App\Events\UpdateZoneDecor;
use App\Events\UpdateCartePiochee;

use App\Http\Helpers\DeckUtils;

use App\PartieEnCours;
use App\Deck;
use App\DeckEnCours;
use App\CarteEnCours;

class JouerPartieController extends Controller {

  // Quand les 2 joueurs ont cliqué sur le lancement de la partie, on affiche la zone de jeu.
  public function zoneJeu(Request $request) {
    $partieId = $_GET['idPartie'];
    $partie = PartieEnCours::find($partieId);
    $partie->statut = "en_cours";
    $partie->save();
    $request->session()->put('partieId', $partieId);

    // Determiner les zones de flancs et de centre
    $positionsParZone = array(
      "flancCoco" => [0,1,9,10,18,19,27,28,36,37,45,46],
      "flancQuetsch" => [7,8,16,17,25,26,34,35,43,44,52,53]
    );

    // Determiner les zones de flancs et de centre
    $delimitationZone = array(2,7,11,16,20,25,29,34,38,43,47,52);

    $cartesRestantesJ1 = $partie->deck_en_cours_1->cartes_en_cours->where("statut", "DECK")->count();
    $cartesRestantesJ2 = $partie->deck_en_cours_2->cartes_en_cours->where("statut", "DECK")->count();

    return view("zone-jeu.zone-jeu")
    ->with('partie', $partie)
    ->with("positionsParZone", $positionsParZone)
    ->with("delimitationZone", $delimitationZone)
    ->with("cartesRestantesJ1", $cartesRestantesJ1)
    ->with("cartesRestantesJ2", $cartesRestantesJ2)
    ;
  }

  // Piocher un carte dans le deck, pour la mettre dans la main
  public function piocher(Request $request) {
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);
    $userId = $request->input('userId');
    $deckEnCours = DeckEnCours::find($partie->getDeckEnCoursIdByUser($userId));

    $cartesEnMain = $deckEnCours->cartes_en_cours->where("statut", "MAIN");
    $cartesEnCoursMain = $deckEnCours->cartes_en_cours->where("statut", "DECK");
    // Si on a moins que 5 cartes en main ET qu'il reste des cartes dans le deck
    if($cartesEnMain->count() < 5 && $cartesEnCoursMain->count() > 0) {
      $cartePioche = $cartesEnCoursMain->random();

      $cartePioche->statut = "MAIN";
      $cartePioche->save();

      //MAJ affichage du nombre cartes restantes
      $cartesRestantesJ1 = $partie->deck_en_cours_1->cartes_en_cours->where("statut", "DECK")->count();
      $cartesRestantesJ2 = $partie->deck_en_cours_2->cartes_en_cours->where("statut", "DECK")->count();

      $data = array(
        "carteId" => $cartePioche->id,
        "id" => $request->input('id'),
        "userId" => $request->input('userId'),
        "cartesRestantesJ1" => $cartesRestantesJ1,
        "cartesRestantesJ2" => $cartesRestantesJ2
      );

      broadcast(new UpdateCartePiochee($data))->toOthers();

      return view('zone-jeu.carte')
      ->with('partie', $partie)
      ->with('userId', $userId)
      ->with('carte', $cartePioche);
    }

    return "KO";
  }

  // Renvoie une carte donnée
  public function getCarteView(Request $request) {
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);

    $carteId = $request->input('carteId');
    $userId = $request->input('userId');
    $cartePioche = CarteEnCours::find($carteId);

    return view('zone-jeu.carte')
    ->with('partie', $partie)
    ->with('userId', $userId)
    ->with('carte', $cartePioche);
  }

  // Quand une carte est drag dans la zone de jeu
  // - on change le statut de la carte
  // - on trigger un event pour le refresh dans le browser
  public function dragCarte() {
    $data = $_GET['data'];
    $carte = CarteEnCours::find($data['carteId']);
    $carte->position = $data['position'];
    $statut = $data['statut'];

    $carte->statut = "ZONE_JEU";
    $carte->save();

    broadcast(new DragCarteZoneJeu($data))->toOthers();
  }

  // Quand une carte est déplacée dans la défausse
  // - on change le statut de la carte
  // - on trigger un event pour le refresh dans le browser
  public function deplacerDefausse() {
    $data = $_GET['data'];
    $carte = CarteEnCours::find($data['carteId']);

    $carte->statut = "DEFAUSSE";
    $carte->save();

    broadcast(new DeplacerCarteDefausse($data))->toOthers();
  }

  // Quand l'état de la carte est modifié (combat, dégats, fuite, moral)
  // - on save en base
  // - on trigger un event pour le refresh dans le browser
  public function updateEtatCarte() {
    $data = $_GET['data'];
    $carteId = explode("_", $data['carteId'])[1];
    $carte = CarteEnCours::find($carteId);

    // Fronts de bataille
    if (isset($data['combat'])) {
      if($data['combat'] == "aucun") {
        $carte->frontHaut = 0;
        $carte->frontBas = 0;
        $carte->frontDroite = 0;
        $carte->frontGauche = 0;
      } else if($data['combat'] == "top") {
        $carte->frontHaut = 1;
      } else if($data['combat'] == "left") {
        $carte->frontGauche = 1;
      } else if($data['combat'] == "bottom") {
        $carte->frontBas = 1;
      } else if($data['combat'] == "right") {
        $carte->frontDroite = 1;
      }
    // Degats
    } else if (isset($data['degats'])) {
        echo typeof($data['degats']);
        $carte->degats = $data['degats'];
    // Moral
    } else if (isset($data['moral'])) {
        $carte->jetMoral =  $data["hasMoral"] == "true" ? 1 : 0;
    // Fuite
    } else if (isset($data['fuite'])) {
        $carte->enFuite = $data["isFuite"] == "true" ? 1 : 0;
    // Flag
    } else if (isset($data['flag'])) {
        $carte->flag = ($data["flag"] == "true") ? 1 : 0;
    }

    $carte->save();

    broadcast(new UpdateEtatCarte($data))->toOthers();
  }

  // Quand on update une zone de décor
  // - on trigger un event pour le refresh dans le browser (non presisté)
  public function updateZoneDecor() {
    $data = $_GET['data'];

    broadcast(new UpdateZoneDecor($data))->toOthers();
  }

  // Quand on update des informations de la partie
  // - on save en base
  // - on trigger un event pour le refresh dans le browser (non presisté)
  public function updateInfos(Request $request) {
    $data = $_GET['data'];
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);

    if($data['type'] == "tour") {
      $partie->nb_tour = $data['valeur'];
    }
    else if($data['type'] == "depl") {
      $partie->depl_J1 = $data['valeurJ1'];
      $partie->depl_J2 = $data['valeurJ2'];
    }

    $partie->save();
    broadcast(new UpdateInfos($data))->toOthers();
  }

}
