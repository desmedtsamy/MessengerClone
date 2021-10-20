<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="/content/img/logo.svg" />
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles --> 
    <link rel="stylesheet" type="text/css" href="/content/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('css')
    
</head>
<body>
        <header>
                   
                        @guest

                        @else
                        
                        <a href="{{ url('/') }}" id="title">
                            {{ strtoupper(config('app.name', 'Laravel')) }}
                        </a>
                    
                        <div class="dropdown">
                        <button class="dropbtn">{{ Auth::user()->name }} <i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-content">
                        <a href="/logout">logout</a>
                        </div>
                        </div>
                        @endguest

        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
