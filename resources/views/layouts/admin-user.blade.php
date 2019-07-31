<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal de Empleo - ConTabilizalo.com</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">       
      
  </head>
  <body>    
    @yield('content')    
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
