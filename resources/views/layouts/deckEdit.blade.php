
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
        <p class="form-item center">
          <input type="text" name="nom_deck" value="{{$deckShow->nom}}" required>
        </p>
        <p class="form-item center">
          <?php echo Form::select('mode',
          ['classique' => Config::get('constants.classique'),
          'escarmouche' => Config::get('constants.escarmouche'),
          'epique' => Config::get('constants.epique')],
          $deckShow->mode);  ?>
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
          <input type="text" class="form-text" id="nom_deck" name="nom_deck" required>
        </p>
        <p class="form-item center">
          <label for="description">Description</label>
          <textarea rows="2" cols="50" name="description" id="description" class="form-text"></textarea>
        </p>
        <p class="form-item center">
          <label for="mode">Mode</label>
          <select name="mode">
            <option value="classique" selected>Classique</option>
            <option value="escarmouche">Escarmouche</option>
            <option value="epique">Épique</option>
          </select>
        </p>
      </div>
      @endif


      <div>

        <div id="liste-cartes" class="fl w80">


          @foreach($cartesByType as $type => $cartes)
          <div>
            <h3 class="type-carte">{{Config::get('constants.'.$type)}} <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
            <div class="grid-3 has-gutter liste-cartes">
              @foreach($cartes as $carte)
              <p class="carte">
                <img src="{{ URL::to('/') }}/images/{{$faction->nom}}/{{$carte->path}}"/>
                <input class="carte-info" name="{{$carte->id}}" value="{{$carte->nombre or 0}}" type="number"
                max="{{$carte->nombre_max}}" min="0" data-cout="{{$carte->cout_deploiement}}"
                data-nom="{{$carte->nom}}" data-type="{{$carte->type}}">
              </p>
              @endforeach
            </div>
          </div>
          @endforeach

          <input type="submit" name="Valider" value="Valider" class="button mbm">

        </form>
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
