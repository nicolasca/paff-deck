@extends('layouts.app')
@section('content')
<div id="creer-deck" class="flex-container">

  <div class="nav-choix-faction w150p" role="navigation">
    <ul>
      @foreach($factions as $faction)
      <li id="{{$faction->id}}" class="choix_faction">{{$faction->nom}}</li>
      @endforeach
    </ul>
  </div>


  <!-- Div qui contient les decks affichés par un appel Ajax  -->
  <div id="faction_show" class="flex-item-fluid">
  </div>


</div>
@endsection
