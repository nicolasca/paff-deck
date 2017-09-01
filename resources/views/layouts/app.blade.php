<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PAFF</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
  <link rel="stylesheet" href="{{URL::asset('css/paff-deck.css')}} ">
  <link rel="icon" type="image/png" href="{{URL::asset('./images/favicon.png')}}" />
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Infant" rel="stylesheet">

</head>
<body id="app-layout">

  @if (Auth::check())
  <header>
    <nav role="navigation">
      <ul>
        <li {{{ (Request::is('home') ? 'class=active' : '') }}}>
          <a href="{{ url('/home') }}">Home</a>
        </li >
        <li {{{ (Request::is('mes-decks') ? 'class=active' : '') }}}>
          <a href="{{ url('/mes-decks') }}">Mes Decks</a>
        </li>
        <li {{{ (Request::is('factions') ? 'class=active' : '') }}}>
          <a href="{{ url('/factions') }}">Factions</a>
        </li>
        <li {{{ (Request::is('parties') ? 'class=active' : '') }}}>
          <a href="{{ url('/parties') }}">Parties</a>
        </li>
        <li {{{ (Request::is('resultats') ? 'class=active' : '') }}}>
          <a href="{{ url('/resultats') }}">Résultats</a>
        </li>
        <li {{{ (Request::is('priana') ? 'class=active' : '') }}}>
          <a href="{{ url('/priana') }}">Priana</a>
        </li>
      </ul>
    </nav>
    <div class="">
        <a class="right item" href="{{ url('/profil')}}/{{Auth::user()->id }}"><i class="fa fa-user" aria-hidden="true"></i>{{ Auth::user()->name }}</a>
    </div>
    <div class="">
      <a href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
    </div>

  </header>
    @endif

@yield('content')

<!-- JavaScripts -->
<script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{URL::asset('js/jquery-ui.min.js')}}"></script>
<script src="{{URL::asset('js/anime.min.js')}}"></script>
<script type="application/javascript" src="{{URL::asset('js/paff-deck.js')}}"></script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>

<!--Dynamic StyleSheets added from a view would be pasted here-->
@stack('pusher-script')
@stack('scripts')

</body>
</html>
