  @extends('layouts.app')
  @section('content')
  <div id="connexion-page">
    <a href="{{ url('/login') }}">Login</a>
    <a href="{{ url('/register') }}">Register</a>
  </div>
  @endsection
