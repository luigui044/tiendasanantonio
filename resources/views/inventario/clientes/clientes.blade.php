@extends('layouts.master')

@section('titulo', 'Clientes')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12 col-lg-5">
                @include('inventario.clientes.components.form-clientes', ['inventario' => true, 'credito_fiscal' => false, 'readonly' => false])
            </div>
            <div class="col-12 col-lg-7">
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
                                            <th class="text-white">Tipo de cliente</th>
                                            <th class="text-white">Estado</th>
                                            <th class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientes as $item)
                                            <tr>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->t_cliente }}</td>
                                                <td>{{ $item->estado }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('detaCliente', $item->id_cliente) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                                            Editar
                                                        </a>
                                                        <form action="{{ route('clientes.eliminar', $item->id_cliente) }}" method="POST" class="d-none" id="frm-eliminar-{{ $item->id_cliente }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                        <button type="submit" class="btn btn-sm btn-danger ms-2 btn-eliminar" form="frm-eliminar-{{ $item->id_cliente }}">
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
    <script type="text/javascript" src="{{ asset('assets/js/pages/clientes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/eliminar-registro.js') }}"></script>
@endsection
