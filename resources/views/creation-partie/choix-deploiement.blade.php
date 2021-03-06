@extends('layouts.app')
@section('content')

@include('layouts.nav-creation-partie')

<div id="deck_cartes">
Choix déloiement
<p>{{$deck->nom}}</p>
<p>{{$deck->faction->nom}}</p>

<form action="saveChoixDeploiement" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="deck_id" value="{{$deck->id}}">
  <input type="hidden" name="idPartie" value="{{$partie->id}}">

<div id="liste-cartes" class="fl w80">
  @foreach($cartesByType as $type => $cartes)
  <!-- Sur deux lignes, car operateur logique à l'interieur du if pose des soucis  -->
  @if($type != "ordre")
  @if($type != "unique")
  <div>
    <h3 class="type-carte">{{Config::get('constants.'.$type)}} <i class="fa fa-arrow-down" aria-hidden="true"></i></h3>
    <div class="grid-3 has-gutter liste-cartes">
      @foreach($cartes as $carte)
      <p class="carte">
        <img src="{{ URL::to('/') }}/images/{{$deck->faction->nom}}/{{$carte->path}}"/>
        <span>Nombre: {{$carte->pivot->nombre}}</span>
        <input class="carte-info" name="{{$carte->id}}" value="{{ old($carte->id) or 0 }}" type="number"
        max="{{$carte->pivot->nombre}}" min="0" data-cout="{{$carte->cout_deploiement}}"
        data-nom="{{$carte->nom}}" data-type="{{$carte->type}}" data-deplacement="{{$carte->deplacement}}">
      </p>
      @endforeach
    </div>
  </div>
  @endif
  @endif
  @endforeach

  <input type="submit" name="Valider" value="Valider" class="button mbm">

</form>
</div>

      @include('layouts.recapBox')

</div>


</div>

@endsection
