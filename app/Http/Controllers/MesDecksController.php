<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;

use App\Deck;
use App\Carte;
use App\Faction;

class MesDecksController extends Controller {

  // Affichage de la vue principale. Aucun deck affiché.
  public function index() {
    $decks = Auth::user()->decks;
    $deckShow = '';

    return view('mes-decks')->with('decks', $decks)
    ->with('deckShow', $deckShow);
  }

  // Afficher un deck
  public function showDeck() {
    $id = $_GET['id_deck'];
    $deckShow = Deck::find($id);
    $cartesByType = $deckShow->cartes->groupBy('type');
    $recapitulatif = $this->createRecapitulatif($deckShow);

    return view('layouts.deckShow')
    ->with("cartesByType",$cartesByType)
    ->with('deckShow', $deckShow)
    ->with('recapitulatif', $recapitulatif);
  }

  // Afficher le form d'edit d'un deck
  public function editDeck() {
    $id = $_GET['id_deck'];
    // Deck + cartes du deck
    $deckShow = Deck::find($id);
    // Cartes de la faction
    $listeCartesPourFaction = Carte::where("faction_id", $deckShow->faction_id)->get();

    // On récupère les cartes du deck, et on ajoute aussi
    // celle de la faction qui sont non présentes
    foreach ($deckShow->cartes as $carte) {
      $carte->nombre = $carte->pivot->nombre;
      foreach ($listeCartesPourFaction as $carteFaction) {
        if(! $deckShow->cartes->contains('id', $carteFaction->id)) {
          $carteFaction->nombre = 0;
          $deckShow->cartes->push($carteFaction);
        }
      }
    }
    // On tri par type pour l'affichage
    $cartesByType = $deckShow->cartes->groupBy('type');
    $recapitulatif = $this->createRecapitulatif($deckShow);

    return view('layouts.deckEdit')
    ->with("cartesByType",$cartesByType)
    ->with("faction",$deckShow->faction)
    ->with('deckShow', $deckShow)
    ->with('recapitulatif', $recapitulatif);
  }

  // Mettre à jour un deck
  public function updateDeck(Request $request) {
    $deckShow = Deck::find($request->input('deck_id'));

    // Nous allons itérer sur toutes les cartes de la faction présentes dans le formulaire.
    // Si la carte était déjà présente dans le deck, on la met à jour.
    // Sinon, on l'ajoute au deck (si le nombre > 0)
    foreach ($request->all() as $idCarte => $nombre) {
      //Les input ayant pour 'name' l'id de la carte
      if(is_numeric($idCarte)) {

        //Si la carte déjà présente dans le deck
        if($deckShow->cartes->contains('id', $idCarte)) {
          $carte = $deckShow->cartes->where('id', $idCarte);
          foreach ($deckShow->cartes as $carte) {

            //Carte déjà présente. On la met à jour
            if($carte->id == $idCarte) {
              if($nombre == 0) {
                $deckShow->cartes()->detach($carte);
              } else {
                $carte->pivot->nombre = $nombre;
                $carte->pivot->save();
              }
            }
          }
        }
        //Si la carte est nouvelle dans le deck, on l'ajoute à la table
        else if ($nombre != 0) {
          $carte = Carte::where("id", $idCarte)->get();
          $deckShow->cartes()->attach($carte, ['nombre' => $nombre]);
        }
      }
    }

    $deckShow->nom = $request->input('nom_deck');
    $deckShow->save();

    //If no error, display the show deck view
    return redirect()->back()->with('message', 'Deck modi!');
  }

  // Supprimer un deck
  public function deleteDeck() {

    $id = $_GET['id_deck'];
    $deckShow = Deck::find($id);

    // Delete le lien de la table pivot deck_table
    $deckShow->cartes()->detach();
    // Supression du deck
    $deckShow->delete();

    $decks = Auth::user()->decks;
    return view('mes-decks')->with('decks', $decks)
    ->with('deckShow', $deckShow);
  }

  //Récupérer les informations à afficher dans le récapitulatif
  private function createRecapitulatif($deckShow) {
    $nombreCartes = $pointsDeploiement = 0;
    $recapitulatif = array();
    $recapNomsCartes = array();
    foreach ($deckShow->cartes as $carte) {
      if(isset($carte->pivot)) {
      $nombreCartes += $carte->pivot->nombre;
      $pointsDeploiement += $carte->pivot->nombre * $carte->cout_deploiement;

      $recapNomsCartes[$carte->nom] = $carte->pivot->nombre;
      }
    }
    $recapitulatif["nbCartes"] = $nombreCartes;
    $recapitulatif["ptsDeploiement"] = $pointsDeploiement;
    $recapitulatif["recap"] = $recapNomsCartes;

    return $recapitulatif;
  }

}
