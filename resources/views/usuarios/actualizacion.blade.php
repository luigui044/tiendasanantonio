@extends('layouts.master')

@section('titulo', 'Actualizar información')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Editar información usuario</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('actUser2', $id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="name">Nombre:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Ingrese un nombre" id="name" name="name"
                                                value="{{ $usuario->name }}" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">Usuario:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Ingrese un nombre de usuario" id="email" name="email"
                                                value="{{ $usuario->email }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="estado">Estado:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="1" @if ($usuario->ban_estado == 1) selected @endif>
                                                    Activo</option>
                                                <option value="2" @if ($usuario->ban_estado == 2) selected @endif>
                                                    Inactivo</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="rol">Indique un rol:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="rol" name="rol">
                                                @foreach ($rol as $item)
                                                    <option value="{{ $item->id_rol }}"
                                                        @if ($usuario->rol == $item->id_rol) selected @endif>
                                                        {{ $item->desc_rol }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-pen me-2"></i>
                                    Actualizar
                                </button>
                                <a href="{{ route('operacion', 7) }}" class="btn btn-success mt-3 ms-3">
                                    <i class="fa-solid fa-left-long me-2"></i>
                                    Volver
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if (session('mensaje2'))
                <div class="alert alert-success">{{ session('mensaje2') }}</div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Reestablecer contraseña</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('resetpass', $id) }}">
                            @method('PUT')
                            @csrf
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fa-solid fa-key me-2"></i>
                                Reestablecer contraseña
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
