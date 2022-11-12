@extends('layouts.master2')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', 'Resumen Gerencial')

@section('contenedor')

    <div class="row p-4">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="bodega">Farmacia:</label>
                        <select name="bodega" id="bodega" class="form-control">
                            <option value="0">Todas</option>
                            @foreach ($bodegas as $bodega)
                                <option value="{{ $bodega->id_bodega }}">{{ $bodega->bodega }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="bodega">Tipo de cliente:</label>
                        <select name="cliente" id="cliente" class="form-control">
                            <option value="0">Todos</option>
                            <option value="1">Consumidor final</option>
                            <option value="2">Crédito fiscal</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="anio">Año:</label>
                        <select name="anio" id="anio" class="form-control">
                            <option value="0">Todos</option>
                            @foreach ($aniosVenta as $anio)
                                <option value="{{ $anio->anio }}">{{ $anio->anio }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="mes">Mes:</label>
                        <select name="mes" id="mes" class="form-control">
                            <option value="0">Todos</option>
                            @foreach ($mesesVenta as $mes)
                                <option value="{{ $mes->mes_numero }}">{{ $mes->mes_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <button id="btnFiltroFecha" class="btn btn-success mt-4">
                        Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-4">
        <div class="col-md-6 col-sm-12">
            <div class="card card-cascade">
                <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient">
                    <!-- Title -->
                    <h5 class="card-header-title mb-3">Top 10 de productos más vendidos</h5>
                    <!-- Subtitle -->
                </div>
                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">
                    <div id="topProductos" class="grafico"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-cascade">
                <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient">
                    <!-- Title -->
                    <h5 class="card-header-title mb-3">Ventas consumidor final vs crédito fiscal</h5>
                    <!-- Subtitle -->
                </div>
                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">
                    <div id="ventasVsCf" class="grafico dona"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <div class="card card-cascade">
                <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient">
                    <!-- Title -->
                    <h5 class="card-header-title mb-3">Productos con pocas existencias</h5>
                    <!-- Subtitle -->
                </div>
                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">
                    <div id="productosRojo" class="grafico"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('partials.footer')
    <script type="text/javascript" src="{{ asset('assets/js/graficos.js') }}"></script>
@endsection
