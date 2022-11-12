@extends('layouts.master')

@section('titulo', 'Editar cliente')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Editar cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('modCliente', $id) }}}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="nombre">Nombre:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                placeholder="Nombre del cliente" id="nombre" name="nombre"
                                                value="{{ $cliente->nombre }}" autofocus>
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
                                                value="{{ $cliente->telefono }}">
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
                                        <label for="direccion" class="form-label">
                                            Dirección
                                        </label>
                                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3">{{ $cliente->direccion }}</textarea>
                                        @error('direccion')
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
                                                        class="form-check-input" @if($cliente->tipo_cliente == 2) checked @endif>
                                                </div>
                                            </div>
                                            <div class="form-group position-relative has-icon-left w-100">
                                                <input type="text"
                                                    class="form-control @error('credito_fiscal') is-invalid @enderror"
                                                    placeholder="Crédito fiscal" id="credito_fiscal" name="credito_fiscal"
                                                    value="{{ $cliente->credito_fiscal }}" disabled>
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
                                    <div class="col-sm-6">
                                        <label for="dui">DUI:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('dui') is-invalid @enderror"
                                                placeholder="DUI" id="dui" name="dui"
                                                value="{{ $cliente->dui }}">
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
                                        <label for="estado">Estado:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="1" @if ($cliente->estado == 1) selected @endif>Activo</option>
                                                <option value="2" @if ($cliente->estado == 2) selected @endif>Inactivo</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-pen me-2"></i>
                                    Actualizar
                                </button>
                                <a href="{{ route('operacion', 8) }}" class="btn btn-success mt-3 ms-3">
                                    <i class="fa-solid fa-left-long me-2"></i>
                                    Volver
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/pages/clientes.js') }}"></script>
@endsection

