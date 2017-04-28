  @extends('layouts.app')
  @section('content')
  <div id="connexion-page">
    <a class="card button" href="{{ url('/login') }}">Me connecter</a>
    <a class="card button" href="{{ url('/register') }}">M'enregistrer</a>
  </div>
  @endsection
