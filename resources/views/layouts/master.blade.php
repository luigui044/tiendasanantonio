<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') | Tienda San Antonio</title>
    @yield('csrf')
    @include('layouts.styles')
</head>

<body>
    <div class="container_fluid">
        @include('layouts.componentes.navbar')
        @include('layouts.componentes.sidebar')
        @include('layouts.componentes.boton-sidebar')
        @yield('contenido')
    </div>
    
    @include('layouts.scripts')
    @include('partials.mensajes')
</body>

</html>