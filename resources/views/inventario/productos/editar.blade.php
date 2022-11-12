@extends('layouts.master')

@section('titulo', 'Editar producto')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row justify-content-center match-height">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Editar producto</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('modProd', $id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label for="producto">Producto:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('producto') is-invalid @enderror"
                                                placeholder="Producto" id="producto" name="producto"
                                                value="{{ $producto->producto }}" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('producto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="categoria">Categoría:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="categoria" name="categoria">
                                                @foreach ($categorias as $item)
                                                    <option value="{{ $item->id_categoria }}" @if ($item->id_categoria == $producto->categoria) selected @endif>
                                                        {{ $item->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="estado">Estado:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="1" @if ($producto->estado == 1) selected @endif>
                                                    Activo</option>
                                                <option value="2" @if ($producto->estado == 2) selected @endif>
                                                    Inactivo</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="precio">Precio ($):</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('precio') is-invalid @enderror"
                                                placeholder="Precio ($)" id="precio" name="precio"
                                                value="{{ number_format($producto->precio, 2) }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('precio')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="descuento">Porcentaje de descuento (%):</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('descuento') is-invalid @enderror"
                                                placeholder="Descuento (%)" id="descuento" name="descuento"
                                                value="{{ $producto->descuento*100 }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('descuento')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="proveedor">Proveedor:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="proveedor" name="proveedor">
                                                @foreach ($proveedores as $item)
                                                    <option value="{{ $item->id_proveedor }}"
                                                        @if ($item->id_proveedor == $producto->proveedor) selected @endif>
                                                        {{ $item->razon_social }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="descripcion" class="form-label">
                                            Descripción
                                        </label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                            rows="3">{{ $producto->descripcion }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="cod_bar">Código de barras:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('cod_bar') is-invalid @enderror"
                                                placeholder="Código de barras" id="cod_bar" name="cod_bar"
                                                value="{{ $producto->cod_bar }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('cod_bar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                    Actualizar
                                </button>
                                <a href="{{ route('operacion', 10) }}" class="btn btn-success mt-3 ms-3">
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
