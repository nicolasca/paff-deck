<div id="recap-edit" class="fl w20">
  <div id="recap-chiffres">
    Points de déploiment: <span id="points-deploiement">{{$recapitulatif['ptsDeploiement']}}</span> <br />
    Nombre de cartes: <span id="nombre-cartes">{{$recapitulatif['nbCartes']}}</span><br />
    Déplacement total: <span id="deplacement-total">{{$recapitulatif['deplacement']}}</span> 
  </div>

  <div id="recap-liste-unites">
    @foreach($cartesByType as $type => $cartes)
    <div class="recap-unite">
      <p class="recap-type-unite">{{Config::get('constants.'.$type)}}</p>
      <p id="recap-{{$type}}" class="recap-cartes"></p>
    </div>
    @endforeach
  </div>
</div>
