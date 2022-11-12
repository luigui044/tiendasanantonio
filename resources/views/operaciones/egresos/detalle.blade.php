@extends('layouts.master')

@section('titulo', 'Detalle egreso')

@section('contenido')
    <div class="row p-md-5">
        <div class="col-12 col-md-2 mb-4">
            <a href="{{ route('operacion', 12) }}" class="btn btn-lg btn-primary">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Nuevo egreso
            </a>
        </div>
        <div class="col-12 col-md-3 mb-4">
            <a href="{{ route('ventas.inicio') }}" class="btn btn-lg btn-success">
                <i class="fa-solid fa-money-bill-1-wave me-3"></i>
                Listado de egresos
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detalle del egreso</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <h5>Concepto: {{ $egreso->concepto }}</h5>
                        <h6>Monto: ${{ number_format($egreso->monto, 2) }} </h6>
                        <h6>Fecha: {{ date_format(date_create($egreso->fecha), 'd/m/Y') }}</h6>
                        <hr>
                        <a href="{{ route('egresos.inicio') }}" class="btn btn-success">
                            <i class="fa-solid fa-left-long me-1"></i>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
