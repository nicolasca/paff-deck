
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


  <div>

  <div id="liste-cartes" class="fl w80">

    @if(isset($cartesByType['troupe']))
    <div>
      <h3 class="type-carte">Troupe <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
      <div class="grid-3 has-gutter liste-cartes">
        @foreach($cartesByType['troupe']  as $carte)
    <p class="carte">
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
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
        <p>
          <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}" /> <br/>
          <input name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
              max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}">
        </p>
        @endforeach
      </div>
    </div>
    @endif

    <input type="submit" name="Valider" value="Valider" class="button mbm">

  </form>

</div>
  <div class="recap-edit fl w20">
      <p>
        Points de déploiment: <span id="points-deploiement">{{$recapitulatif['ptsDeploiement']}}</span> <br />
        Nombre de cartes: <span id="nombre-cartes">{{$recapitulatif['nbCartes']}}</span>
      </p>
  </div>

  </div>

</div>
