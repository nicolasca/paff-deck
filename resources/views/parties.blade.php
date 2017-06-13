@extends('layouts.app')
@section('content')

<table class="table">
  <thead>
    <tr>
           <th>Partie</th>
           <th>Joueur 1</th>
           <th>Joueur 2</th>
           <th>Statut</th>
           <th></th>
       </tr>
  </thead>

  @foreach($parties as $partie)
  <tr>
    <td>Partie {{$partie->id}}</td>
    <td>{{$partie->user_1->name}}</td>
    <td>@if($partie->user_2){{$partie->user_2->name}}@endif</td>
    <td>{{$partie->getStatut()}}</td>
    @if($partie->statut === "attente_joueur")
    @if($partie->user_1->id !== Auth::user()->id)
     <td><a href="{{ url('/rejoindre-partie')}}/{{$partie->id}}" >Rejoindre</a></td>
     @endif
    @endif
  </tr>
  @endforeach
</table>

  <a id="creer-partie-btn" class="card button" href="{{ url('/creer-partie') }}">Créer une partie</a>

@endsection
