@extends('layouts.master')

@section('titulo','Roles de usuario')

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
                            <form method="POST" action="{{ route('actRol') }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="user">Seleccione un usuario:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="user" name="user">
                                                @foreach ($usuarios as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="rol">Seleccione un rol:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="rol" name="rol">
                                                @foreach ($rol as $item)
                                                    <option value="{{$item->id_rol}}">{{$item->desc_rol}}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-gear me-2"></i>
                                    Actualizar
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
