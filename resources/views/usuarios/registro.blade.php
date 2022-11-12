@extends('layouts.master')

@section('titulo', 'Registro usuarios')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Registro de usuarios</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('registro') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="name">Nombre:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Ingrese un nombre" id="name" name="name"
                                                value="{{ old('name') }}" autofocus>
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
                                                value="{{ old('email') }}">
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
                                        <label for="rol">Indique un rol:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="rol" name="rol">
                                                @foreach ($rol as $item)
                                                    <option value="{{ $item->id_rol }}">{{ $item->desc_rol }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="password">Contraseña:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Ingrese una contraseña" id="password" name="password">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="password-confirm">Confirmar contraseña:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="password" class="form-control"
                                                placeholder="Confirmar contraseña" id="password-confirm"
                                                name="password_confirmation">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-plus me-2"></i>
                                    Crear
                                </button>
                                <a href="{{ route('submodulo.hijos', 1) }}" class="btn btn-success mt-3 ms-3">
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
