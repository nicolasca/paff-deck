@extends('layouts.app')
@section('content')

<div id="table-jeu" class="grid">

<div class="left">

    <input type="hidden" name="url" id="url" value="{{ url('/')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="">
  <p>{{$partie->user_1->name}}</p>
  <p>{{$partie->deck_1->nom}} </p>
  <p>{{$partie->deck_1->faction->nom}}</p>
</div>


<div class="cartes-main">
  @foreach($partie->deck_en_cours_1->cartesEnCours as $carte)
    @if($carte->statut == "MAIN")
      <div class="zoneJeu inbl carte-main {{Auth::user()->id == $partie->user_2_id ? 'not-visible' : ''}} "
            id="carte_{{$carte->id}}">
        <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_1->deck->faction->nom}}/{{$carte->carte->path}}" />
      </div>
    @endif
  @endforeach
  @if(Auth::user()->id == $partie->user_1_id)
  <button type="button" name="button1" class="bouton-pioche" data-userid="{{$partie->user_1_id}}">Piocher</button>
  @endif
</div>

  <div id="zone-de-jeu" class="grid-9 has-gutter">
    @for ($i = 0; $i < 54; $i++)
    <div class="zoneJeu" id="position_{{$i}}" data-position="{{$i}}" data-statut="zone-jeu">
      @foreach($partie->deck_en_cours_1->cartesEnCours as $carte)
        @if($carte->position !=null && $carte->position == $i)
        <div class="zoneJeu inbl carte-main"
              id="carte_{{$carte->id}}">
          <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_1->deck->faction->nom}}/{{$carte->carte->path}}"
          data-degats="0" />
          <div id="degats">
            <p></p>
          </div>
        </div>
        @endif
      @endforeach
      @foreach($partie->deck_en_cours_2->cartesEnCours as $carte)
        @if($carte->position !=null && $carte->position == $i)
        <div class="zoneJeu inbl carte-main"
              id="carte_{{$carte->id}}">
          <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_2->deck->faction->nom}}/{{$carte->carte->path}}"
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
      <p>Actions</p>
      Combat à
      <button type="button" name="left" class="bouton-combat">Gauche</button>
      <button type="button" name="top" class="bouton-combat">Haut</button>
      <button type="button" name="bottom" class="bouton-combat">Bas</button>
      <button type="button" name="right" class="bouton-combat">Droite</button>
      <button type="button" name="none" class="bouton-combat">Aucun</button>
      Point de vie
      <button type="button" name="more" class="bouton-degats">+</button>
      <button type="button" name="less" class="bouton-degats">-</button>
    </div>
  </div>

  <div class="cartes-main">
    @foreach($partie->deck_en_cours_2->cartesEnCours as $carte)
      @if($carte->statut == "MAIN")
        <div class="zoneJeu inbl carte-main {{Auth::user()->id == $partie->user_1_id ? 'not-visible' : ''}} "
        id="carte_{{$carte->id}}">
          <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_2->deck->faction->nom}}/{{$carte->carte->path}}" />
        </div>
      @endif
    @endforeach

    @if(Auth::user()->id == $partie->user_2_id)
    <button type="button" name="button2" class="bouton-pioche" data-userid="{{$partie->user_2_id}}">Piocher</button>
    @endif

  </div>

  <div class="">
    <p>{{$partie->user_2->name}}</p>
    <p>{{$partie->deck_2->nom}} </p>
    <p>{{$partie->deck_2->faction->nom}}</p>
  </div>

</div>

<div class="right one-fifth">
  <div id="infos-partie">


  <div id="generateur-des">
    <p>Générateur de dés</p>
    <select id="nombre-des" name="nombre-des">
      @for ($i = 1; $i < 8; $i++)
      <option value="{{$i}}">{{$i}}</option>
      @endfor
    </select>
    <button id="roll-dice" class="button" type="button" name="roll-dice">Azy !</button>
    <span id="resultat-roll-dice"></span>
    <span id="commentaire-roll-dice"></span>
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
