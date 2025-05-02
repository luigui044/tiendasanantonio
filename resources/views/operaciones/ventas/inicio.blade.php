@extends('layouts.master')

@section('titulo', 'Ventas')

@section('contenido')
    <div class="row p-md-5">
        <div class="col-3">
            <a href="{{ route('operacion', 12) }}" class="btn btn-lg btn-primary">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Nueva venta consumidor final
            </a>
        </div>
        <div class="col-3">
            <a href="{{ route('operacion', 13) }}" class="btn btn-lg btn-success">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Nueva venta crédito fiscal
            </a>
        </div>
        @php
            $tieneVentasPendientes = false;
            foreach($ventas as $venta) {
                if($venta->id_usuario == auth()->user()->id && 
                   $venta->estado_venta_id == 1 && 
                   strtotime($venta->fecha_hora) > (time() - (48 * 3600))) {
                    $tieneVentasPendientes = true;
                    break;
                }
            }
        @endphp

        @if($tieneVentasPendientes)
        <div class="col-3">
            {{-- <a href="{{ route('ventas.pendientes') }}" class="btn btn-lg btn-warning">
                <i class="fa-solid fa-clock me-3"></i>
                Ventas pendientes
            </a> --}}
        </div>
        @endif
        
     
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Listado de ventas</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg table-striped table-hover" id="paginacion2">
                                <thead class="bg-rojo">
                                    <tr>
                                        <th class="text-white">Cliente</th>
                                        <th class="text-white">Tipo de venta</th>
                                        <th class="text-white">Total ($)</th>
                                        <th class="text-white">Total + IVA ($)</th>
                                        <th class="text-white">Fecha y hora</th>
                                        <th class="text-white">Vendedor</th>
                                        <th class="text-white">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->nombre_cliente }}</td>
                                            <td>{{ $venta->tipo_venta == 1 ? 'Consumidor final' : 'Crédito fiscal' }}</td>
                                            <td>${{ number_format($venta->total, 2) }} </td>
                                            <td>${{ number_format($venta->total_iva, 2) }}</td>
                                            <td>{{ date_format(date_create($venta->fecha_hora), "d/m/Y - H:i:s") }}</td>
                                            <td>{{ $venta->user->name == '' ? '-' : $venta->user->name }}</td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('ventas.detalle', ['id' => $venta->id_venta, 'imprimir' => false]) }}">
                                                    <i class="fa-solid fa-circle-info me-1"></i>
                                                    Detalles
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

