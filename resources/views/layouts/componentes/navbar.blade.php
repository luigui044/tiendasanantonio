<nav class="navbar navbar-expand-lg  navbar-dark bg-negro">
    <div class="container-fluid bg-negro">
        <a class="navbar-brand" href="{{ route('inicio') }}">Tienda San Antonio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('inicio') }}">
                        <i class="fa-solid fa-house-chimney me-1"></i>
                        Inicio
                    </a>
                </li>
                @if (auth()->user()->rol == 1)
                    <li class="nav-item">
                        <a class="nav-link d-flex" href="{{ route('submodulo.hijos', 1) }}">
                            <i class="fa-solid fa-users me-1"></i>
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('submodulo.hijos', 2) }}">
                            <i class="fa-solid fa-cart-flatbed me-1"></i>
                            Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('submodulo.hijos', 4) }}">
                            <i class="fa-solid fa-chart-line me-1"></i>
                            Resumen gerencial
                        </a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-cash-register me-1"></i>
                        Operaciones de caja
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('operacion', 12) }}">Venta consumidor final</a></li>
                        <li><a class="dropdown-item" href="#">Venta crédito fiscal</a></li>
                        <li><a class="dropdown-item" href="{{ route('operacion', 14) }}">Egresos</a></li>
                    </ul>
                </li>

            </ul>
            <div>
                <form method="POST" action="{{ route('logout') }}" class="d-none" id="frm-logout">@csrf</form>
                <button type="submit" form="frm-logout" class="btn btn-danger bg-rojo">
                    <i class="fa-solid fa-power-off me-1"></i>
                    Salir
                </button>
            </div>
        </div>
    </div>
</nav>
