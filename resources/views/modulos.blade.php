@extends('layouts.master')

@section('titulo', 'Módulos')

@section('contenido')
    <section class="roles">
        <a href="{{ route('submodulos', 1) }}" class="animate__animated animate__slideInLeft">
            <div class="row">
                <h2 class="text-center">Gerencial</h2>
            </div>
            <div class="row">
                <img src="{{ asset('assets/images/admin.png') }}" alt="Administración" title="Administración" class="img-rol">
            </div>
        </a>
        <a href="{{ route('submodulo.hijos', 3) }}" class="bg-rojo animate__animated animate__slideInRight">
            <div class="row">
                <h2 class="text-center text-white">Operativo</h2>
            </div>
            <div class="row">
                <img src="{{ asset('assets/images/operaciones.png') }}" alt="Operaciones" title="Operaciones"
                    class="img-rol">
            </div>
        </a>
    </section>
@endsection
