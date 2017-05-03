
<div id="deck_cartes">

  <form action="mes-decks/update" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if(isset($deckShow))
    <input type="hidden" name="deck_id" value="{{$deckShow->id}}">
    @endif

  @if(isset($deckShow))
  <div class="titre_deck center w50">
        <input type="text" name="nom_deck" value="{{$deckShow->nom}}">
        <p>
          Points de déploiment: {{$recapitulatif['ptsDeploiement']}} <br />
          Nombre de cartes: {{$recapitulatif['nbCartes']}}
        </p>
  </div>
  @else
  <div class="titre_deck center w50">
        <label for="nom_deck">Nom du deck</label>
        <input type="text" name="nom_deck">
        <label for="description">Description</label>
        <input type="textarea" name="description">
  </div>
  @endif

    @if(isset($cartesByType['troupe']))
    <div>
      <p>Troupe</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['troupe']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

     @if(isset($cartesByType['tir']))
    <div>
      <p>Tir</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['tir']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['cavalerie']))
    <div>
      <p>Cavalerie</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['cavalerie']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['artillerie']))
    <div>
      <p>Artillerie</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['artillerie']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['elite']))
    <div>
      <p>Elite</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['elite']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['unique']))
    <div>
      <p>Unique</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['unique']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($cartesByType['ordre']))
    <div>
      <p>Ordre</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['ordre']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          # <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    <input type="submit" name="Valider" value="Valider" class="button">

  </form>

</div>
