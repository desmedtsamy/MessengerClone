@extends('layouts.app')
@section ('css')
        <link rel="stylesheet" type="text/css" href="/content/login.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@section('content')

<form method="POST" action="{{ route('login') }}">
    @csrf
    <p id="connectez" >Connectez-vous</p>
   
    <label for="email">{{ __('E-Mail Address') }}</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

    <label for="password">{{ __('Password') }}</label>
    
    <input id="password" type="password" name="password" required autocomplete="current-password">
    <div class="g-recaptcha" data-sitekey="6Lc7yf4aAAAAAG0jkzTIv9OskUglx6vwzgtEAPK1" data-callback="onSuccess" ></div>
    <input type="submit" value="{{ __('Login') }}" id="sub">
    <p id="accesrapdide">Accès rapide avec</p>
    <div id="loginZone">
    <a href="/auth/redirect"><img src="/content/img/google.svg" class="loginImage"></a>
    </div>
</form>

<script >
    $(document).ready(function(){
        $('#sub').hide();
    });
    var onSuccess = function(response) {
        $('#sub').show();
        $('.g-recaptcha').hide();
    }
</script>
@endsection
