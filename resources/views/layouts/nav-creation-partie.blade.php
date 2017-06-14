<div id="nav-creation-partie" class="grid txtcenter">
  <div class="">
    En attente de joueur
  </div>
  <div @if($partie->statut==="choix_deck") class="active" @endif>
    Choix Deck
  </div>
  <div  @if($partie->statut==="choix_deploiement") class="active" @endif>
    Choix Déploiement
  </div>
  <div  @if($partie->statut==="attente_lancement") class="active" @endif>
    Attente de lancement
  </div>
  <div class="">
    En cours
  </div>
</div>
