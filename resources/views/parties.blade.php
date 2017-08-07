@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<h1 class="center w50 txtcenter">Liste des parties</h1>

<div id="creer-partie">
  <a id="creer-partie-btn" href="{{ url('/creation-partie') }}"><i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i></a>
</div>

<table id="table-parties">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Joueur 1</th>
      <th>Joueur 2</th>
      <th>Mode</th>
      <th>Statut</th>
      <th>Action</th>
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
    <td><a href="{{ url('/rejoindre-partie')}}/{{$partie->id}}" >Rejoindre</a>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
    </td>
    @elseif($boutonAction[$partie->id] == "choix_deck")
    <td>
      <form action="partie/choix-deck" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" class="fa submit-with-icon" value="&#xf24d;" class="submit-with-icon" title="Choisir un deck"></i></button>
      </form>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
      </td>

    @elseif($boutonAction[$partie->id] == "choix_deploiement")
    <td>
      <form action="partie/choix-deploiement" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_partie" value="{{$partie->id}}">
        <input type="submit" class="fa submit-with-icon" value="&#xf24d;" class="submit-with-icon" title="Choisir son déploiement"></i></button>
      </form>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
      </td>

    @elseif($boutonAction[$partie->id] == "attente_lancement")
    <td>
      <a href="partie/recap-avant-partie/{{$partie->id}}"><i class="fa fa-gamepad" aria-hidden="true"  title="Lancer la partie"></i></a>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
      </td>

    @elseif($boutonAction[$partie->id] == "en_cours")
    <td>
      <a href="partie/zone-jeu?idPartie={{$partie->id}}"><i class="fa fa-arrow-circle-right" aria-hidden="true" title="Rejoindre la partie"></i></a>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
      </td>
    @elseif($partie->statut =="attente_joueur")
    <td>
      <span id="detruire-partie" data-partieid="{{$partie->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer une partie"></i></span>
    </td>
    @endif



  </tr>
  @endforeach
</table>

@endsection
