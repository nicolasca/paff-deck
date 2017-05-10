@if ($deckShow !== '')
<div id="deck_cartes">

  <div class="titre_deck center w50">
    <h2 class="center">{{$deckShow->nom}}</h2>
    <div>
      <p> Points de déploiment: {{$recapitulatif['ptsDeploiement']}} </p>
      <p class="inbl">  Nombre de cartes: {{$recapitulatif['nbCartes']}} </p>
      <div class="tooltip"><i class="fa fa-question-circle" aria-hidden="true"></i><span class="tooltip-text">
        @foreach($recapitulatif['recap'] as $nom => $nombre)
        <p>x{{$nombre}} {{$nom}}</p>
        @endforeach
      </span>
    </div>
  </div>
</div>



@if(isset($cartesByType['troupe']))
<div>
  <h3 class="type-carte">Troupe <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
  <div class="grid-3 has-gutter liste-cartes">
    @foreach($cartesByType['troupe']  as $carte)
    <p class="carte">
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      <span># {{$carte->pivot->nombre}}</span>
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
      # {{$carte->pivot->nombre}}
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
      # {{$carte->pivot->nombre}}
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
      # {{$carte->pivot->nombre}}
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
      # {{$carte->pivot->nombre}}
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
      # {{$carte->pivot->nombre}}
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
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

</div>
@endif
