@extends('layouts.app')
@section('content')
<div id="factions">
  <div class="nav-choix-faction grid" role="navigation">
    @foreach($factions as $faction)
    <div class="nav-faction clear" id="{{$faction->id}}">
      <p class="circle bg-{{$faction->nom}}">
      </p>
      <p class="choix_faction">{{$faction->nom}}</p>
    </div>
    @endforeach
  </div>

    <!-- Div qui contient les factions affichés par un appel Ajax  -->
    <div id="factionToInclude">
    </div>

  </div>
  @endsection
