@extends('layouts.app')
@section('content')
<div id="creer-deck">

  <div class="nav-choix-faction grid" role="navigation">
    @foreach($factions as $faction)
    <div class="nav-faction clear" id="{{$faction->id}}">
      <p class="circle bg-{{$faction->nom}}">
      </p>
      <p class="choix_faction">{{$faction->nom}}</p>
    </div>
    @endforeach
  </div>



  <!-- Div qui contient les decks affichés par un appel Ajax  -->
  <div id="faction_show">
  </div>




</div>
@endsection
