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

class PartieController extends Controller {


  public function index(Request $request) {
    $parties = PartieEnCours::all();

    // Creation d'un tableau utilisé pour l'affichage des boutons action
    $boutonAction = [];
    $userId = Auth::user()->id;
    foreach ($parties as $partie) {
      $boutonAction[$partie->id] = "";
      // Afficher le bouton Rejoindre si non créateur de la partie
      if($partie->statut == "attente_joueur" && $partie->user_1_id != $userId) {
        $boutonAction[$partie->id] = "rejoindre";
      }
      // Afficher Choix deck s'il s'agit d'un des deux joueurs
      else if ($partie->statut == "choix_deck" &&
      ($partie->user_1_id == $userId || $partie->user_2_id == $userId)) {
        $boutonAction[$partie->id] = "choix_deck";
      }
      // Afficher Choix déploiement s'il s'agit d'un des deux joueurs
      else if ($partie->statut == "choix_deploiement" &&
      ($partie->user_1_id == $userId || $partie->user_2_id == $userId)) {
        $boutonAction[$partie->id] = "choix_deploiement";
      }
      // Afficher Lancer la partie s'il s'agit d'un des deux joueurs
      else if ($partie->statut == "attente_lancement" &&
      ($partie->user_1_id == $userId || $partie->user_2_id == $userId)) {
        $boutonAction[$partie->id] = "attente_lancement";
      }      // Afficher Lancer la partie s'il s'agit d'un des deux joueurs
      else if ($partie->statut == "en_cours") {
        $boutonAction[$partie->id] = "en_cours";
      }
    }
    return view('parties')->with('parties', $parties)->with("boutonAction", $boutonAction);
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

  // Retourne la vue du choix des cartes pour le deploiement
  public function choixDeck(Request $request) {
    $partie = PartieEnCours::find($request->input('id_partie'));
    $decksByMode = Auth::user()->decks->where("mode", $partie->mode);
    $deckShow = '';

    return view('creation-partie.choix-deck')->with('decksByMode', $decksByMode)
    ->with('deckShow', $deckShow)->with("partie", $partie);
  }

  // Enregistre le choix du deck
  public function saveChoixDeck(Request $request) {
    $userId = Auth::user()->id;
    $deckId = $request->input('deck_id');
    $partie = PartieEnCours::find($request->input('idPartie'));

    // Ajouter le deck id
    if($partie->user_1_id == $userId) {
      $partie->deck_1_id = $deckId;
    } else if ($partie->user_2_id == $userId) {
      $partie->deck_2_id = $deckId;
    }

    //Verifier si les deux joueurs ont choisi leur deck.
    // Si c'est le cas, le statut de la partie change.
    if($partie->deck_1_id != null && $partie->deck_2_id != null) {
      $partie->statut = "choix_deploiement";
    }

    $partie->save();

    return redirect()->route('parties');
  }

  // Retourne la vue du choix des cartes pour le deploiement
  public function choixDeploiement(Request $request) {

    $partie = PartieEnCours::find($request->input('id_partie'));
    $deckId = $partie->getDeckIdByUser(Auth::user()->id);

    $deck = Deck::find($deckId);
    $cartesByType = $deck->cartes->groupBy('type');
    $cartesByType = DeckUtils::orderArrayByType($cartesByType);
    $recapitulatif = DeckUtils::createRecapitulatif($deck);

    return view('creation-partie.choix-deploiement')
    ->with('cartesByType', $cartesByType)
    ->with('recapitulatif', $recapitulatif)
    ->with('deck', $deck)
    ->with("partie", $partie);
  }

  public function saveChoixDeploiement(Request $request) {
    $deck = Deck::find($request->input('deck_id'));
    $partie = PartieEnCours::find($request->input('idPartie'));

    $deckEnCours = new DeckEnCours;
    $deckEnCours->deck_id = $deck->id;
    $deckEnCours->partie_en_cours_id = $partie->id;
    $deckEnCours->save();

    $cartesDeck = array();
    $cartesTableJeu = array();

    // Pour la liste des cartes du deck, on va creer des clés unique:
    // key="carteId_numeroExemplaire"
    foreach ($deck->cartes as $carte) {
      for ($i=0; $i < $carte->pivot->nombre; $i++) {
        $key = $carte->id."_".$i;
        $cartesDeck[$key] = $carte;
      }
    }

    // On récupère la valeur des inputs pour créer le deploiement de base
    foreach ($request->all() as $idCarte => $nombre) {
      //Les input ayant pour 'name' l'id de la carte
      if(is_numeric($idCarte)) {
        for ($i=0; $i < $nombre; $i++) {
          // Si la carte est choisie -> dans les cartes table de jeu
          $key = $idCarte."_".$i;
          $cartesTableJeu[$key] = $cartesDeck[$key];
          unset($cartesDeck[$key]);
        }
      }
    }

    // Save des cartes en cours dans le deck
    foreach ($cartesDeck as $identifiant => $carte) {
      $carteEnCours = new carteEnCours;
      $carteEnCours->carte_id = $carte->id;
      $carteEnCours->deck_en_cours_id = $deckEnCours->id;
      $carteEnCours->identifiant_partie = $identifiant;
      $carteEnCours->statut = "DECK";
      $carteEnCours->save();
    }

    // Save des cartes de jeu dans le déploiement
    foreach ($cartesTableJeu as $identifiant => $carte) {
      $carteEnCours = new carteEnCours;
      $carteEnCours->carte_id = $carte->id;
      $carteEnCours->deck_en_cours_id = $deckEnCours->id;
      $carteEnCours->identifiant_partie = $identifiant;
      $carteEnCours->statut = "DEPLOIEMENT";
      $carteEnCours->save();
    }

    $userId = Auth::user()->id;

    // Sauvegarder le deck en cours à la partie
    if($partie->user_1_id == $userId) {
      $partie->deck_en_cours_1_id = $deckEnCours->id;
    } else if ($partie->user_2_id == $userId) {
      $partie->deck_en_cours_2_id = $deckEnCours->id;
    }

    //Verifier si les deux joueurs ont choisi leur deploiement.
    // Si c'est le cas, le statut de la partie change.
    if($partie->deck_en_cours_1_id != null && $partie->deck_en_cours_2_id != null) {
      $partie->statut = "attente_lancement";
    }
    $partie->save();

    return redirect()->route('parties');
  }


  public function recapAvantPartie($id) {
    $partie = PartieEnCours::find($id);

    return view('creation-partie.recap-avant-partie')
    ->with('partie', $partie);
  }

  // Quand un joueur click sur le bouton pour lancer la partie
  public function lancerPartie() {
    $partieId = $_GET['idPartie'];
    broadcast(new PartieLancee($partieId))->toOthers();
  }

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

    return view("zone-jeu.zone-jeu")->with('partie', $partie)->with("positionsParZone", $positionsParZone);
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

      $data = array(
        "carteId" => $cartePioche->id,
        "id" => $request->input('id'),
        "userId" => $request->input('userId'),
      );

      broadcast(new UpdateCartePiochee($data))->toOthers();

      return view('zone-jeu.carte')
      ->with('partie', $partie)
      ->with('userId', $userId)
      ->with('carte', $cartePioche);
    }

    return "KO";
  }

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
  // - on trigger un event pour le refresh dans le browser (non presisté)
  public function updateEtatCarte() {
    $data = $_GET['data'];
    $carteId = explode("_", $data['carteId'])[1];
    $carte = CarteEnCours::find($carteId);

    broadcast(new UpdateEtatCarte($data))->toOthers();
  }

  // Quand on update une zone de décor
  // - on trigger un event pour le refresh dans le browser (non presisté)
  public function updateZoneDecor() {
    $data = $_GET['data'];

    broadcast(new UpdateZoneDecor($data))->toOthers();
  }

  // Quand les dés sont lancés
  // - on trigger un event pour le refresh dans le browser (non presisté)
  public function updateInfos() {
    $data = $_GET['data'];
    broadcast(new UpdateInfos($data))->toOthers();
  }

  // On supprime la partie, ainsi que les cartes et decks en cours associés
  public function detruirePartie(Request $request) {
    $partieId = $request->input("partieId");
    $partie = PartieEnCours::find($partieId);

    $partie->cartes_en_cours()->delete();
    $partie->decks_en_cours()->delete();
    $partie->delete();

    return "OK";
  }

}
