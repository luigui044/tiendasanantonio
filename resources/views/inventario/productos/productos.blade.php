@extends('layouts.master')

@section('titulo', 'Productos')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Agregar producto</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('addProd') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label for="producto">Producto:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('producto') is-invalid @enderror"
                                                placeholder="Producto" id="producto" name="producto"
                                                value="{{ old('producto') }}" autofocus>
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
                                                    <option value="{{ $item->id_categoria }}">
                                                        {{ $item->categoria }}
                                                    </option>
                                                @endforeach
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
                                                value="{{ old('precio') }}">
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
                                                value="{{ old('descuento') }}">
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
                                                    <option value="{{ $item->id_proveedor }}">
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
                                            rows="3">{{ old('descripcion') }}</textarea>
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
                                                value="{{ old('cod_bar') }}">
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
                                    <i class="fa-solid fa-circle-plus me-2"></i>
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
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Productos registrados</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">SKU</th>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Precio</th>
                                            <th class="text-white">Descripción</th>
                                            <th class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productos as $item)
                                            <tr>
                                                <td>{{ $item->id_prod }}</td>
                                                <td>{{ $item->producto }}</td>
                                                <td>${{ number_format($item->precio, 2) }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('detaProd', $item->id_prod) }}"
                                                            class="btn btn-success">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                                            Editar
                                                        </a>
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

