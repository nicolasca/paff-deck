@if ($deckShow !== '')
<div id="deck_cartes">

@if(isset($cartesByType['troupe']))
<div>
  <h2>Troupe</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['troupe']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['tir']))
<div>
  <h2>Tir</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['tir']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['cavalerie']))
<div>
  <h2>Cavalerie</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['cavalerie']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['artillerie']))
<div>
  <h2>Artillerie</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['artillerie']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['elite']))
<div>
  <h2>Elite</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['elite']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['unique']))
<div>
  <h2>Unique</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['unique']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

@if(isset($cartesByType['ordre']))
<div>
  <h2>Ordre</h2>
  <div id="deck_cartes" class="grid-4 has-gutter">
    @foreach($cartesByType['ordre']  as $carte)
    <p>
      <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
      Nombre: {{$carte->pivot->nombre}}
    </p>
    @endforeach
  </div>
</div>
@endif

</div>
@endif
