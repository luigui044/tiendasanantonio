@extends('layouts.master')

@section('titulo', 'Clientes')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Agregar cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('addCliente') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="nombre">Nombre:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                placeholder="Nombre del cliente" id="nombre" name="nombre"
                                                value="{{ old('nombre') }}" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('nombre')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="telefono">Teléfono:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror"
                                                placeholder="Teléfono del cliente" id="telefono" name="telefono"
                                                value="{{ old('telefono') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('telefono')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="dui">DUI:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('dui') is-invalid @enderror"
                                                placeholder="DUI" id="dui" name="dui" value="{{ old('dui') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('dui')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="credito_fiscal">Crédito fiscal:</label>
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="chk-credito-fiscal" name="chk_credito"
                                                        class="form-check-input">
                                                </div>
                                            </div>
                                            <div class="form-group position-relative has-icon-left w-100">
                                                <input type="text"
                                                    class="form-control @error('credito_fiscal') is-invalid @enderror"
                                                    placeholder="Crédito fiscal" id="credito_fiscal" name="credito_fiscal"
                                                    value="{{ old('credito_fiscal') }}" disabled>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('credito_fiscal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="direccion" class="form-label">
                                            Dirección
                                        </label>
                                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3">{{ old('direccion') }}</textarea>
                                        @error('direccion')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-plus me-2"></i>
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
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Listado de usuarios del sistema</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">Nombre</th>
                                            <th class="text-white">Tipo de cliente</th>
                                            <th class="text-white">Estado</th>
                                            <th class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientes as $item)
                                            <tr>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->t_cliente }}</td>
                                                <td>{{ $item->estado }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('detaCliente', $item->id_cliente) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                                            Editar
                                                        </a>
                                                        <form action="{{ route('clientes.eliminar', $item->id_cliente) }}" method="POST" class="d-none" id="frm-eliminar-{{ $item->id_cliente }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                        <button type="submit" class="btn btn-sm btn-danger ms-2 btn-eliminar" form="frm-eliminar-{{ $item->id_cliente }}">
                                                            <i class="fa-solid fa-trash-can me-2"></i>
                                                            Eliminar
                                                        </button>
                                                    </div>
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
    </section>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/pages/clientes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/eliminar-registro.js') }}"></script>
@endsection
