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
    <td>{{$partie->nom}}</td>
    <td>{{$partie->user_1->name}}</td>
    <td>@if($partie->user_2){{$partie->user_2->name}}@endif</td>
    <td>{{$partie->getMode()}}</td>
    <td>{{$partie->getStatut()}}</td>

    <!-- Affichage du bouton correspond selon le statut et userId -->
    @if($boutonAction[$partie->id] === "rejoindre")
    <td><a href="{{ url('/rejoindre-partie')}}/{{$partie->id}}" >Rejoindre</a></td>
    @elseif($boutonAction[$partie->id] === "choix_deck")
    <td>
      <form action="partie/choix-deck" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" value="Choisir un deck">
      </form>
    </td>
    @elseif($boutonAction[$partie->id] === "choix_deploiement")
    <td>
      <form action="partie/choix-deploiement" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" value="Choisir son déploiement">
      </form>
    </td>
    @endif

  </tr>
  @endforeach
</table>

<a id="creer-partie-btn" class="card button" href="{{ url('/creation-partie') }}">Créer une partie</a>

@endsection
