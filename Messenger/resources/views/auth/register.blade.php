@extends('layouts.app')
@section ('css')
        <link rel="stylesheet" type="text/css" href="/content/login.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@section('content')

<form method="POST" action="{{ route('register') }}">
    @csrf                       
    <p id="connectez" >Enregistrez-vous</p>
    <label for="name" >nom</label>                          
    <input id="name" type="text"  name="name" >
                        
    <label for="email" >{{ __('E-Mail Address') }}</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">

    <label for="password" >{{ __('Password') }}</label>                        
    <input id="password" type="password" name="password" required autocomplete="new-password">

    <label for="password-confirm" >{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password"  name="password_confirmation" required autocomplete="new-password">
    
    <input id="sub" type="submit" value="{{ __('Login') }}">

    <div class="g-recaptcha" data-sitekey="6Lc7yf4aAAAAAG0jkzTIv9OskUglx6vwzgtEAPK1" data-callback="onSuccess" ></div>
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
