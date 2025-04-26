<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') | Tienda San Antonio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @yield('csrf')
    @include('layouts.styles')
</head>

<body>
    <div id="app">
        @include('layouts.componentes.navbar')
        @include('layouts.componentes.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('encabezado')</h3>
            </div>
            <div class="page-content">
               @yield('contenido')
            </div>

            @include('layouts.componentes.footer')
        </div>  
    </div>
      
        @include('layouts.scripts')
    @include('partials.mensajes')
</body>

</html>