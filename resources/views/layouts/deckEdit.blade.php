
<div id="deck_cartes">

  @if(isset($deckShow))
  <form action="mes-decks/update" method="post">
  @else
  <form action="creer-deck/createDeck" method="post">
  @endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @if(isset($deckShow))
    <input type="hidden" name="deck_id" value="{{$deckShow->id}}">
    @else
    <input type="hidden" name="faction_id" value="{{$faction->id}}">
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
  <div class="presentation-faction">
    <h1>{{$faction->nom}}</h1>
    <p class="description-faction">{{$faction->description}}</p>
  </div>

  <div class="titre_deck titre_deck_create center w50">
    <p class="form-item center">
      <label for="nom_deck">Nom du deck</label>
      <input type="text" class="form-text" id="nom_deck" name="nom_deck">
    </p>
    <p class="form-item center">
      <label for="description">Description</label>
      <textarea rows="2" cols="50" name="description" id="description" class="form-text"></textarea>
    </p>



  </div>
  @endif

    @if(isset($cartesByType['troupe']))
    <div>
      <p class="type-carte">Troupe</p>
      <div class="grid-4 has-gutter">
        @foreach($cartesByType['troupe']  as $carte)
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" />
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    <input type="submit" name="Valider" value="Valider" class="button mbm">

  </form>

</div>
