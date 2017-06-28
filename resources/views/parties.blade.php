@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<table class="table-parties">
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
    @if($boutonAction[$partie->id] == "rejoindre")
    <td><a href="{{ url('/rejoindre-partie')}}/{{$partie->id}}" >Rejoindre</a></td>
    @elseif($boutonAction[$partie->id] == "choix_deck")
    <td>
      <form action="partie/choix-deck" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" value="Choisir un deck">
      </form>
    </td>
    @elseif($boutonAction[$partie->id] == "choix_deploiement")
    <td>
      <form action="partie/choix-deploiement" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" value="Choisir son déploiement">
      </form>
    </td>
    @elseif($boutonAction[$partie->id] == "attente_lancement")
    <td>
      <a href="partie/recap-avant-partie/{{$partie->id}}">Lancer la partie</a>
    </td>
    @elseif($boutonAction[$partie->id] == "en_cours")
    <td>
      <a href="partie/zone-jeu?idPartie={{$partie->id}}">Aller sur la partie</a>
    </td>
    @endif
    <td>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
    </td>

  </tr>
  @endforeach
</table>

<a id="creer-partie-btn" class="card button" href="{{ url('/creation-partie') }}">Créer une partie</a>

@endsection
