  @extends('layouts.app')
  @section('content')
  <div id="connexion-page">
    <a class="card button" href="{{ url('/login') }}">Login</a>
    <a class="card button" href="{{ url('/register') }}">Register</a>
  </div>
  @endsection
