@extends('layouts.master')

@section('titulo', 'Productos')
@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
                                    <div class="col-6">
                                        <label for="bangranel">Producto a granel:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="checkbox" id="bangranel" name="bangranel" value="1">
                                        </div>  
                                    </div>
                                    <div class="col-6">
                                        <label for="banexcento">Producto sencillo:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="checkbox" id="banexcento" name="banexcento" value="1">
                                        </div>  
                                    </div>
                                </div>

                                {{-- <div class="row">
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
                                </div> --}}
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
                                {{-- <div class="row">
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
                                </div> --}}
                                {{-- <div class="row">
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
                                </div> --}}

                                <div class="row mt-2">

                                    <div class="col-12">
                                        <label for="unidad_medida">Unidad de medida:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" 
                                                class="form-control @error('unidad_medida') is-invalid @enderror"
                                                placeholder="Unidad de medida" id="unidad_medida" name="unidad_medida"
                                                value="{{ old('unidad_medida') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-rulers"></i>
                                            </div>
                                        </div>
                                        @error('unidad_medida')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="unidad_medida_hacienda">Unidad de medida regla:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="unidad_medida_hacienda" name="unidad_medida_hacienda">
                                                @foreach ($unidades as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12">
                                        <label for="cod_bar">Código de barras:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('cod_bar') is-invalid @enderror" placeholder="Código de barras"
                                                id="cod_bar" name="cod_bar" value="{{ old('cod_bar') }}">
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
                                                   <th class="text-white">Unidad de medida</th>
                                            <th class="text-white">Opciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productos as $item)
                                            <tr id="producto-{{ $item->id_prod }}">
                                                <td>{{ $item->cod_bar }}</td>
                                                <td>{{ $item->producto }}</td>
                                                <td>${{ number_format($item->precio, 2) }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                 <td>{{ $item->unidad_medida }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('detaProd', $item->id_prod) }}"
                                                            class="btn btn-success"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar el producto">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>

                                                        <a type="button" 
                                                            class="btn btn-danger eliminar-producto" 
                                                            onclick="eliminarProducto( {{ $item->id_prod }})"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Eliminar el producto">
                                                            <i class="fa-solid fa-trash-can"></i>
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

@section('scripts')
    <script>
        function eliminarProducto(id) {
                console.log(id);
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar este producto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/prod/eliminar/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'Producto eliminado correctamente',
                                        'success'
                                    ).then(() => {
                                        document.getElementById(`producto-${id}`).remove();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'Error al eliminar el producto',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error al eliminar el producto:', error);
                                Swal.fire(
                                    'Error',
                                    'Ha ocurrido un error al procesar la solicitud',
                                    'error'
                                );
                            });
                    }
                });
            }


    document.addEventListener('DOMContentLoaded', function () {
        const codBarInput = document.getElementById('cod_bar');

        if (codBarInput) {
            codBarInput.addEventListener('keydown', function (event) {
                // Si se presiona Enter
                if (event.key === 'Enter') {
                    event.preventDefault(); // evita que se envíe el formulario
                    // Puedes mover el foco al siguiente campo si lo deseas
                    document.getElementById('unidad_medida')?.focus();
                }
            });
        }
    });
</script>
@endsection