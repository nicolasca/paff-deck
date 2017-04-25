@extends('layouts.app')

@section('content')

<div id="page-register" class="center">

  <form class="form center w50" method="post" action="{{ url('/register') }}" id="register">
    {{ csrf_field() }}
    <div>
      <p class="form-item center">
        <label for="register_name">Pseudo&nbsp;:</label>
        <input class="form-text" type="text" required="required" name="name" id="register_name" value="{{ old('name') }}" maxlength="20">
          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </p>
      <p class="form-item">
        <label for="register_email">E-mail&nbsp;:</label>
        <input class="form-text" type="email" required="required" name="email" id="register_email" value="{{ old('email') }}" maxlength="50">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </p>
      <p class="form-item">
        <label for="register_password">Mot de passe&nbsp;:</label>
        <input class="form-text" type="password" required="required" name="password" id="register_password">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </p>
      <p class="form-item">
        <label for="password-confirm">Confirmer le mot de passe&nbsp;:</label>
        <input class="form-text" type="password" required="required" name="password_confirmation" id="password-confirm">
        @if ($errors->has('password-confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password-confirmation') }}</strong>
            </span>
        @endif
      </p>
    </div>
    <p class="center"><input class="awesome large green" type="submit" value="Confirmer"></p>
  </form>
</div>

@endsection
