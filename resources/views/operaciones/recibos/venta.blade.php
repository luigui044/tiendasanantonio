<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de venta</title>
    <style>

        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: monospace;
            width: 50mm;
            max-width: 50mm;
            padding: 1mm;

            text-align: center;
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        .header {
            margin-bottom: 8px;
        }

        .header h1 {
            font-size: 13px;
            margin: 0;
        }

        .header p {
            font-size: 11px;
            margin: 0;
        }

        .ticket-info {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .ticket-info p {
            margin: 0;
        }

        .productos {
            width: 100%;
            font-size: 11px;
            margin-bottom: 2px;
            table-layout: fixed;
            border-collapse: collapse;
                margin-left: -2mm;
            margin-right: 2mm;
        }
        .nombre-producto {
          padding: 1px 0;
            padding-left: 2mm;
            word-wrap: break-word;
            text-align: left;
        }
        .productos td.cantidadproducto {
            padding: 1px ;
            padding-left: 2mm;
            word-wrap: break-word;
            text-align: left;
        }

        .productos td.subtotalproducto {
            width: 50%;
            margin-left: -2mm;
            margin-right: 2mm;
            text-align: right;
        }

        .total {
            font-size: 12px;
            text-align: right;
            margin-top: 8px;
            padding-top: 4px;
            margin-left: -2mm;
            margin-right: 2mm;
            padding-left: 0;
            padding-right: 0;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="data:image/png;base64,{{ $logoBase64 }}" style="width: 100%; max-width: 46mm; height: auto;">
        <p>Tu mejor opción en Texistepeque</p>
        <p>DOCUMENTO TRIBUTARIO ELECTRÓNICO v.{{ $venta->tipo_venta == '1' ? '1' : '3' }}</p>
        <p>{{ $venta->tipo_venta == '1' ? 'FACTURA' : 'COMPROBANTE DE CRÉDITO FISCAL' }}</p>
        <p>--------------------------------</p>
        <p>DATOS DEL EMISOR</p>
        <p>--------------------------------</p>
        @php
$nombreCompleto = $empresa->nombre_empresa;
$palabras = explode(' ', $nombreCompleto);
$parte1 = [];
$parte2 = [];

// Dividimos en dos partes
$totalPalabras = count($palabras);
if ($totalPalabras >= 2) {
    $parte2 = array_slice($palabras, -2);
    $parte1 = array_slice($palabras, 0, $totalPalabras - 2);
} else {
    $parte1 = $palabras;
}

$parte1Str = implode(' ', $parte1);
$parte2Str = implode(' ', $parte2);
        @endphp
        <p>{{ $parte1Str }}</p>
        <p>{{ $parte2Str }}</p>
        <p>NIT:
                {{ substr($empresa->nit, 0, 4) }}-{{ substr($empresa->nit, 4, 6) }}-{{ substr($empresa->nit, 10, 3) }}-{{ substr($empresa->nit, 13) }}</b>
        </p>
        <p>NRC: {{ substr($empresa->nrc, 0, 6) }}-{{ substr($empresa->nrc, 6) }}</p>
        <p>Actividad económica: {{ $empresa->actividad_economica }}</p>
        <p>{{ $empresa->direccion_empresa }}</p>
        <p>Sucursal #{{ env('BODEGA') }}</p>
        <p>Teléfono: {{ $empresa->telefono_empresa }}</p>
        <p>WhatsApp: {{ $empresa->celular_empresa }}</p>
        <p >Correo</p>
        <p style="font-size: 8.5px;">{{ $empresa->correo_empresa }}</p>
        @if(substr($venta->numero_control, 0, 9) !== 'DTE-none-')
            <p>Fecha y hora de emisión: {{ date_format(date_create($venta->fecha_hora), 'd/m/Y H:i:s') }}</p>
            <p>Código de generación: {{ $venta->uuid }}</p>
            <p>Número de control: {{ $venta->numero_control }}</p>
            <p>Sello de recepción: {{ $venta->sello_recibido }}</p>
            <p>Modelo de transmisión: Normal</p>
            <p>Tipo de Establecimiento: {{ env('BODEGA') == 1 ? 'Matriz' : 'Sucursal / Agencia' }}</p>
        @endif
    </div>

    <div class="ticket-info">
        <p>--------------------------------</p>
        <p>DATOS DEL CLIENTE</p>
        <p>--------------------------------</p>
        <p>Nombre o Razón Social: {{ $venta->elcliente->nombre }}</p>
        @if($venta->elcliente->tipo_cliente != '1')
            <p>Nombre Comercial: {{ $venta->elcliente->nombre }}</p>
            <p>NIT: {{ $venta->elcliente->nit }}</p>
            <p>NRC: {{ $venta->elcliente->nrc }}</p>
        @endif
        <p>Tipo de Doc. de identificación: {{ $venta->elcliente->tipo_cliente == '1' ? 'DUI' : '' }}</p>
        <p>Núm. Doc: {{ $venta->elcliente->tipo_cliente == '1' ? $venta->elcliente->dui : '' }}</p>
        @if($venta->elcliente->direccion)
            <p>Dirección: {{ $venta->elcliente->direccion }}</p>
        @endif
        @if($venta->elcliente->telefono)
            <p>Teléfono: {{ $venta->elcliente->telefono }}</p>
        @endif
        @if($venta->elcliente->correo)
            <p>Correo: {{ $venta->elcliente->correo }}</p>
        @endif
        <p>--------------------------------</p>
    </div>

    <table class="productos">
        @php $descuentos = 0; @endphp
        @foreach ($venta->eldetalle as $detalle)
            @php $descuentos += $detalle->descuento * ($venta->elcliente->tipo_cliente == '1' ? $detalle->precio_iva : $detalle->precio) * $detalle->cantidad; @endphp
            <tr>
                <td class="nombre-producto" colspan="2">{{ $detalle->elproducto->producto }}</td>
            </tr>
            <tr>
                <td class="cantidadproducto">{{ $detalle->cantidad }} x ${{ number_format($venta->elcliente->tipo_cliente == '1' ? $detalle->precio_iva : $detalle->precio, 2) }}</td>
                <td class="subtotalproducto">${{ number_format($detalle->cantidad * ($venta->elcliente->tipo_cliente == '1' ? $detalle->precio_iva : $detalle->precio), 2) }}</td>
            </tr>
            @if($detalle->descuento > 0)
                <tr>
                    <td>Descuento:</td>
                    <td>-${{ number_format($detalle->descuento * ($venta->elcliente->tipo_cliente == '1' ? $detalle->precio_iva : $detalle->precio) * $detalle->cantidad, 2) }}</td>
                </tr>
            @endif
        @endforeach
    </table>

    <div class="total">
        <p><b>--------------------------------</b></p>
        @if($venta->elcliente->tipo_cliente == '1')
            <p>Subtotal: ${{ number_format($venta->total_iva, 2) }}</p>
            {{-- <p><b>Descuento: -${{ number_format($descuentos, 2) }}</b></p> --}}
            <p>TOTAL: ${{ number_format($venta->total_iva - $descuentos, 2) }}</p>
        @else
            <p>Sumas: ${{ number_format($venta->total, 2) }}</p>
            {{-- <p><b>Descuento: -${{ number_format($descuentos, 2) }}</b></p> --}}
            <p>Subtotal: ${{ number_format($venta->total - $descuentos, 2) }}</p>
            <p>IVA 13%: ${{ number_format(($venta->total - $descuentos) * 0.13, 2) }}</p>
            @if($venta->total - $descuentos >= 100)
                <p>IVA Percibido 1%: ${{ number_format(($venta->total - $descuentos) * 0.01, 2) }}</p>
                <p>TOTAL: ${{ number_format(($venta->total_iva - $descuentos) + (($venta->total - $descuentos) * 0.01), 2) }}</p>
            @else
                <p>TOTAL: ${{ number_format(($venta->total_iva - $descuentos), 2) }}</p>
            @endif
        @endif
        <p>--------------------------------</p>

        <p>Monto recibido: ${{ number_format($venta->monto_recibido, 2) }}</p>
        <p>Cambio: ${{ number_format($venta->cambio, 2) }}</p>
        <p>--------------------------------</p>
    </div>

    <div class="footer">
        @php
$todosExcentos = true;
foreach ($venta->eldetalle as $detalle) {
    if ($detalle->elproducto->banexcento != 1) {
        $todosExcentos = false;
        break;
    }
}
        @endphp

        @if(!$todosExcentos)
            <div style="text-align: center; margin: 10px 0;">
                        <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code" style="width: 100px; height: 100px;">

            </div>
        @endif
        <p>¡Gracias por su compra!</p>
        {{-- <p><b>Vuelva pronto</b></p> --}}
    </div>
</body>

</html>