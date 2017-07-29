<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Auth;

use App\Http\Helpers\DeckUtils;
use App\Deck;
use App\Carte;
use App\Faction;
use App\DeckEnJeu;

class JouerDeckController extends Controller {


  // Retourne la vue pour le choix du deck

  public function index() {
    $decksByMode = Auth::user()->decks->groupBy("mode");
    $deckShow = '';

    return view('jouerDeck.choix-deck')->with('decksByMode', $decksByMode)
    ->with('deckShow', $deckShow);
  }

  // Retourne la vue du choix des cartes pour le deploiement
  public function choixDeploiement(Request $request) {
    $deck = Deck::find($request->input('deck_id'));
    $cartesByType = $deck->cartes->groupBy('type');
    $cartesByType = $this->orderArrayByType($cartesByType);
    $recapitulatif = DeckUtils::createRecapitulatif($deck);

    return view('jouerDeck.choix-deploiement')
    ->with('cartesByType', $cartesByType)
    ->with('recapitulatif', $recapitulatif)
    ->with('deck', $deck);
  }

  // Afficher le deploiement de départ ainsi que le deck de départ aléatoire
  public function baseJeu(Request $request) {
    $deck = Deck::find($request->input('deck_id'));

    $deckEnCours = new DeckEnJeu;
    $deckEnCours->setDeck($deck);

    $cartesDeck = array();
    $cartesTableJeu = array();

    // Pour la liste des cartes dud deck, on va creer des clés unique:
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

    $deckEnCours->setCartesDeck($cartesDeck);
    $deckEnCours->setCartesTableJeu($cartesTableJeu);
    $deckEnCours->setCartesMain($cartesMain);

    $request->session()->put('deckEnCours', $deckEnCours);

    return view('jouerDeck.base-jeu')
    ->with('deckEnCours', $deckEnCours);

  }

  // Deplacer une carte de la Main dans la defausse ou dans l'aire de jeu
  // Retourne la vue des cartes en jeu
  public function utiliserCarte(Request $request) {
    $key = $request->input('carteId');

    $deckEnCours = $request->session()->get('deckEnCours');

    $cartesMain = $deckEnCours->getCartesMain();
    $cartesTableJeu = $deckEnCours->getCartesTableJeu();

    $carte = $cartesMain[$key];
    //Delete des cartes en main
    unset($cartesMain[$key]);

    //Add to Table de Jeu
    $cartesTableJeu[$key] = $carte;

    $deckEnCours->setCartesTableJeu($cartesTableJeu);
    $deckEnCours->setCartesMain($cartesMain);
    $request->session()->put('deckEnCours', $deckEnCours);

    return view('jouerDeck.cartes-en-jeu')
    ->with('deckEnCours', $deckEnCours);
  }

  // Piocher le nombre de cartes manquantes (pour avoir 5 dans la main)
  public function piocher(Request $request) {
    $deckEnCours = $request->session()->get('deckEnCours');

    // Pour chaque carte à piocher:
    // - récupérer aléatoire une carte du Deck
    // - supprimer cette carte du Deck
    // - ajouter cette carte à la main
    $cartesMain = $deckEnCours->getCartesMain();
    $cartesDeck = $deckEnCours->getCartesDeck();
    for($i=sizeof($deckEnCours->getCartesMain()); $i < 5;$i++) {

      if (sizeof($cartesDeck) > 0) {
        $keyRandom = array_rand($cartesDeck);
        $carteRandom = $cartesDeck[$keyRandom];

        unset($cartesDeck[$keyRandom]);
        $cartesMain[$keyRandom] = $carteRandom;
      }
    }

    $deckEnCours->setCartesDeck($cartesDeck);
    $deckEnCours->setCartesMain($cartesMain);

    $request->session()->put('deckEnCours', $deckEnCours);

    return view('jouerDeck.cartes-en-jeu')
    ->with('deckEnCours', $deckEnCours);
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
