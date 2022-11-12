@extends('layouts.master')

@section('titulo', 'Modificación de usuarios')

@section('contenido')
    <section class="contenedor-personalizado">
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
                                    <th class="text-white">Usuario</th>
                                    <th class="text-white">Rol</th>
                                    <th class="text-white">Estado</th>
                                    <th class="text-white">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($usuarios as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->rol }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td>
                                        <a href="{{ route('actUser', $item->id) }}" class="btn btn-success">
                                          <i class="fa-regular fa-pen-to-square me-2"></i>
                                          Editar
                                        </a>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
