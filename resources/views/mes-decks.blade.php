@extends('layouts.app')
@section('content')
<div>

  <select id="choix_deck">
      <<option selected="true" disabled="disabled">Choix du deck</option>
    @foreach($decks as $deck)
      <option value="{{$deck->id}}">{{$deck->nom}}</option>
    @endforeach
  </select>

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="deck_show">
</div>


</div>
@endsection
