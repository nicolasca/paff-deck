<div id="deck_cartes">

  <div class="titre_deck center w50">
    <h2 class="center">{{$deckShow->nom}}</h2>
    <span>Mode {{$deckShow->getMode()}}</span>
    <p>Description: <br />
      {{$deckShow->description}}
    </p>
  </div>

  <div>
    <div id="liste-cartes" class="fl w80">

      @foreach($cartesByType as $type => $cartes)
      <div>
        <h3 class="type-carte">{{Config::get('constants.'.$type)}} <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
        <div class="grid-3 has-gutter liste-cartes">
          @foreach($cartes as $carte)
          <p class="carte">
            <img src="{{ URL::to('/') }}/images/{{$deckShow->faction->nom}}/{{$carte->path}}" />
            <span class="carte-info "data-cout="{{$carte->cout_deploiement}}" data-nombre="{{$carte->pivot->nombre}}"
              data-nom="{{$carte->nom}}" data-type="{{$carte->type}}" data-deplacement="{{$carte->deplacement}}">
              # {{$carte->pivot->nombre}}</span>
            </p>
            @endforeach
          </div>
        </div>
        @endforeach


      </div>

      @include('layouts.recapBox')

    </div>
  </div>
