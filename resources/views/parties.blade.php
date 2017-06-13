@extends('layouts.app')
@section('content')

<table class="table">
  <thead>
    <tr>
           <th>Nom</th>
           <th>Joueur 1</th>
           <th>Joueur 2</th>
           <th>Mode</th>
           <th>Statut</th>
           <th></th>
       </tr>
  </thead>

  @foreach($parties as $partie)
  <tr>
    @if($partie->statut === "attente_joueur")
    <td>{{$partie->nom}}</td>
    @elseif($partie->statut === "choix_deck")
    <td><a href="partie/choix-deck?partie="{{$partie->id}}></a>{{$partie->nom}}</td>
    @endif
    <td>{{$partie->user_1->name}}</td>
    <td>@if($partie->user_2){{$partie->user_2->name}}@endif</td>
    <td>{{$partie->getMode()}}</td>
    <td>{{$partie->getStatut()}}</td>
    @if($partie->statut === "attente_joueur")
    @if($partie->user_1->id !== Auth::user()->id)
     <td><a href="{{ url('/rejoindre-partie')}}/{{$partie->id}}" >Rejoindre</a></td>
     @endif
    @endif
  </tr>
  @endforeach
</table>

  <a id="creer-partie-btn" class="card button" href="{{ url('/creation-partie') }}">Créer une partie</a>

@endsection
