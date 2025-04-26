<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#0d6efd">
    
    <!-- Iconos para dispositivos -->
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <title>@yield('titulo') | Tienda San Antonio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    @yield('csrf')
    @include('layouts.styles')
</head>

<body>
            @include('layouts.componentes.navbar')
    <div class="container-fluid p-0">

        @include('layouts.componentes.sidebar')
        @include('layouts.componentes.boton-sidebar')
        @yield('contenido')
    </div>

    @include('layouts.scripts')
    @include('partials.mensajes')
</body>

</html>