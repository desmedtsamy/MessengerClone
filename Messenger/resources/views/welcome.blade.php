@extends('layouts.app')
    @section ('css')
        <link rel="stylesheet" type="text/css" href="/content/main.css">
    @endsection
    @section('content')
<div id="center">
    <h1>{{ strtoupper(config('app.name', 'Laravel')) }}</h1>
    <a href="/register">s'enregister</a>
    <a href="/login">Se connecter</a>
</div>
        
    @endsection