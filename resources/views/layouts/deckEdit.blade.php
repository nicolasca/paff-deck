
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
          <p><div class="tooltip"><label for="mode">Mode</label>
                      <span class="tooltiptext">
                        <table style="width:99%">
                            <tr>
                              <th colspan="2"></th>
                              <th colspan="2">Escarmouche</th>
                              <th colspan="2">Standard</th>
                              <th colspan="2">Epique</th>
                            </tr>
                            <tr>
                              <th rowspan="2">Taille deck</th>
                              <td>min</td>
                              <td colspan="2">15</td>
                              <td colspan="2">40</td>
                              <td colspan="2">40</td>
                            </tr>
                            <tr>
                              <td>max</td>
                              <td colspan="2">26</td>
                              <td colspan="2">100</td>
                              <td colspan="2">140</td>
                            </tr>
                            <tr>
                              <th rowspan="8">Type carte</th>
                              <td></td>
                              <td>Deck</td>
                              <td>Depl init</td>
                              <td>Deck</td>
                              <td>Depl init</td>
                              <td>Deck</td>
                              <td>Depl init</td>
                            </tr>
                            <tr>
                              <td>Troupe</td>
                              <td>10</td>
                              <td>10</td>
                              <td>30</td>
                              <td>30</td>
                              <td>40</td>
                              <td>30</td>
                            </tr>
                            <tr>
                              <td>Unité de tir</td>
                              <td>6</td>
                              <td>6</td>
                              <td>30</td>
                              <td>30</td>
                              <td>40</td>
                              <td>30</td>
                            </tr>
                            <tr>
                              <td>Calaverie</td>
                              <td>4</td>
                              <td>2</td>
                              <td>10</td>
                              <td>10</td>
                              <td>16</td>
                              <td>14</td>
                            </tr>
                            <tr>
                              <td>Artillerie</td>
                              <td>0</td>
                              <td>0</td>
                              <td>6</td>
                              <td>1</td>
                              <td>8</td>
                              <td>4</td>
                            </tr>
                            <tr>
                              <td>Elite</td>
                              <td>1</td>
                              <td>0</td>
                              <td>4</td>
                              <td>1</td>
                              <td>12</td>
                              <td>4</td>
                            </tr>
                            <tr>
                              <td>Unique</td>
                              <td>0</td>
                              <td>0</td>
                              <td>1</td>
                              <td>0</td>
                              <td>3</td>
                              <td>1</td>
                            </tr>
                            <tr>
                              <td>Carte Ordre</td>
                              <td colspan="2">5</td>
                              <td colspan="2">15</td>
                              <td colspan="2">20</td>
                            </tr>
                          </table>
                        </span>
                    </div></p>
          <?php echo Form::select('mode',
          ['classique' => Config::get('constants.classique'),
          'escarmouche' => Config::get('constants.escarmouche'),
          'epique' => Config::get('constants.epique')],
          $deckShow->mode);  ?>

        </p>
        <p class="form-item center">
          <label for="description">Description</label>
          <textarea rows="2" cols="50" name="description" id="description" class="form-text">{{$deckShow->description}}</textarea>
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
          <p><div class="tooltip"><label for="mode">Mode</label>
                      <span class="tooltiptext">
                        <table style="width:99%">
                            <tr>
                              <th colspan="2"></th>
                              <th colspan="2">Escarmouche</th>
                              <th colspan="2">Standard</th>
                              <th colspan="2">Epique</th>
                            </tr>
                            <tr>
                              <th rowspan="2">Taille deck</th>
                              <td>min</td>
                              <td colspan="2">15</td>
                              <td colspan="2">40</td>
                              <td colspan="2">40</td>
                            </tr>
                            <tr>
                              <td>max</td>
                              <td colspan="2">26</td>
                              <td colspan="2">100</td>
                              <td colspan="2">140</td>
                            </tr>
                            <tr>
                              <th rowspan="8">Type carte</th>
                              <td></td>
                              <td>Deck</td>
                              <td>Depl init</td>
                              <td>Deck</td>
                              <td>Depl init</td>
                              <td>Deck</td>
                              <td>Depl init</td>
                            </tr>
                            <tr>
                              <td>Troupe</td>
                              <td>10</td>
                              <td>10</td>
                              <td>30</td>
                              <td>30</td>
                              <td>40</td>
                              <td>30</td>
                            </tr>
                            <tr>
                              <td>Unité de tir</td>
                              <td>6</td>
                              <td>6</td>
                              <td>30</td>
                              <td>30</td>
                              <td>40</td>
                              <td>30</td>
                            </tr>
                            <tr>
                              <td>Calaverie</td>
                              <td>4</td>
                              <td>2</td>
                              <td>10</td>
                              <td>10</td>
                              <td>16</td>
                              <td>14</td>
                            </tr>
                            <tr>
                              <td>Artillerie</td>
                              <td>0</td>
                              <td>0</td>
                              <td>6</td>
                              <td>1</td>
                              <td>8</td>
                              <td>4</td>
                            </tr>
                            <tr>
                              <td>Elite</td>
                              <td>1</td>
                              <td>0</td>
                              <td>4</td>
                              <td>1</td>
                              <td>12</td>
                              <td>4</td>
                            </tr>
                            <tr>
                              <td>Unique</td>
                              <td>0</td>
                              <td>0</td>
                              <td>1</td>
                              <td>0</td>
                              <td>3</td>
                              <td>1</td>
                            </tr>
                            <tr>
                              <td>Carte Ordre</td>
                              <td colspan="2">5</td>
                              <td colspan="2">15</td>
                              <td colspan="2">20</td>
                            </tr>
                          </table>
                        </span>
                    </div></p>
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
                data-nom="{{$carte->nom}}" data-type="{{$carte->type}}" data-deplacement="{{$carte->deplacement}}">
              </p>
              @endforeach
            </div>
          </div>
          @endforeach

          <input type="submit" name="Valider" value="Valider" class="button mbm">

        </form>
      </div>

      @include('layouts.recapBox')

    </div>

  </div>
