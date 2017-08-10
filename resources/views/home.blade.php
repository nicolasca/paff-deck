@extends('layouts.app')
@section('content')
<div id="home">

<div id="dashboard">
  <a class="card button" href="{{ url('/creer-deck') }}">Créer un Deck</a>
  <a class="card button" href="{{ url('/mes-decks') }}">Mes Decks</a>
  <!-- <a class="card button" href="{{ url('/jouer-deck') }}">Jouer un Deck</a> -->
  <a class="card button" href="{{ url('/parties') }}">Parties</a>
  <a class="card button" href="{{ url('/membres') }}">Membres</a>
  <a class="card button" href="{{ url('/resultats') }}">Résultats</a>
</div>

</div>
@endsection
