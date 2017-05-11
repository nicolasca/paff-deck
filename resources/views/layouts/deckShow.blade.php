<div id="deck_cartes">

  <div class="titre_deck center w50">
    <h2 class="center">{{$deckShow->nom}}</h2>
    <span>Mode {{$deckShow->getMode()}}</span>
  </div>

  <div>
    <div id="liste-cartes" class="fl w80">

      @foreach($cartesByType as $type => $cartes)
      <div>
        <h3 class="type-carte">{{Config::get('constants.'.$type)}} <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
        <div class="grid-3 has-gutter liste-cartes">
          @foreach($cartes as $carte)
          <p class="carte">
            <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
            <span class="carte-info "data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
              data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
            </p>
            @endforeach
          </div>
        </div>
        @endforeach


      </div>

      <div id="recap-edit" class="fl w20">
        <div id="recap-chiffres">
          Points de déploiment: <span id="points-deploiement">{{$recapitulatif['ptsDeploiement']}}</span> <br />
          Nombre de cartes: <span id="nombre-cartes">{{$recapitulatif['nbCartes']}}</span>
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

    </div>

  </div>
