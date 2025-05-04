@extends('layouts.master')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('titulo', 'Venta ' . ($tipoCliente == 1 ? 'consumidor final' : 'crédito fiscal'))

@section('contenido')

            <div class="row mt-4">
                <div class="col-12 text-center">

                    <h1 class="text-uppercase">
                        @if($tipoCliente == 1)
                            Venta consumidor final
                        @elseif($tipoCliente == 2) 
                            Venta crédito fiscal
                        @endif

                    </h1>

                </div>
                <div class="col-12">
                    <div class="d-flex mb-4">
                        @if(auth()->user()->rol == 1 || auth()->user()->rol == 2)
                            <a href="{{ route('ventas.inicio') }}" class="btn btn-lg {{ $tipoCliente == 1 ? 'btn-primary' : 'btn-success' }} me-2">
                                <i class="fa-solid fa-cart-shopping me-3"></i>
                                Listado de ventas
                            </a>
                        @endif
                        <a href="#" onclick="guardarVenta()" class="btn btn-lg {{ $tipoCliente == 1 ? 'btn-primary' : 'btn-success' }} me-2">
                            <i class="fa-solid fa-save me-3"></i>
                            Guardar venta   
                        </a>
                    </div>
                </div>
            </div>
        <form id="form-venta" method="POST" action="{{ route('ventas.crear.post') }}" >
            @csrf
            <input type="hidden" name="tipo_venta" value="{{ $tipoCliente }}">
                    <div class="row mt-1" id="paso1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Paso 1: Lista de compra</h4> 
                                </div>

                                <div class="card-content">
                                    <div class="card-body">
                                          <div class="row mb-3">
                                            <div class="col-12 col-lg-12">
                                                <select id="select-producto" class="form-control select2" data-placeholder="Buscar producto por nombre o código...">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            {{-- <div class="col-6 col-lg-2">
                                                <input type="number" id="cantidad-producto" class="form-control" placeholder="Cantidad" min="0.25" step="0.01" disabled>
                                            </div>
                                            <div class="col-12 col-lg-2 mt-2">
                                                <button type="button" id="agregar-producto" class="btn btn-primary w-100">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </button>
                                            </div> --}}
                                        </div>
                                        {{-- <div class="input-group mb-3">

                                            <input type="number" id="buscar-producto" class="form-control" placeholder="Ingrese código de barras">

                                            <button class="btn btn-primary" type="button" id="btn-buscar-producto">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                        </div> --}}

                                        @if(isset($venta))
                                            {{ $venta }}
                                        @endif
                                        <div class="table-responsive">
                                            <table id="tb-productos-agregados" class="table table-sm table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">Cantidad</th>
                                                        <th class="th-sm">Producto</th>
                                                        <th class="th-sm">Código de barras</th>
                                                        <th class="th-sm">Precio ($)</th>
                                                        {{-- <th class="th-sm">Aplicar descuento (%)</th> --}}
                                                        <th class="th-sm">Subtotal ($)</th>
                                                        <th class="th-sm">Eliminar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="productos-lista">
                                                    @if(isset($venta))

                                                        @foreach($venta->eldetalle as $detalle)
                                                            <tr>
                                                                <td>{{ $detalle->cantidad }}</td>
                                                                <td>{{ $detalle->elproducto->producto }}</td>
                                                                <td>{{ $detalle->elproducto->cod_bar }}</td>
                                                                <td>{{ $detalle->precio }}</td>
                                                                <td>{{ $detalle->subtotal }}</td>
                                                                <td><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-primary" id="continuar-paso1">Continuar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4" id="paso2" style="display:none;">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Paso 2: Finalizar venta</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-4 mb-3">
                                            <label for="monto" class="form-label fw-bold text-primary">*Monto entregado: ($)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                                <input type="number" step="0.01" id="monto" name="monto" class="form-control border-primary" placeholder="0.00" required disabled>
                                            </div>
                                        </div>
                                        @if (count($clientes) > 0)
                                            <div class="col-4 col-lg-6">
                                                <label for="cliente" class="form-label fw-bold text-primary">*Cliente:</label>
                                                <fieldset class="form-group">
                                                    <select name="cliente" id="cliente" class="form-select border-primary" required>
                                                        <option value="">Seleccione un cliente:</option>
                                                        @foreach ($clientes as $cliente)
                                                            <option value="{{ $cliente->id_cliente }}" {{ ($tipoCliente == 1 && $cliente->id_cliente == 19) ? 'selected' : '' }}>
                                                                {{ $cliente->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        @endif
                                        {{-- @if(auth()->user()->rol == 1)
                                            <div class="col-4 col-lg-6">
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn {{ $tipoCliente == 1 ? 'btn-primary' : 'btn-success' }} " data-bs-toggle="modal" data-bs-target="#modal-nuevo-cliente">
                                                        <i class="fa-solid fa-user-plus me-2"></i>
                                                        Agregar nuevo cliente
                                                    </a>
                                                </div>
                                            </div>
                                        @endif --}}
                                        <div class="col-12 col-md-4 mb-3">
                                            <label for="total">Total: ($)</label>
                                            <input type="text" id="total" name="total" class="form-control" placeholder="0.00" required readonly>
                                        </div>

                                        <div class="col-12 col-md-4 mb-3">
                                            <label for="cambio">Cambio: ($)</label>
                                            <input type="text" id="cambio" name="cambio" class="form-control" placeholder="0.00" readonly>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" id="anterior-paso2">Anterior</button>
                                                <button type="submit" id="realizar-venta" class="btn btn-lg btn-primary" disabled>
                                                    <i class="fa-solid fa-basket-shopping me-3"></i>
                                                    Realizar venta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 


            <div class="espacio"></div>

            <div class="modal fade" id="modal-descuento" tabindex="-1" aria-labelledby="titulo-descuento" aria-hidden="true" style="z-index: 10001;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="titulo-descuento"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 id="precio-descuento" class="mb-3"></h5>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="desc1" placeholder="Descuento en dólares ($):">
                                <label for="desc1">Descuento en dólares ($):</label>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="desc2" placeholder="Descuento en dólares ($):">
                                <label for="desc2">Porcentaje de descuento (%):</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" id="aplicar-descuento" data-bs-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    <div class="modal fade " id="modal-nuevo-cliente" tabindex="-1" aria-labelledby="titulo-nuevo-cliente"
        aria-hidden="true" style="z-index: 10001;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-nuevo-cliente">Nuevo cliente</h5>
                </div>
                <div class="modal-body">
                    @if($tipoCliente == 1)
                        @include('inventario.clientes.components.form-clientes', ['inventario' => false, 'credito_fiscal' => false, 'readonly' => true])
                    @elseif($tipoCliente == 2)
                        @include('inventario.clientes.components.form-clientes', ['inventario' => false, 'credito_fiscal' => true, 'readonly' => true])
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        const productosDisponibles = @json($productos);
  

    </script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/codigo-barras.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/pages/clientes.js') }}"></script>

@endsection
