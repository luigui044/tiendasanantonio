@extends('layouts.master')

@section('titulo', 'Editar categoría')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Editar categoría</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('modCate', $id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label for="categoria">Categoría:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('categoria') is-invalid @enderror"
                                                placeholder="Categoría" id="categoria" name="categoria"
                                                value="{{ $categoria->categoria }}" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('categoria')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                    Editar categoría
                                </button>
                                <a href="{{ route('operacion', 18) }}" class="btn btn-success mt-3 ms-3">
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
