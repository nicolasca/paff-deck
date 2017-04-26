  @extends('layouts.app')
  @section('content')
  <div id="connexion-page">
    <a class="card" href="{{ url('/login') }}">Login</a>
    <a class="card" href="{{ url('/register') }}">Register</a>
  </div>
  @endsection
