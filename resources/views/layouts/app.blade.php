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
  <link rel="stylesheet" href="./paff-deck.css">
  <link rel="icon" type="image/png" href="./images/favicon.png" />

  <!-- Styles -->
  <link rel="stylesheet"  href="paff-deck.css" >
  <style>
  body {
    font-family: 'Lato';
  }

  .fa-btn {
    margin-right: 6px;
  }
  </style>
</head>
<body id="app-layout">

  @if (Auth::check())
    <div class="mlm">
      <a href="{{ url('/home') }}">Home</a>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        {{ Auth::user()->name }} <span class="caret"></span>
      </a>
      <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
  </div>
@endif


@yield('content')

<!-- JavaScripts -->
<script
src="https://code.jquery.com/jquery-3.2.1.min.js"
integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
crossorigin="anonymous"></script>
<script type="text/javascript" src="./paff-deck.js"></script>
</body>
</html>
