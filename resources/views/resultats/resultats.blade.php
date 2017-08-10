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
    </tr>
  </thead>

  @foreach($resultats as $resultat)
  <tr>
    <td>{{$resultat->created_at->format('d/m/Y')}}</td>
    <td>{{$resultat->getMode()}}</td>
    <td>{{$resultat->faction_1->nom}}</td>
    <td>{{$resultat->faction_2->nom}}</td>
    <td>{{$resultat->getResultat()}}</td>
    <td>{{$resultat->getType()}}</td>
  </tr>
  @endforeach

</table>

@endsection
