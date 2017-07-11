@extends('layouts.app')
@section('content')

<div id="table-jeu" class="grid">

  <div class="left">
    <input type="hidden" name="url" id="url" value="{{ url('/')}}">
    <input type="hidden" name="url" id="partieId" value="{{$partie->id}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="presentation-joueur">
      <div class="item">Joueur</div>
      <div class="item">Deck</div>
      <div class="item">Faction</div>

      <div class="item">{{$partie->user_1->name}}</div>
      <div class="item">{{$partie->deck_1->nom}} </div>
      <div class="item">{{$partie->deck_1->faction->nom}}</div>
    </div>


    <div class="cartes-main">
      @foreach($partie->deck_en_cours_1->cartes_en_cours as $carte)
      @if($carte->statut == "MAIN")
      <div class="inbl carte-main {{Auth::user()->id != $partie->user_1_id ? 'not-visible' : ''}} "
        id="carte_{{$carte->id}}">
        <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_1->deck->faction->nom}}/{{$carte->carte->path}}" />
      </div>
      @endif
      @endforeach
      @if(Auth::user()->id == $partie->user_1_id)
      <button type="button" name="button1" class="bouton-pioche button"
      data-userid="{{$partie->user_1_id}}">Piocher</button>
      @endif
    </div>

    <div class="cartes-deploiement">
      @foreach($partie->deck_en_cours_1->cartes_en_cours as $carte)
      @if($carte->statut == "DEPLOIEMENT")
      <div class="inbl carte-main {{Auth::user()->id != $partie->user_1_id ? 'not-visible' : ''}} "
        id="carte_{{$carte->id}}">
        <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_1->deck->faction->nom}}/{{$carte->carte->path}}" />
      </div>
      @endif
      @endforeach
    </div>
    <div id="zone-de-jeu" class="grid-9 has-gutter ">
      @for ($i = 0; $i < 54; $i++)
      <div class="zoneJeu" id="position_{{$i}}" data-position="{{$i}}"
      data-statut="zone-jeu">
      @foreach($partie->cartes_en_cours as $carteEnCours)
      @if($carteEnCours->position !=null && $carteEnCours->position == $i)
      <div class="inbl carte-main"
      id="carte_{{$carteEnCours->id}}">
      <img src="{{ URL::to('/') }}/images/{{$carteEnCours->carte->faction->nom}}/{{$carteEnCours->carte->path}}"
      data-degats="0" />
      <div id="degats">
        <p></p>
      </div>
    </div>
    @endif
    @endforeach
  </div>
  @endfor

  <div id="tooltip-carte-action" data-carteid="">
    Combat à
    <button type="button" name="left" class="button bouton-combat"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
    <button type="button" name="top" class="button bouton-combat"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
    <button type="button" name="bottom" class="button bouton-combat"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
    <button type="button" name="right" class="button bouton-combat"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
    <button type="button" name="none" class="button bouton-combat"><i class="fa fa-times" aria-hidden="true"></i></button> <br />
    Dégâts
    <button type="button" name="more" class="button bouton-degats"><i class="fa fa-plus" aria-hidden="true"></i></button>
    <button type="button" name="less" class="button bouton-degats"><i class="fa fa-minus" aria-hidden="true"></i></button> <br />
    <button type="button" name="defausse" class="button bouton-defausse">Défausse</button>
    <button type="button" name="moral" class="button bouton-moral">Moral</button>
    <button type="button" name="fuite" class="button bouton-fuite">Fuite</button>
  </div>

  <div id="tooltip-zone-decor" data-carteid="">
    <button type="button" name="foret" class="button bouton-decor">Forêt</i></button>
    <button type="button" name="colline" class="button bouton-decor">Colline</i></button>
    <button type="button" name="lac" class="button bouton-decor">Lac</i></button>
    <button type="button" name="ruines" class="button bouton-decor">Ruines</i></button>
    <button type="button" name="none" class="button bouton-decor">Aucun</i></button>
  </div>
</div>

<div class="cartes-main">
  @foreach($partie->deck_en_cours_2->cartes_en_cours as $carte)
  @if($carte->statut == "MAIN")
  <div class="inbl carte-main {{Auth::user()->id != $partie->user_2_id ? 'not-visible' : ''}} "
    id="carte_{{$carte->id}}">
    <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_2->deck->faction->nom}}/{{$carte->carte->path}}" />
  </div>
  @endif
  @endforeach

  @if(Auth::user()->id == $partie->user_2_id)
  <button type="button" name="button2" class="button bouton-pioche"
  data-userid="{{$partie->user_2_id}}">Piocher</button>
  @endif
</div>

<div class="cartes-deploiement">
  @foreach($partie->deck_en_cours_2->cartes_en_cours as $carte)
  @if($carte->statut == "DEPLOIEMENT")
  <div class="inbl carte-main {{Auth::user()->id != $partie->user_2_id ? 'not-visible' : ''}} "
    id="carte_{{$carte->id}}">
    <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_2->deck->faction->nom}}/{{$carte->carte->path}}" />
  </div>
  @endif
  @endforeach
</div>


<div class="presentation-joueur">
  <div class="item">Joueur</div>
  <div class="item">Deck</div>
  <div class="item">Faction</div>

  <div class="item">{{$partie->user_2->name}}</div>
  <div class="item">{{$partie->deck_2->nom}} </div>
  <div class="item">{{$partie->deck_2->faction->nom}}</div>
</div>

</div>

<div class="right one-fifth">
  <div id="infos-partie">


    <div id="generateur-des">
      <p>Générateur de dés</div>
        <select id="nombre-des" name="nombre-des">
          @for ($i = 1; $i < 8; $i++)
          <option value="{{$i}}">{{$i}}</option>
          @endfor
        </select>
        <button id="roll-dice" class="button" type="button" name="roll-dice">Azy !</button>
        <span id="resultat-roll-dice"></span>
      </div>

      <div id="carte-grand">
        <img src="" alt="" />
      </div>
    </div>
  </div>

</div>

<div id="defausse">
  <h2>Defausse</h2>
  <div id="cartes-defausse" data-statut="defausse">

  </div>
</div>

@endsection
