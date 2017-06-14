@extends('layouts.app')
@section('content')

@include('layouts.nav-creation-partie')

<div id="recap-avant-partie">
<h2 class="center txtcenter w50">{{$partie->nom}} - {{$partie->getMode()}}</h2>
  <input type="hidden" name="url" id="url" value="{{ url('/')}}">
<div class="grid txtcenter mas" id="recap-joueurs">
  <div class="partie-item joueur-infos">
    <h3>{{$partie->user_1->name}}</h3>
    <p>{{$partie->deck_1->nom}} </p>
    <p>{{$partie->deck_1->faction->nom}}</p>
  </div>
  <div class="partie-item one-fifth" id="vs-joueurs">
    <h3>VS</h3>
  </div>
  <div class="partie-item joueur-infos">
    <h3>{{$partie->user_2->name}}</h3>
    <p>{{$partie->deck_2->nom}}</p>
    <p> {{$partie->deck_2->faction->nom}}</p>
  </div>
</div>

<div class="center txtcenter">
  <button class="button"type="button" name="lancer-partie"
    data-partieid="{{$partie->id}}" id="btn-lancer-partie">Lancer la partie</button>
</div>


</div>
@endsection
