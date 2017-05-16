@extends('layouts.app')
@section('content')
<div id="dashboard">
  <a class="card button" href="{{ url('/creer-deck') }}">Créer un Deck</a>
  <a class="card button" href="{{ url('/mes-decks') }}">Mes Decks</a>
  <a class="card button" href="{{ url('/jouer-deck') }}">Jouer un Deck</a>
  <a id="creer-partie-btn" class="card button" href="{{ url('/creer-partie') }}">Créer une partie</a>
  <a class="card button" href="{{ url('/parties') }}">Jouer une partie</a>
</div>
@endsection
