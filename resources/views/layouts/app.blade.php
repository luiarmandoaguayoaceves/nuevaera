<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @yield('head')

        

        <!-- Incluye la hoja de estilos de Vite en el <head> -->
        @vite('resources/css/app.css')
    </head>
    
    <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        @yield('navegacion')

        @yield('contenido')

        @yield('footer')
    </body>
</html>
