@extends('layouts.master')

@section('titulo', 'Detalle venta')

@section('contenido')
    <div class="row p-md-5">
        <div class="d-flex mb-4">

            <a href="{{ route('operacion', 12) }}" class="btn btn-lg btn-primary me-3">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Nueva venta consumidor final
            </a>

            <a href="{{ route('operacion', 13) }}" class="btn btn-lg btn-success me-3">
                <i class="fa-solid fa-circle-plus me-3"></i>
                Nueva venta crédito fiscal     
            </a>

            @if(auth()->user()->rol == 1 || auth()->user()->rol == 2)
                <a href="{{ route('ventas.inicio') }}" class="btn btn-lg btn-success me-3">
                    <i class="fa-solid fa-cart-shopping me-3"></i>
                    Listado de ventas
                </a>
            @endif

            <a href="{{ route('ventas.factura', $venta->id_venta) }}" class="btn btn-lg btn-azul me-3">
                <i class="fa-solid fa-file-invoice me-3"></i>
                {{ $venta->url_pdf == null ? 'Generar factura por primera vez' : 'Volver a generar factura' }}
            </a>
                <button onclick="imprimirConRawBT({{ $venta->id_venta }})" class="btn btn-lg btn-primary me-3 ">
                    <i class="fa-solid fa-print me-3"></i>
                    Imprimir
                </button>


        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detalle de la venta</h4>
                </div>
                <div class="card-content">
                    <div class="card-body"> 
                        <h5>Cliente: {{ $venta->elcliente->nombre }}</h5>
                        <h6>Fecha y hora: {{ date_format(date_create($venta->fecha_hora), 'd/m/Y - H:i:s') }} </h6>
                        <h6>Comentarios: {{ $venta->comentarios == '' ? 'No posee' : $venta->comentarios }}</h6>
                        <hr>
                        <h5 class="mb-3">Productos:</h5>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-lg table-striped table-hover" id="paginacion">
                                    <thead class="bg-rojo">
                                        <tr>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Cantidad</th>
                                            <th class="text-white">Precio ($)</th>
                                            <th class="text-white">Precio + IVA ($)</th>
                                            <th class="text-white">Descuento por unidad (%)</th>
                                            <th class="text-white">Descuento por unidad ($)</th>
                                            <th class="text-white">Subtotal + IVA ($)</th>
                                            <th class="text-white">Descuento ($)</th>
                                            <th class="text-white">Subtotal + IVA con descuento ($)</th>
                                            <th class="text-white">Excento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($venta->eldetalle as $detalle)
                                            <tr>
                                                <td>{{ $detalle->elproducto->producto }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>${{ number_format($detalle->precio, 2) }} </td>
                                                <td>${{ number_format($detalle->precio_iva, 2) }}</td>
                                                <td>{{ $detalle->descuento * 100 }}%</td>
                                                <td>${{ number_format($detalle->descuento * $detalle->precio_iva, 2) }}
                                                </td>
                                                <td>${{ number_format($detalle->precio_iva * $detalle->cantidad, 2) }}
                                                </td>
                                                <td>-${{ number_format($detalle->descuento * $detalle->cantidad * $detalle->precio_iva, 2) }}
                                                </td>
                                                <td>${{ number_format($detalle->precio_iva * $detalle->cantidad * (1 - $detalle->descuento), 2) }}
                                                </td>
                                                <td>{{ $detalle->elproducto->banexcento == 1 ? 'Si' : 'No' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2>Total: ${{ number_format($venta->total_iva, 2) }}</h2>
                                </div>
                                <a href="{{ route('ventas.inicio') }}" class="btn btn-success">
                                    <i class="fa-solid fa-left-long me-1"></i>
                                    Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
        <script>
  


        function imprimirConRawBT(idVenta) {
              fetch(`/ventas/ticket2/${idVenta}`)
                   .then(res => res.text())
                   .then(ticketText => {
               
                                 // Construir el intent URI para RawBT
                       var intent = "rawbt:data:application/pdf;base64,"+ ticketText;

                        window.location.href = intent;





                   });

            }

        </script>
@endsection
