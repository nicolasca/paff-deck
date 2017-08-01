@extends('layouts.app')
@section('content')

<div id="table-jeu">

    <input type="hidden" name="url" id="url" value="{{ url('/')}}">
    <input type="hidden" name="url" id="partieId" value="{{$partie->id}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div id="presentation-joueur-1" class="presentation-joueur">
      <div class="item">Joueur</div>
      <div class="item">Faction</div>

      <div class="item">{{$partie->user_1->name}}</div>
      <div class="item">{{$partie->deck_1->faction->nom}}</div>
    </div>



      <div id="cartes-main-1" class="cartes-main grid has-gutter">
        @foreach($partie->deck_en_cours_1->cartes_en_cours as $carte)
        @if($carte->statut == "MAIN")
        @include('zone-jeu.carte', ['userId' => $partie->user_1_id,
        'carte' => $carte])
        @endif
        @endforeach

        <div>
          @if(Auth::user()->id == $partie->user_1_id)
          <button id="button1" type="button" name="button1" class="bouton-pioche button"
          data-userid="{{$partie->user_1_id}}">Piocher</button>
          @endif
        </div>
      </div>



    <div id="cartes-deploiement-1" class="cartes-deploiement grid-5 has-gutter">
      @foreach($partie->deck_en_cours_1->cartes_en_cours as $carte)
      @if($carte->statut == "DEPLOIEMENT")
      @include('zone-jeu.carte', ['userId' => $partie->user_1_id,
      'carte' => $carte])
      @endif
      @endforeach
    </div>

    <div id="zone-de-jeu">
      @for ($i = 0; $i < 54; $i++)
      <div class=" zoneJeu {{in_array($i, $positionsParZone['flancCoco']) ? 'flanc-coco' : ''}}
                  {{in_array($i, $positionsParZone['flancQuetsch']) ? 'flanc-quetsch' : ''}} "
        id="position_{{$i}}"
        data-position="{{$i}}"
        data-statut="zone-jeu">
        @foreach($partie->cartes_en_cours as $carteEnCours)
          @if($carteEnCours->statut == "ZONE_JEU" && $carteEnCours->position !=null && $carteEnCours->position == $i)
          <div class="inbl carte-main" id="carte_{{$carteEnCours->id}}">
            <img src="{{ URL::to('/') }}/images/{{$carteEnCours->carte->faction->nom}}/{{$carteEnCours->carte->path}}"
            data-degats="0" />
            <div id="degats">
              <p></p>
            </div>
            <i id="flagCarte" class="fa fa-bolt not-visible" aria-hidden="true"></i>

          </div>
          @endif
        @endforeach
      </div>
    @endfor

    @include('zone-jeu.tooltip-carte-action')

    @include('zone-jeu.tooltip-zone-decor')

  </div>

  <div id="cartes-main-2"  class="cartes-main grid has-gutter">
    @foreach($partie->deck_en_cours_2->cartes_en_cours as $carte)
      @if($carte->statut == "MAIN")
        @include('zone-jeu.carte', ['userId' => $partie->user_2_id,
        'carte' => $carte])
      @endif
    @endforeach

    <div>
      @if(Auth::user()->id == $partie->user_2_id)
      <button id="button2" type="button" name="button2" class="button bouton-pioche"
      data-userid="{{$partie->user_2_id}}">Piocher</button>
      @endif
    </div>

  </div>

  <div id="cartes-deploiement-2" class="cartes-deploiement grid-5 has-gutter">
    @foreach($partie->deck_en_cours_2->cartes_en_cours as $carte)
    @if($carte->statut == "DEPLOIEMENT")
    @include("zone-jeu.carte", ['userId' => $partie->user_2_id,
    'carte' => $carte])
    @endif
    @endforeach
  </div>


  <div id="presentation-joueur-2" class="presentation-joueur">
    <div class="item">Joueur</div>
    <div class="item">Faction</div>

    <div class="item">{{$partie->user_2->name}}</div>
    <div class="item">{{$partie->deck_2->faction->nom}}</div>
  </div>


<div id="infos-partie">
  <div id="tour">
    <b>Tour</b> <input type="number" name="" value="1">
  </div>
    <div id="generateur-des">
      <p>Générateur de dés</p>
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

<div id="defausse">
  <h2>Defausse</h2>
  <div id="cartes-defausse" data-statut="defausse">
    @foreach($partie->cartes_en_cours as $carteEnCours)
      @if($carteEnCours->statut == "DEFAUSSE")
      <div class="inbl carte-main" id="carte_{{$carteEnCours->id}}">
        <img src="{{ URL::to('/') }}/images/{{$carteEnCours->carte->faction->nom}}/{{$carteEnCours->carte->path}}"
        data-degats="0" />
      </div>
      @endif
    @endforeach
  </div>
</div>

</div>

@endsection
