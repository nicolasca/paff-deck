@extends('layouts.app')
@section('content')
<div id="creer-partie">

  <form class="form" action="creer-partie" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <p class="form-item center">
      <label for="name_partie">Nom&nbsp;:</label>
      <input class="form-text" type="text" required="required" name="nom_partie" id="name_partie" maxlength="50">
    </p>
    <p class="form-item">
      <label for="mode_partie">Mode&nbsp;:</label>
      <select class="select" name="mode_partie">
        <option value="classique">Classique</option>
        <option value="escarmouche">Escarmouche</option>
        <option value="epique">Epique</option>
      </select>
    </p>

    <input type="submit" name="Valider" value="Valider" class="button mbm">

  </form>


</div>
@endsection
