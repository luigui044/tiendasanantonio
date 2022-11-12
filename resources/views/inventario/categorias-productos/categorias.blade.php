@extends('layouts.master')

@section('titulo', 'Categorías productos')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Agregar categoría</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if (session('mensaje'))
                                        <div class="alert alert-success">{{ session('mensaje') }}</div>
                                    @endif
                                    <form method="POST" action="{{ route('addCate') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="categoria">Categoría:</label>
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="text"
                                                        class="form-control @error('categoria') is-invalid @enderror"
                                                        placeholder="Categoría" id="categoria" name="categoria"
                                                        value="{{ old('categoria') }}" autofocus>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                                @error('categoria')
                                                    <div class="alert alert-danger">{{ $message }}</div>
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
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Categorías registradas</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">Categoría</th>
                                            <th class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categorias as $item)
                                            <tr>
                                                <td>{{ $item->categoria }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('detaCate', $item->id_categoria) }}"
                                                            class="btn btn-success">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                                            Editar
                                                        </a>
                                                        <form action="{{ route('categorias.eliminar', $item->id_categoria) }}"
                                                            method="POST" class="d-none"
                                                            id="frm-eliminar-{{ $item->id_categoria }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger ms-2 btn-eliminar"
                                                            form="frm-eliminar-{{ $item->id_categoria }}">
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
    <script type="text/javascript" src="{{ asset('assets/js/pages/eliminar-registro.js') }}"></script>
@endsection
