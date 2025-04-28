@extends('layouts.master')

@section('titulo', 'Submódulos')

@section('contenido')
    <div class="row justify-content-center flex-wrap p-5">
 
        @if(isset($ventasPendientes) && $ventasPendientes > 0)
 
            <div class="col-12 col-sm-8 col-md-4 col-lg-4 mb-4 mw">
                <div class="card submodulo">
                    <div class="card-header d-flex flex-column align-items-center p-4">
                        <h5 class="card-header-title mb-3 text-center">Ventas Pendientes</h5>
                        <div class="icono-modulo">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="mt-4 card-text text-center">Tienes {{ $ventasPendientes }} ventas pendientes de completar</p>
                        {{-- <a href="{{ route('ventas.pendientes') }}" class="btn btn-warning">
                            Ver ventas pendientes
                        </a> --}}
                    </div>
                </div>
            </div>
        @endif

        @foreach ($submodulos as $item)
            @if ($item->id_modulo != 14 || auth()->user()->rol == 1)
            <div class="col-12 col-sm-8 col-md-4 col-lg-4 mb-4 mw">
                <!-- Card -->
                <div class="card submodulo">
                    <!-- Card image -->
                    <div class="card-header d-flex flex-column align-items-center p-4">
                        <!-- Title -->
                        <h5 class="card-header-title mb-3 text-center">{{ $item->desc_modulo }}</h5>
                        <div class="icono-modulo">
                            <i class="{{ $item->icono }}"></i>
                        </div>
                        <!-- Subtitle -->
                    </div>
                    <!-- Card content -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <!-- Text -->
                        <p class="mt-4 card-text text-center">{{ $item->descripcion }}</p>
                        @if ($item->ban_padre == 0)
                            <a href="{{ route('submodulo.hijos', $item->id_modulo) }}" class="btn btn-primary">
                               Llévame ahí
                            </a>
                        @else
                            <a href="{{ route('operacion', $item->id_modulo) }}" class="btn btn-primary">
                                Llévame ahí
                            </a>
                        @endif
                    </div>
                </div>
                <!-- Card -->
            </div>
            @endif
        @endforeach
@endsection
