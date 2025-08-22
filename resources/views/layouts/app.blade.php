<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Calzado Nueva Era')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <meta name="theme-color" content="#111827">
</head>
<body class="min-h-full bg-white text-gray-700 antialiased">
  @include('partials.header')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  @stack('modals')
  @stack('scripts')
</body>
</html>
