@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<h1 class="center w50 txtcenter">Liste des résultats</h1>

<table id="table-resultats">
  <thead>
    <tr>
      <th>Date</th>
      <th>Mode</th>
      <th>Faction 1</th>
      <th>Faction 2</th>
      <th>Résultat</th>
      <th>Type</th>
      <th>Action</th>
    </tr>
  </thead>

  @foreach($resultats as $resultat)
  <tr>
    <td>{{$resultat->created_at->format('d/m/Y')}}</td>
    <td>{{$resultat->getMode()}}</td>
    <td>{{$resultat->faction_1->nom}}</td>
    <td>{{$resultat->faction_2->nom}}</td>
    <td>{{$resultat->getResultat()}}</td>
    <td>
    @if(isset($resultat->type_victoire))
    {{$resultat->getType()}}
    @endif
    </td>
    <td>
      <a id="modifier-resultat" href="resultats/edit-resultat?resultatId={{$resultat->id}}">
        <i class="fa fa-pencil" aria-hidden="true" title="Modifier le résultat"></i>
      </a>
      <span id="detruire-resultat" data-resultatid="{{$resultat->id}}"><i class="fa fa-trash-o" aria-hidden="true" title="Supprimer le résultat"></i></span>
    </td>
  </tr>
  @endforeach

</table>

@endsection
