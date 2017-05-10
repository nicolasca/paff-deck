<div id="deck_cartes">

  <div class="titre_deck center w50">
    <h2 class="center">{{$deckShow->nom}}</h2>
</div>

<div>
  <div id="liste-cartes" class="fl w80">

    @if(isset($cartesByType['troupe']))
    <div>
      <h3 class="type-carte">Troupe <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['troupe']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info "data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['tir']))
    <div>
      <h3 class="type-carte">Tir <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['tir']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['cavalerie']))
    <div>
      <h3 class="type-carte">Cavalerie <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['cavalerie']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['artillerie']))
    <div>
      <h3 class="type-carte">Artillerie <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['artillerie']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['elite']))
    <div>
      <h3 class="type-carte">Elite <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['elite']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['unique']))
    <div>
      <h3 class="type-carte">Unique <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['unique']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['ordre']))
    <div>
      <h3 class="type-carte">Ordre <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['ordre']  as $carte)
        <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
          <span class="carte-info" data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
          data-nom="{{$carte->nom}}" data-type="{{$carte->type}}"># {{$carte->pivot->nombre}}</span>
        </p>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  <div id="recap-edit" class="fl w20">
    <div id="recap-chiffres">
      Points de déploiment: <span id="points-deploiement">{{$recapitulatif['ptsDeploiement']}}</span> <br />
      Nombre de cartes: <span id="nombre-cartes">{{$recapitulatif['nbCartes']}}</span>
    </div>
    <div id="recap-liste-unites">
      <div class="recap-unite">
        <p class="recap-type-unite">Troupe</p>
        <p id="recap-troupe" class="recap-cartes"></p>
      </div>

      <div class="recap-unite">
        <p class="recap-type-unite">Tir</p>
        <p id="recap-tir" class="recap-cartes"></p>
      </div>
      <div class="recap-unite">
        <p class="recap-type-unite">Cavalerie</p>
        <p id="recap-cavalerie" class="recap-cartes"></p>
      </div>
      <div class="recap-unite">
        <p class="recap-type-unite">Artillerie</p>
        <p id="recap-artillerie" class="recap-cartes"></p>
      </div>
      <div class="recap-unite">
        <p class="recap-type-unite">Elite</p>
        <p id="recap-elite" class="recap-cartes"></p>
      </div>
      <div class="recap-unite">
        <p class="recap-type-unite">Unique</p>
        <p id="recap-unique" class="recap-cartes"></p>
      </div>
      <div class="recap-unite">
        <p class="recap-type-unite">Ordre</p>
        <p id="recap-ordre" class="recap-cartes"></p>
      </div>
    </div>
  </div>

</div>

</div>
