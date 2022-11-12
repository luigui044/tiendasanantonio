@extends('layouts.master')

@section('titulo', 'Submódulos')

@section('contenido')
    <div class="row justify-content-center flex-wrap p-5">
        @foreach ($submodulos as $item)
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
        @endforeach
@endsection
