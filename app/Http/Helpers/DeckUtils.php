<?php

namespace App\Http\Helpers;


class DeckUtils {

// Trier le tableau par type dans l'ordre de clé suivant:
// "troupe", "tir", cavalerie, "artillerie", elite, unique, ordre
public static function orderArrayByType($cartesByType) {
  $cartesAvecBonOrdre = array();
  $ordreType = array("troupe", "tir", "cavalerie", "artillerie", "elite", "unique", "ordre");
  foreach ($ordreType as $type) {
    if(isset($cartesByType[$type])) {
      $cartesAvecBonOrdre[$type] = $cartesByType[$type];
    }
  }
  return $cartesAvecBonOrdre;
}

//Récupérer les informations à afficher dans le récapitulatif
public static function createRecapitulatif($deckShow) {
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
