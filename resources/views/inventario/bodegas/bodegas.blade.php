@extends('layouts.master')

@section('titulo','Proveedores')
@section('styles')
    <style>
        .form-check{
            text-align:left !important;
        }
    </style>
@endsection

@section('contenido')
<div class="row mt-2    ">
    <div class="col-md-5">
        @if (session('mensaje'))
        <div class="alert alert-success">{{session('mensaje')}}</div>
    @endif
            <!-- Default form contact -->
        <form class="text-center border border-light p-5" action="{{route('addBodega')}}" method="POST">
            @csrf
            <p class="h4 mb-4">Agregar bodegas</p>

            <!-- Name -->
            
            
            <div class="md-form">
                <input type="text" id="nombre" name="nombre" class="form-control mb-4" placeholder="Nombre de bodega" required>

            </div>

        
            <div class="md-form">
                <!-- Email -->
                <input type="text" id="telefono" name="telefono" class="form-control mb-4" placeholder="Teléfono" required>
            </div>

            <div class="md-form">
                <!-- Email -->
                <input type="text" id="direccion" name="direccion" class="form-control mb-4" placeholder="Dirección" required>
            </div>
       
        
            <button class="btn btn-info btn-block" type="submit">Registrar Bodega</button>

        </form>
        <!-- Default form contact -->
    </div>

    <div class="col-md-7">
            <!-- Table with panel -->
        <div class="card card-cascade narrower">

            <!--Card image-->
            <div
            class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-center align-items-center">
        
        
            <a href="" class="white-text mx-3 pt-2 pt-2">Bodegas registradas</a>
        
            
        
            </div>
            <!--/Card image-->
        
            <div class="px-4">
        
            <div class="table-wrapper">
                <!--Table-->
                <table id="tbProveedores" class="table table-hover mb-0">
        
                <!--Table head-->
                <thead>
                    <tr>
                    
                    <th class="th-lg">
                        <a>Bodega
                        <i class="fas fa-sort ml-1"></i>
                        </a>
                    </th>
                    <th class="th-lg">
                        <a href="">Ubicación
                        <i class="fas fa-sort ml-1"></i>
                        </a>
                    </th>
                    <th class="th-lg">
                        <a href="">Estado
                        <i class="fas fa-sort ml-1"></i>
                        </a>
                    </th>
                    <th class="th-lg">
                        <a href="">Editar
                        <i class="fas fa-sort ml-1"></i>
                        </a>
                    </th>
                    
                    </tr>
                </thead>
                <!--Table head-->
        
                <!--Table body-->
                <tbody>
                    @foreach ($bodegas as $item)
                    <tr>
                        <td>{{$item->bodega}}</td>
                        <td>{{$item->direccion}}</td>
                        <td>
                        @if ( $item->estado == 1)
                            Activo
                        @else
                            Inactivo
                        @endif
                       </td>
                        <td><a href="{{route('detaBodega',$item->id_bodega)}}" class="btn btn-sm btn-rounded btn-cyan">Editar</a> </td>
                    
                    </tr>
                    @endforeach
                    
                </tbody>
                <!--Table body-->
                </table>
                <!--Table-->
            </div>
        
            </div>
        
        </div>
        <!-- Table with panel -->
    </div>
</div>
@endsection

@section('scripts')
    

    <script>

        
        $(document).ready(function () {

     

        $('#tbProveedores').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
        $('.dataTables_length').addClass('bs-select');
        $('.mdb-select').materialSelect();
    
    });

        
    </script>

@endsection