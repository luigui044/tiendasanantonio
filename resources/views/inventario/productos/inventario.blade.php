@extends('layouts.master')

@section('titulo', 'Inventario productos')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Inventario de productos</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('addInventario') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <label for="categoria">Seleccione un producto:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select select2" id="producto" name="producto" data-placeholder="Seleccione un producto">
                                                <option></option>
                                                @foreach ($productos as $item)
                                                    <option value="{{ $item->id_prod }}">{{ $item->producto }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="cantidad">Cantidad:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('cantidad') is-invalid @enderror"
                                                placeholder="Cantidad" id="cantidad" name="cantidad"
                                                value="{{ old('cantidad') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('cantidad')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="uMedida">Unidad de medida:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('uMedida') is-invalid @enderror"
                                                placeholder="Unidad de medida" id="uMedida" name="uMedida"
                                                value="{{ old('uMedida') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('uMedida')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="categoria">Seleccione una ubicación:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select select2" id="ubicacion" name="ubicacion" data-placeholder="Seleccione una ubicación">
                                                @foreach ($bodegas as $item)
                                                    <option value="{{ $item->id_bodega }}">{{ $item->bodega }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-regular fa-floppy-disk me-2"></i>
                                    Guardar
                                </button>
                                <a href="{{ route('submodulo.hijos', 2) }}" class="btn btn-success mt-3 ms-3">
                                    <i class="fa-solid fa-left-long me-2"></i>
                                    Volver
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Inventario</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Cantidad</th>
                                            <th class="text-white">Bodega</th>
                                            <th class="text-white">Última fecha de actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventarios as $item)
                                            <tr>
                                                <td>{{ $item->producto }}</td>
                                                <td>{{ $item->cantidad }}</td>
                                                <td> {{ $item->bodega }} </td>
                                                <td> {{ $item->fecha_actualizacion }} </td>
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
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection                                                                                                                                                                                 
