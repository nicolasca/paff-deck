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
  <h3 class="type-carte">Troupe</h3>
  <div class="grid-4 has-gutter">
    @foreach($cartesByType['troupe']  as $carte)
    <p class="carte">
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['tir']))
<div>
  <p class="type-carte">Tir</p>
  <div class="grid-4 has-gutter">
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
  <p class="type-carte">Cavalerie</p>
  <div class="grid-4 has-gutter">
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
  <p class="type-carte">Artillerie</p>
  <div class="grid-4 has-gutter">
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
  <p class="type-carte">Elite</p>
  <div class="grid-4 has-gutter">
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
  <p class="type-carte">Unique</p>
  <div class="grid-4 has-gutter">
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
  <p class="type-carte">Ordre</p>
  <div class="grid-4 has-gutter">
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
