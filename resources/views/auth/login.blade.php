@extends('layouts.app')

@section('content')
<div id="login-page" class="center">

    <form class="form center w50" role="form" method="POST" action="{{ url('/login') }}">
      {{ csrf_field() }}

      <div>
        <p class="form-item center">
          <label for="name">Pseudo</label>
          <input class="form-text" type="text" required="required" name="name" id="register_name" value="{{ old('name') }}" maxlength="20">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </p>

        <p class="form-item center">
        <label for="password">Mot de passe</label>
          <input class="form-text" type="password" required="required" name="password" id="password">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </p>
      </div>

     <p class="center"><input class="awesome large green" type="submit" value="Se connecter"></p>
    </form>
</div>
@endsection
