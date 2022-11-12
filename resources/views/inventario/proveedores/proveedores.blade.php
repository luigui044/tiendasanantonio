@extends('layouts.master')

@section('titulo', 'Proveedores')

@section('contenido')
    <section class="contenedor-personalizado">
        <div class="row match-height">
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Agregar proveedor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (session('mensaje'))
                                <div class="alert alert-success">{{ session('mensaje') }}</div>
                            @endif
                            <form method="POST" action="{{ route('addProv') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="razonSocial">Razón social:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('razonSocial') is-invalid @enderror"
                                                placeholder="Razón social" id="razonSocial" name="razonSocial"
                                                value="{{ old('razonSocial') }}" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('razonSocial')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="estado">Giro:</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="giro" name="giro">
                                                @foreach ($giro as $item)
                                                    <option value="{{ $item->id_giro }}"
                                                        data-secondary-text="{{ $item->no_giro }}">
                                                        {{ $item->desc_giro }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="creditoFiscal">Crédito fiscal:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('creditoFiscal') is-invalid @enderror"
                                                placeholder="Crédito fiscal" id="creditoFiscal" name="creditoFiscal"
                                                value="{{ old('creditoFiscal') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('creditoFiscal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="telefono">Teléfono:</label>
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror"
                                                placeholder="Teléfono" id="telefono" name="telefono"
                                                value="{{ old('telefono') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('telefono')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="direccion" class="form-label">
                                            Dirección
                                        </label>
                                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion"
                                            rows="3">{{ old('direccion') }}</textarea>
                                        @error('direccion')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="oferente" name="oferente"
                                                class="form-check-input" checked>
                                            <label for="oferente">Oferente</label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="sumBienes" name="sumBienes"
                                                class="form-check-input" checked>
                                            <label for="sumBienes">Suministrador de bienes</label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="presServ" name="presServ"
                                                class="form-check-input" checked>
                                            <label for="presServ">Prestador de servicios</label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="contratista" name="contratista"
                                                class="form-check-input" checked>
                                            <label for="contratista">Contratista</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-user-plus me-2"></i>
                                    Guardar
                                </button>
                                <a href="{{ route('submodulo.hijos', 2) }}" class="btn btn-success mt-3 ms-3">
                                    <i class="fa-solid fa-left-long me-2"></i>
                                    Volver
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Proveedores registrados</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">Razón social</th>
                                            <th class="text-white">Crédito fiscal</th>
                                            <th class="text-white">Estado</th>
                                            <th class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proveedores as $item)
                                            <tr>
                                                <td>{{ $item->razon_social }}</td>
                                                <td>{{ $item->credito_fiscal }}</td>
                                                <td>{{ $item->estado }}</td>
                                                <td>
                                                    <a href="{{ route('detaProv', $item->id_proveedor) }}"
                                                        class="btn btn-success">
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
            </div>
        </div>
    </section>
@endsection
