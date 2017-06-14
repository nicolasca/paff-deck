<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\PartieLancee;

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
      if($partie->statut === "attente_joueur" && $partie->user_1_id !== $userId) {
        $boutonAction[$partie->id] = "rejoindre";
      }
      // Afficher Choix deck s'il s'agit d'un des deux joueurs
      else if ($partie->statut === "choix_deck" &&
      ($partie->user_1_id === $userId || $partie->user_2_id === $userId)) {
        $boutonAction[$partie->id] = "choix_deck";
      }
      // Afficher Choix déploiement s'il s'agit d'un des deux joueurs
      else if ($partie->statut === "choix_deploiement" &&
      ($partie->user_1_id === $userId || $partie->user_2_id === $userId)) {
        $boutonAction[$partie->id] = "choix_deploiement";
      }
      // Afficher Lancer la partie s'il s'agit d'un des deux joueurs
      else if ($partie->statut === "attente_lancement" &&
      ($partie->user_1_id === $userId || $partie->user_2_id === $userId)) {
        $boutonAction[$partie->id] = "attente_lancement";
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
    if($partie->user_1_id === $userId) {
      $partie->deck_1_id = $deckId;
    } else if ($partie->user_2_id === $userId) {
      $partie->deck_2_id = $deckId;
    }

    //Verifier si les deux joueurs ont choisi leur deck.
    // Si c'est le cas, le statut de la partie change.
    if($partie->deck_1_id !== null && $partie->deck_2_id !== null) {
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
    // Genere la main de depart
    $cartesMain = array();
    for($i=0; $i < 5; $i++){
      $key = array_rand($cartesDeck);
      $carte = $cartesDeck[$key];
      unset($cartesDeck[$key]);
      $cartesMain[$key] = $carte;
    }

    // Save des cartes en cours dans le deck
    foreach ($cartesDeck as $identifiant => $carte) {
      $carteEnCours = new carteEnCours;
      $carteEnCours->carte_id = $carte->id;
      $carteEnCours->identifiant_partie = $identifiant;
      $carteEnCours->statut = "DECK";
      $carteEnCours->save();

      $deckEnCours->cartesEnCours()->attach($carteEnCours);
    }

    // Save des cartes en cours dans la zone de jeu
    foreach ($cartesTableJeu as $identifiant => $carte) {
      $carteEnCours = new carteEnCours;
      $carteEnCours->carte_id = $carte->id;
      $carteEnCours->identifiant_partie = $identifiant;
      $carteEnCours->statut = "ZONE_JEU";
            $carteEnCours->save();

      $deckEnCours->cartesEnCours()->attach($carteEnCours);
    }

    // Save des cartes en cours dans la zone de jeu
    foreach ($cartesMain as $identifiant => $carte) {
      $carteEnCours = new carteEnCours;
      $carteEnCours->carte_id = $carte->id;
      $carteEnCours->identifiant_partie = $identifiant;
      $carteEnCours->statut = "MAIN";
      $carteEnCours->save();

      $deckEnCours->cartesEnCours()->attach($carteEnCours);
    }

    $userId = Auth::user()->id;

    // Sauvegarder le deck en cours à la partie
    if($partie->user_1_id === $userId) {
      $partie->deck_en_cours_1_id = $deckEnCours->id;
    } else if ($partie->user_2_id === $userId) {
      $partie->deck_en_cours_2_id = $deckEnCours->id;
    }

    //Verifier si les deux joueurs ont choisi leur deploiement.
    // Si c'est le cas, le statut de la partie change.
    if($partie->deck_en_cours_1_id !== null && $partie->deck_en_cours_2_id !== null) {
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
    event(new PartieLancee($partieId)); // broadcast `ScoreUpdated` event
  }

  // Quand les 2 joueurs ont cliqué sur le lancement de la partie, on affiche la zone de jeu.
  public function zoneJeu() {
    $partieId = $_GET['idPartie'];
    return view("zone-jeu.zone-jeu");
  }

}
