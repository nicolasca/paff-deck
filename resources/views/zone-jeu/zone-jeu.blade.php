@extends('layouts.app')
@section('content')

<div id="table-jeu">
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
      <div class="zoneJeu inbl carte-main" id="carte_{{$carte->identifiant_partie}}">
        <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_1->deck->faction->nom}}/{{$carte->carte->path}}" />
      </div>
    @endif
  @endforeach

  <button type="button" name="button1" class="bouton-pioche" data-userid="{{$partie->user_1_id}}">Piocher</button>
</div>

  <div id="zone-de-jeu" class="grid-9 has-gutter">
    @for ($i = 0; $i < 54; $i++)
    <div class="zoneJeu" id="position_{{$i}}"data-position="{{$i}}">

    </div>
    @endfor
  </div>

  <div class="cartes-main">
    @foreach($partie->deck_en_cours_2->cartesEnCours as $carte)
      @if($carte->statut == "MAIN")
        <div class="zoneJeu inbl carte-main" id="{{$carte->identifiant_partie}}">
          <img src="{{ URL::to('/') }}/images/{{$partie->deck_en_cours_2->deck->faction->nom}}/{{$carte->carte->path}}" />
        </div>
      @endif
    @endforeach

    <button type="button" name="button2" class="bouton-pioche" data-userid="{{$partie->user_2_id}}">Piocher</button>

  </div>

  <div class="">
    <p>{{$partie->user_2->name}}</p>
    <p>{{$partie->deck_2->nom}} </p>
    <p>{{$partie->deck_2->faction->nom}}</p>
  </div>
</div>

@endsection
