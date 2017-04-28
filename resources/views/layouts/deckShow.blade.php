@if ($deckShow !== '')
<div id="deck_cartes">

<div class="titre_deck center w50">
  <h2 class="center">{{$deckShow->nom}}</h2>
  <div>
    <p>
      Points de déploiment: {{$recapitulatif['ptsDeploiement']}} <br />
      Nombre de cartes: {{$recapitulatif['nbCartes']}}
    </p>
    <p>

    </p>
  </div>
</div>

<!-- Récapitulatif

Points Depl : 68
Nombre Carte : 44

troupe
8x Guerriers Nordiques
10x Jeunes Nordiques
cavalerie
6x Guerriers Nordiques a cheval
2x Chevaucheurs d ours
elite
4x Gardiens du Nord
unique
1x Roi Borrud Wosdork et sa garde
ordre
3x Tenez la ligne
4x A l ancienne
3x Grands Chefs du Nord
3x Boucliers -->

@if(isset($cartesByType['troupe']))
<div>
  <p>Troupe</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['troupe']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['tir']))
<div>
  <p>Tir</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['tir']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['cavalerie']))
<div>
  <p>Cavalerie</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['cavalerie']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['artillerie']))
<div>
  <p>Artillerie</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['artillerie']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['elite']))
<div>
  <p>Elite</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['elite']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['unique']))
<div>
  <p>Unique</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['unique']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['ordre']))
<div>
  <p>Ordre</p>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['ordre']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      # {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

</div>
@endif
