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
        <p><b>Tu mejor opción en Texistepeque</b></p>
        <p><b>DOCUMENTO TRIBUTARIO ELECTRÓNICO v.{{ $venta->tipo_venta == '1' ? '1' : '3' }}</b></p>
        <p><b>{{ $venta->tipo_venta == '1' ? 'FACTURA' : 'COMPROBANTE DE CRÉDITO FISCAL' }}</b></p>
        <p><b>--------------------------------</b></p>
        <p><b>DATOS DEL EMISOR</b></p>
        <p><b>--------------------------------</b></p>
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
        <h1><b>{{ $parte1Str }}</b></h1>
        <h1><b>{{ $parte2Str }}</b></h1>
        <p><b>NIT:
                {{ substr($empresa->nit, 0, 4) }}-{{ substr($empresa->nit, 4, 6) }}-{{ substr($empresa->nit, 10, 3) }}-{{ substr($empresa->nit, 13) }}</b>
        </p>
        <p><b>NRC: {{ substr($empresa->nrc, 0, 6) }}-{{ substr($empresa->nrc, 6) }}</b></p>
        <p><b>Actividad económica: {{ $empresa->actividad_economica }}</b></p>
        <p><b>{{ $empresa->direccion_empresa }}</b></p>
        <p><b>Sucursal #{{ env('BODEGA') }}</b></p>
        <p><b>Teléfono: {{ $empresa->telefono_empresa }}</b></p>
        <p><b>WhatsApp: {{ $empresa->celular_empresa }}</b></p>
        <p><b>Correo: {{ $empresa->correo_empresa }}</b></p>
        <p><b>Fecha y hora de emisión: {{ date_format(date_create($venta->fecha_hora), 'd/m/Y H:i:s') }}</b></p>
        <p><b>Código de generación: {{ $venta->uuid }}</b></p>
        <p><b>Número de control: {{ $venta->numero_control }}</b></p>
        <p><b>Sello de recepción: {{ $venta->sello_recibido }}</b></p>
        <p><b>Modelo de transmisión: Normal</b></p>
        <p><b>Tipo de Establecimiento: {{ env('BODEGA') == 1 ? 'Matriz' : 'Sucursal / Agencia' }}</b></p>
    </div>

    <div class="ticket-info">
        <p><b>--------------------------------</b></p>
        <p><b>DATOS DEL CLIENTE</b></p>
        <p><b>--------------------------------</b></p>
        <p><b>Nombre o Razón Social: {{ $venta->elcliente->nombre }}</b></p>
        @if($venta->elcliente->tipo_cliente != '1')
            <p><b>Nombre Comercial: {{ $venta->elcliente->nombre }}</b></p>
            <p><b>NIT: {{ $venta->elcliente->nit }}</b></p>
            <p><b>NRC: {{ $venta->elcliente->nrc }}</b></p>
        @endif
        <p><b>Tipo de Doc. de identificación: {{ $venta->elcliente->tipo_cliente == '1' ? 'DUI' : '' }}</b></p>
        <p><b>Núm. Doc: {{ $venta->elcliente->tipo_cliente == '1' ? $venta->elcliente->dui : '' }}</b></p>
        <p><b>Dirección: {{ $venta->elcliente->direccion }}</b></p>
        <p><b>Teléfono: {{ $venta->elcliente->telefono }}</b></p>
        <p><b>Correo: {{ $venta->elcliente->correo ?? '' }}</b></p>
        <p><b>--------------------------------</b></p>
    </div>

    <table class="productos">
        @php $descuentos = 0; @endphp
        @foreach ($venta->detalles as $detalle)
            @php $descuentos += $detalle->descuento * $detalle->precio_iva * $detalle->cantidad; @endphp
            <tr>
                <td class="nombre-producto" colspan="2"><b>{{ $detalle->elproducto->producto }}</b></td>
            </tr>
            <tr>
                <td class="cantidadproducto"><b>{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_iva, 2) }}</b></td>
                <td class="subtotalproducto"><b>${{ number_format($detalle->cantidad * $detalle->precio_iva, 2) }}</b></td>
            </tr>
            @if($detalle->descuento > 0)
                <tr>
                    <td><b>Descuento:</b></td>
                    <td><b>-${{ number_format($detalle->descuento * $detalle->precio_iva * $detalle->cantidad, 2) }}</b></td>
                </tr>
            @endif
        @endforeach
    </table>

    <div class="total">
        <p><b>--------------------------------</b></p>
        <p><b>Subtotal: ${{ number_format($venta->total_iva, 2) }}</b></p>
        <p><b>Descuento: -${{ number_format($descuentos, 2) }}</b></p>
        <p><b>TOTAL: ${{ number_format($venta->total_iva - $descuentos, 2) }}</b></p>
        <p><b>--------------------------------</b></p>
    </div>

    <div class="footer">
        <div style="text-align: center; margin: 10px 0;">
            <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code" style="width: 150px; height: 150px;">
        </div>
        <p><b>¡Gracias por su compra!</b></p>
        <p><b>Vuelva pronto</b></p>
    </div>
</body>

</html>