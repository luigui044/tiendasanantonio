@extends('layouts.master')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('titulo', 'Venta consumidor final')

@section('contenido')
    <div class="row p-md-5">
        <div class="d-flex mb-4">
            <a href="{{ route('ventas.inicio') }}" class="btn btn-lg btn-primary me-2">
                <i class="fa-solid fa-cart-shopping me-3"></i>
                Listado de ventas
            </a>
            {{-- <a href="" class="btn btn-lg btn-success ms-2 me-2" id="btn-escanear">
                <i class="fa-solid fa-barcode me-3"></i>
                Escanear código de barras
            </a> --}}
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#info-venta" type="button" role="tab"
                    aria-controls="info-venta" aria-selected="false">Lista de compra</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#info-cliente"
                    type="button" role="tab" aria-controls="info-cliente" aria-selected="true">Información de la
                    venta</button>
            </li>

        </ul>

        <form method="POST" action="{{ route('ventas.crear.post') }}">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade " id="info-cliente" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="row mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Información de la venta</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row">
                                                @if (count($clientes) > 0)
                                                    <div class="col-12 col-lg-6">
                                                        <label for="cliente">Cliente:</label>
                                                        <fieldset class="form-group">
                                                            <select name="cliente" id="cliente" class="form-control"
                                                                required>
                                                                <option value="">Seleccione un cliente:</option>
                                                                @foreach ($clientes as $cliente)
                                                                    <option value="{{ $cliente->id_cliente }}">
                                                                        {{ $cliente->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 d-flex">
                                                    <div class="form-check">
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="chk-cliente">
                                                            <label for="chk-cliente"></label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="cliente-nuevo">Nuevo cliente:</label>
                                                        <input name="cliente_nuevo" id="cliente-nuevo"
                                                            class="form-control mb-4" type="text" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <label for="comentarios">Comentarios:</label>
                                                    <textarea id="comentarios" class="form-control" name="comentarios"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="info-venta" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="row mt-4">
                    <div class="col-12 col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Lista de compra</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!--Table-->
                                        <table id="tb-productos-agregados" class="table table-sm table-hover mb-0">
                                            <!--Table head-->
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">
                                                        Cantidad
                                                    </th>
                                                    <th class="th-sm">
                                                        Producto
                                                    </th>
                                                    <th class="th-sm">
                                                        Aplicar descuento (%)
                                                    </th>
                                                    <th class="th-sm">
                                                        Subtotal ($)
                                                    </th>
                                                    <th class="th-sm">
                                                        Eliminar
                                                    </th>
                                                </tr>
                                            </thead>
                                            <!--Table head-->
                                            <!--Table body-->
                                            <tbody>
                                            </tbody>
                                            <!--Table body-->
                                        </table>
                                    </div>
                                    <!--Table-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Agregar productos</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!--Table-->
                                        <table id="paginacion" class="table table-sm table-hover">
                                            <!--Table head-->
                                            <thead>
                                                <tr>
                                                    <th class="d-none">
                                                        ID
                                                    </th>
                                                    <th class="th-sm d-none">
                                                        Producto
                                                    </th>
                                                    <th class="th-sm d-none">
                                                        Categoría
                                                    </th>
                                                    <th class="th-sm d-none">
                                                        Precio ($)
                                                    </th>
                                                    <th class="th-sm d-none">
                                                        Descuento (%)
                                                    </th>
                                                    <th class="th-sm d-none">
                                                        Código de barras
                                                    </th>
                                                    <th class="th-sm text-center">
                                                        Producto
                                                    </th>
                                                    <th class="th-sm text-center">
                                                        Agregar
                                                    </th>
                                                </tr>
                                            </thead>
                                            <!--Table head-->
                                            <!--Table body-->
                                            <tbody>
                                                @foreach ($productos as $producto)
                                                    <tr class="fila-producto">
                                                        <td class="id-producto">{{ $producto->id_prod }}</td>
                                                        <td class="producto" id="d-none">{{ $producto->producto }}</td>
                                                        <td id="d-none">{{ $producto->categoria }}</td>
                                                        <td class="precio" id="d-none">${{ number_format($producto->precio, 2) }}</td>
                                                        <td class="descuento" id="d-none">
                                                            {{ number_format($producto->descuento * 100, 2) }}%
                                                        </td>
                                                        <td id="d-none">{{ $producto->cod_bar }}</td>
                                                        <td>
                                                            <div class="info-producto">
                                                                <p class="titulo">{{ $producto->producto }}</p>
                                                                <p class="categoria"><b>Categoría:</b> {{ $producto->categoria }}</p>
                                                                <p class="info-precio">Precio: ${{ number_format($producto->precio, 2) }}</p>
                                                                <p class="info-desc">Descuento: {{  number_format($producto->descuento * 100, 2) }}%</p>
                                                                <p class="cod"><b>Código:</b> {{ $producto->cod_bar }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <button type="button" class="agregar-producto">
                                                                <i class="fa-solid fa-circle-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <!--Table body-->
                                        </table>
                                        <!--Table-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="datos-venta">
        <div>
            <label for="total">Total: ($)</label>
            <input type="text" id="total" name="total" class="form-control" placeholder="0.00" required
                readonly>
        </div>
        <div>
            <label for="monto">Monto entregado por cliente: ($)</label>
            <input type="text" id="monto" name="monto" class="form-control" placeholder="0.00" required
                disabled>
        </div>
        <div>
            <label for="cambio">Cambio: ($)</label>
            <input type="text" id="cambio" name="cambio" class="form-control" placeholder="0.00" readonly>
        </div>
        <div>
            <button type="submit" id="realizar-venta" class="btn btn-lg btn-primary" disabled>
                <i class="fa-solid fa-basket-shopping me-3"></i>
                Realizar venta
            </button>
        </div>
    </div>
    </form>
    </div>

    <div class="espacio"></div>
    <!-- Modal -->
    <div class="modal fade" id="modal-descuento" tabindex="-1" aria-labelledby="titulo-descuento" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="titulo-descuento"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="precio-descuento" class="mb-3"></h5>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="desc1"
                            placeholder="Descuento en dólares ($):">
                        <label for="desc1">Descuento en dólares ($):</label>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="desc2"
                            placeholder="Descuento en dólares ($):">
                        <label for="desc2">Porcentaje de descuento (%):</label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="aplicar-descuento"
                        data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/pages/ventas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/codigo-barras.js') }}"></script>

    <script>
    const buscador = document.querySelector('input[type="search"]');

        window.onload = function () {
            setTimeout(function () {
                buscador.focus();
            }, 500); // Un pequeño retraso para asegurar que el DataTable cargó correctamente
        }
    </script>
@endsection
