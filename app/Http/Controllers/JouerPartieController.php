<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\DeplacerCarteDefausse;
use App\Events\DragCarteZoneJeu;
use App\Events\CarteDeployee;
use App\Events\PartieLancee;
use App\Events\UpdateInfos;
use App\Events\UpdateEtatCarte;
use App\Events\UpdateZoneDecor;
use App\Events\UpdateCartePiochee;
use App\Events\UpdatePhase;

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

    //Affichage des zones décor
    $arrayDecors = json_decode($partie->zones_decor, true);

    return view("zone-jeu.zone-jeu")
    ->with('partie', $partie)
    ->with("positionsParZone", $positionsParZone)
    ->with("delimitationZone", $delimitationZone)
    ->with("cartesRestantesJ1", $cartesRestantesJ1)
    ->with("cartesRestantesJ2", $cartesRestantesJ2)
    ->with("zonesDecors", $arrayDecors)
    ;
  }

  // Pioche les cartes decors pour chaque joueur, et renvoie 2 tableaux avec les valeurs
  public function piocherCarteDecor(Request $request) {
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);

    $decorJ1 = $decorJ2 = "";

    // 2 cartes pour le mode classique, 1 carte pour le mode escarmouche
    $nombreDecorsParJoueur = $partie->mode == "classique" ? 2 : 1;
    // Liste des cartes decors pour le tirage au sort
    $cartesDecor = ["foret","foret","foret","foret","lac","lac","lac","lac",
                    "ruines","ruines","ruines","ruines","colline","colline","colline","colline"];

    shuffle($cartesDecor);
    $decorJ1 = array_slice($cartesDecor, 0, $nombreDecorsParJoueur);
    $decorJ2 = array_slice($cartesDecor, $nombreDecorsParJoueur, $nombreDecorsParJoueur);

    $partie->phase = "deploiement";
    $partie->save();

    $data = array(
      "type" => "decor",
      "decorJ1" => $decorJ1,
      "decorJ2" => $decorJ2
    );
    broadcast(new UpdateInfos($data))->toOthers();

    return $data;

  }

  // MAJ de la phase de la partie (decor, deploiement, combat)
  public function updatePhase(Request $request) {
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);
    $partie->phase = $_POST['phase'];
    $partie->save();

    broadcast(new UpdatePhase(array($_POST['phase'])))->toOthers();

    return array($_POST['phase']);
  }

  // Piocher un carte dans le deck, pour la mettre dans la main
  public function piocher(Request $request) {
    $data = $_POST['data'];
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);
    $userId = $data['userId'];
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
        "id" => $data['id'],
        "userId" => $data['userId'],
        "cartesRestantesJ1" => $cartesRestantesJ1,
        "cartesRestantesJ2" => $cartesRestantesJ2
      );

      broadcast(new UpdateCartePiochee($data))->toOthers();

      return $data;
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
    $data = $_POST['data'];
    $carte = CarteEnCours::find($data['carteId']);
    $carte->position = $data['position'];
    $statut = $data['statut'];

    $carte->statut = "ZONE_JEU";
    $carte->save();

    broadcast(new DragCarteZoneJeu($data))->toOthers();

    return $data;
  }

  // Quand une carte est depl dans la zone de jeu
  // - on change le statut de la carte
  // - on trigger un event pour le refresh dans le browser
  public function deployerCarte() {
    $data = $_POST['data'];
    $carte = CarteEnCours::find($data['carteId']);
    $carte->position = $data['position'];
    $statut = $data['statut'];

    $carte->statut = "ZONE_JEU";
    $carte->save();

    broadcast(new CarteDeployee($data))->toOthers();

    return $data;
  }

  // Quand une carte est déplacée dans la défausse
  // - on change le statut de la carte
  // - on trigger un event pour le refresh dans le browser
  public function deplacerDefausse() {
    $data = $_POST['data'];
    $carte = CarteEnCours::find($data['carteId']);

    $carte->statut = "DEFAUSSE";
    $carte->save();

    broadcast(new DeplacerCarteDefausse($data))->toOthers();

    return $data;
  }

  // Quand l'état de la carte est modifié (combat, dégats, fuite, moral)
  // - on save en base
  // - on trigger un event pour le refresh dans le browser
  public function updateEtatCarte() {
    $data = $_POST['data'];
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
        $carte->frontHaut = ($carte->frontHaut == 0) ? 1 : 0;
      } else if($data['combat'] == "left") {
        $carte->frontGauche = ($carte->frontGauche == 0) ? 1 : 0;
      } else if($data['combat'] == "bottom") {
      $carte->frontBas = ($carte->frontBas == 0) ? 1 : 0;
      } else if($data['combat'] == "right") {
        $carte->frontDroite = ($carte->frontDroite == 0) ? 1 : 0;
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

    return $data;
  }

  // Quand on update une zone de décor
  // - on l'enregistre en json dans la bdd
  // - on trigger un event pour le refresh dans le browser
  public function updateZoneDecor(Request $request) {
    $data = $_POST['data'];
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);

    // On sauvegarde en BDD
    $arrayDecors = json_decode($partie->zones_decor, true);

    if($data["decor"] == "none") {
      unset($arrayDecors[$data["zoneJeu"]]);
    } else {
      $arrayDecors[$data["zoneJeu"]] = $data["decor"];
    }
    $partie->zones_decor = json_encode($arrayDecors);
    $partie->save();

    broadcast(new UpdateZoneDecor($data))->toOthers();

    return $data;
  }

  // Quand on update des informations de la partie
  // - on save en base
  // - on trigger un event pour le refresh dans le browser
  public function updateInfos(Request $request) {
    $data = $_POST['data'];
    $partieId = $request->session()->get('partieId');
    $partie = PartieEnCours::find($partieId);

    if($data['type'] == "tour") {
      $partie->nb_tour = $data['valeur'];
    }
    else if($data['type'] == "depl") {
      $partie->depl_J1 = $data['valeurJ1'];
      $partie->depl_J2 = $data['valeurJ2'];
    } else if ($data['type'] == "dice") {
      $data['joueur'] = Auth::user()->name;
    }

    $partie->save();
    broadcast(new UpdateInfos($data))->toOthers();

    return $data;
  }

}
