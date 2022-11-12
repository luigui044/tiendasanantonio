@extends('layouts.master')

@section('titulo', 'Egresos')

@section('contenido')
    <div class="row p-md-5">
        <div class="row mb-4">
            <div class="col-12 col-md-4">
                <a href="{{ route('egresos.inicio') }}" class="btn btn-lg btn-primary">
                    <i class="fa-solid fa-money-bill-1-wave me-3"></i>
                    Listado de egresos
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Registrar egreso</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('egresos.crear.post') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="concepto">Concepto:</label>
                                            <input name="concepto" id="concepto" class="form-control mb-4" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="monto">Monto:</label>
                                            <input name="monto" id="monto" class="form-control mb-4" type="number">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="fecha">Fecha:</label>
                                            <input name="fecha" id="fecha" class="form-control mb-4" type="date">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-regular fa-floppy-disk me-1"></i>
                                    Guardar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
