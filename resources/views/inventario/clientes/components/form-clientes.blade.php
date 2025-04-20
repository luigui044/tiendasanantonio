<div class="card">
    <div class="card-header">
        <h4 class="card-title">Agregar cliente</h4>
    </div>
    <div class="card-body">
        <div class="row">
            @if (session('mensaje'))
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif
            <form id="form-cliente">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <label for="nombre">Nombre o Razón social:</label>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                placeholder="Nombre del cliente" id="nombre" name="nombre"
                                value="{{ old('nombre') }}" style="text-transform: uppercase" autofocus required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="telefono">Teléfono:</label>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                placeholder="Teléfono del cliente" id="telefono" name="telefono"
                                value="{{ old('telefono') }}" maxlength="8"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <div class="form-control-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                        @error('telefono')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="correo">Correo:</label>
                        <small class="text-muted d-block">Ingrese un correo electrónico válido</small>
                        <div class="form-group position-relative has-icon-left">
                            <input type="email" class="form-control @error('correo') is-invalid @enderror"
                                placeholder="Correo del cliente" id="correo" name="correo"
                                value="{{ old('correo') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>  
                        </div>
                        @error('correo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="dui">DUI:</label>
                        <small class="text-muted d-block">Máximo 9 dígitos (Ejemplo: 012345678)</small>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control @error('dui') is-invalid @enderror" 
                                placeholder="DUI (00000000-0)" id="dui" name="dui"
                                value="{{ old('dui') }}" required
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9-]/g, ''); if(this.value.length == 8) this.value += '-';">
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>
                        @error('dui')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                   
                    <div class="col-sm-12">
                        <label for="credito_fiscal">Crédito fiscal:</label>
                        <div class="d-flex">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" id="chk-credito-fiscal" @if($credito_fiscal) checked @endif @if($readonly) disabled @endif name="chk_credito"  class="form-check-input">
                                    <input type="hidden" name="chk_credito_hidden" id="chk_credito_hidden" value="@if($credito_fiscal) 1 @else 0 @endif">
                                </div>
                            </div>
                           
                        </div>
       
                    </div>
                    <div class="col-sm-6" id="credito_fiscal_div" >
                        <label for="credito_fiscal">NIT:</label>
                        <small class="text-muted d-block">Máximo 14 dígitos (Ejemplo: 12345678901234)</small>
                         <div class="form-group position-relative has-icon-left w-100">
                                <input type="text" class="form-control @error('credito_fiscal') is-invalid @enderror"
                                    placeholder="Crédito fiscal" id="credito_fiscal" name="credito_fiscal"
                                    value="{{ old('credito_fiscal') }}" disabled
                                    maxlength="14"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="form-control-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                            </div>
                        @error('credito_fiscal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror   
                    </div>
                    <div class="col-sm-6" id="nrc_div" >
                        <label for="credito_fiscal">NRC:</label>
                        <small class="text-muted d-block">Máximo 7 dígitos (Ejemplo: 1234567)</small>
                        <div class="form-group position-relative has-icon-left w-100">
                            <input type="text" class="form-control @error('nrc') is-invalid @enderror"
                                placeholder="NRC" id="nrc" name="nrc" value="{{ old('nrc') }}" disabled
                                maxlength="7"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>
                            @error('nrc')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-12 col-lg-12" id="actividad_economica_div">
                        <label for="actividad_economica">Actividad económica:</label>
                        <div class="form-group position-relative w-100">
                            <select class="form-control select2 w-100 @error('actividad_economica') is-invalid @enderror" placeholder="Actividad económica" id="actividad_economica" name="actividad_economica">
                                <option value="">Seleccione una actividad económica</option>
                                @foreach ($actividades as $actividad)
                                    <option value="{{ $actividad->codigo }}"> {{ $actividad->codigo }} - {{  strtoupper($actividad->descripcion) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="departamento">Departamento: </label>
                        <div class="form-group position-relative has-icon-left">
                            <select class="form-control @error('departamento') is-invalid @enderror"
                                placeholder="Departamento" id="departamento" name="departamento">   
                                <option value="">Seleccione un departamento</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->codigo }}">{{  $departamento->descripcion }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                        </div>
                        @error('departamento')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="municipio">Municipio:</label>
                        <div class="form-group position-relative has-icon-left">
                            <select disabled   select class="form-control @error('municipio') is-invalid @enderror" 
                                placeholder="Municipio" id="municipio" name="municipio">
                                <option value="">Seleccione un municipio</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                        </div>
                        @error('municipio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>  
                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" 
                            name="direccion" rows="3">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    Guardar
                </button>
                @if ($inventario)
                    <a href="{{ route('submodulo.hijos', 2) }}" class="btn btn-success mt-3 ms-3">
                        <i class="fa-solid fa-left-long me-2"></i>
                        Volver
                    </a>
                @else
                    <button type="button" class="btn btn-success mt-3 ms-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-left-long me-2"></i>
                        Volver
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>
