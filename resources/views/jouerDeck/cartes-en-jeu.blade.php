
<h3>Cartes en main</h3>

  <span>Cartes restantes dans le deck: {{sizeof($deckEnCours->getCartesDeck())}}</span>

  <button class="button txtcenter" id="piocher-carte"
  <?php if(sizeof($deckEnCours->getCartesDeck()) == 0 || sizeof($deckEnCours->getCartesMain()) == 5) {

        echo "style=display:none;";
      }?>
  >Piocher</button>



<div id="cartes-main" class="grid-5 has-gutter liste-cartes">
  @foreach($deckEnCours->getCartesMain() as $key => $carte)
  <p class="carte txtcenter">
    <img src="{{ URL::to('/') }}/images/{{$deckEnCours->getDeck()->faction->nom}}/{{$carte->path}}"/>
    <button class="button txtcenter utiliserCarte" name="{{$carte->id}}" id="{{$key}}"
      data-cout="{{$carte->cout_deploiement}}" data-id="{{$carte->id}}"
    data-nom="{{$carte->nom}}" data-type="{{$carte->type}}">Utiliser</button>
  </p>
  @endforeach
</div>

<h3>Cartes hors du deck (aire de jeu ou défausse)</h3>

<div id="cartes-main" class="grid-5 has-gutter liste-cartes">
  @foreach($deckEnCours->getCartesTableJeu() as $key => $carte)
  <p class="carte">
    <img src="{{ URL::to('/') }}/images/{{$deckEnCours->getDeck()->faction->nom}}/{{$carte->path}}"/>
  </p>
  @endforeach
</div>
