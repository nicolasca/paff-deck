<?php

namespace App;

class DeckEnJeu { 
  private $deck;

  private $cartesDeck;

  private $cartesMain;

  private $cartesTableJeu;

  private $cartesDefausse;

  function __construct() {
    $this->cartesDeck = array();
    $this->cartesMain = array();
    $this->cartesTableJeu = array();
    $this->cartesDefausse = array();
    }

  public function getDeck() {
    return $this->deck;
  }

  public function setDeck($deck) {
    $this->deck = $deck;
  }

  public function getCartesMain() {
    return $this->cartesMain;
  }

  public function setCartesMain($cartesMain) {
    $this->cartesMain = $cartesMain;
  }

  public function getCartesTableJeu() {
    return $this->cartesTableJeu;
  }

  public function setCartesTableJeu($cartesTableJeu) {
    $this->cartesTableJeu = $cartesTableJeu;
  }

  public function getCartesDeck() {
    return $this->cartesDeck;
  }

  public function setCartesDeck($cartesDeck) {
    $this->cartesDeck = $cartesDeck;
  }

}
