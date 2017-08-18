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
    <nav>
      <span><i class="fa fa-user" aria-hidden="true"></i></i> <a href="{{ url('/profil')}}/{{Auth::user()->id }}">{{ Auth::user()->name }}</a> </span>
      <a href="{{ url('/home') }}"><img src="{{URL::asset('images/paff-logo.png')}} " alt="PAFF logo"></a>
      <a href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
    </nav>
  </header>
    @endif

@yield('content')

<!-- JavaScripts -->
<script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{URL::asset('js/jquery-ui.min.js')}}"></script>
<script src="{{URL::asset('js/animate.min.js')}}"></script>
<script type="application/javascript" src="{{URL::asset('js/paff.js')}}"></script>

<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script>
// Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('d93830141cb957ba30fa', {
    cluster: 'eu',
    encrypted: true
  });

</script>
</body>
</html>
