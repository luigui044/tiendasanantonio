@extends('layouts.master')

@section('titulo', 'Egresos')

@section('contenido')
    <div class="row p-md-5">
        <div class="col-12 col-md-3 mb-4">
            <a href="{{ route('egresos.crear.get') }}" class="btn btn-lg btn-primary">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Registrar Egreso
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Listado de egresos</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg table-striped table-hover">
                                <thead class="bg-rojo">
                                    <tr>
                                        <th class="text-white">Concepto</th>
                                        <th class="text-white">Monto ($)</th>
                                        <th class="text-white">Fecha</th>
                                        <th class="text-white">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($egresos as $egreso)
                                        <tr>
                                            <td>{{ $egreso->concepto }}</td>
                                            <td>${{ number_format($egreso->monto, 2) }} </td>
                                            <td>{{ date_format(date_create($egreso->fecha), "d/m/Y") }}</td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('egresos.detalle', $egreso->id_egreso) }}">
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

