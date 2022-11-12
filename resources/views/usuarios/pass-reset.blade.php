@extends('layouts.master')

@section('contenedor')
    <div class="row mt-5 justify-content-center">
        <div class="col-md-8">
            @if (session('mensaje'))
                <div class="alert alert-danger">{{session('mensaje')}}</div>
            @endif
            <div class="card">
                <div class="card-header">Restablecimiento de contraseña</div>

                <div class="card-body">
                    <h5>Por favor ingrese y confirme su nueva contraseña</h5>
                    <form method="POST" action="{{ route('cambiarPass') }}">
                        @method('PUT')
                        @csrf

                     

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
