@extends('layouts.master')

@section('title','Proveedores')
@section('styles')
    <style>
        .form-check{
            text-align:left !important;
        }
    </style>
@endsection
@section('regresar')
    <a href="{{ route('operacion',19)}}" class="btn btn-unique"><i class="fas fa-arrow-left"></i> Regresar</a>
@endsection
@section('contenedor')
<div class="row mt-2   justify-content-center ">
    <div class="col-md-6">
        @if (session('mensaje'))
        <div class="alert alert-success">{{session('mensaje')}}</div>
    @endif
            <!-- Default form contact -->
        <form class="text-center border border-light p-5" action="{{route('editBodega',$id)}}" method="POST">
            @method('PUT')
            @csrf
            <p class="h4 mb-4">Editar bodega</p>

            <!-- Name -->
            
                
            <div class="md-form">
                <input type="text" id="nombre" name="nombre" value="{{$bodega->bodega}}" class="form-control mb-4" placeholder="Nombre de bodega" required>

            </div>

        
            <div class="md-form">
                <!-- Email -->
                <input type="text" id="telefono" name="telefono" value="{{$bodega->telefono}}" class="form-control mb-4" placeholder="Teléfono" required>
            </div>

            <div class="md-form">
                <!-- Email -->
                <input type="text" id="direccion" name="direccion"  value="{{$bodega->direccion}}" class="form-control mb-4" placeholder="Dirección" required>
            </div>
       
            <select name="estado" id="estado" class="mdb-select md-form mb-4" required>
                <option value="1" @if ($bodega->estado == 1) selected @endif>Activo</option>

                <option value="2" @if ($bodega->estado == 2) selected @endif>Inactivo</option>

            </select>
            <button class="btn btn-info btn-block" type="submit">Actualizar Bodega</button>
        </form>
        <!-- Default form contact -->
    </div>
</div>
@endsection

@section('scripts')
    


<script>

        
    $(document).ready(function () {

 

        $('.mdb-select').materialSelect();

        });

    
</script>

@endsection