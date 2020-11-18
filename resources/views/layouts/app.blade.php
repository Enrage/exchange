<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  </head>
  <body>
    <main>
      @yield('content')
    </main>
    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>