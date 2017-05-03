@extends('layouts.app')
@section('content')
<div>

  <select id="choix_faction">
      <<option selected="true" disabled="disabled">Choix de la faction</option>
    @foreach($factions as $faction)
      <option value="{{$faction->id}}">{{$faction->nom}}</option>
    @endforeach
  </select>

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="faction_show">
</div>


</div>
@endsection
