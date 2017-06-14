@extends('layouts.app')
@section('content')

<div id="deck_cartes">
Choix déloiement
<p>{{$deck->nom}}</p>
<p>{{$deck->faction->nom}}</p>

<form action="saveChoixDeploiement" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="deck_id" value="{{$deck->id}}">
  <input type="hidden" name="idPartie" value="{{$idPartie}}">

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
        data-nom="{{$carte->nom}}" data-type="{{$carte->type}}">
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

<div id="recap-edit" class="fr w20">
<div id="recap-chiffres">
  Points de déploiment: <span id="points-deploiement">{{$recapitulatif['ptsDeploiement']}}</span> <br />
  Nombre de cartes: <span id="nombre-cartes">{{$recapitulatif['nbCartes']}}</span>
</div>
<div id="recap-liste-unites">
  @foreach($cartesByType as $type => $cartes)
  <div class="recap-unite">
    <p class="recap-type-unite">{{Config::get('constants.'.$type)}}</p>
    <p id="recap-{{$type}}" class="recap-cartes"></p>
  </div>
  @endforeach
</div>
</div>

</div>


</div>

@endsection
