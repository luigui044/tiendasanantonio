<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de venta</title>
</head>

<style>
    body {
        font-family: monospace;
        width:36mm; /* Reducido para dar margen */
        max-width: 36mm;
        margin: 0;
      
        text-align: center;
        position: relative;
    }
    .header {
        text-align: center;
        margin-bottom: 8px;
        width: 100%;
    }
    .header img {
       
    }
    .header h1 {
        font-size: 13px;
        margin: 0;
        width: 100%;
    }
    .header p {
            font-size:11px;
        margin: 2px 0;
        width: 100%;
    }
    .ticket-info {
         padding-right: 7mm;
        font-size: 11px;
        margin-bottom: 8px;
        width: 100%;
    }
    .productos {
     margin-left:5mm;
        width: 100%;
        font-size: 11px;
        margin-bottom: 8px;
        table-layout: fixed;
    }
    .productos td {
       
        padding: 1px;
        word-wrap: break-word;
    }
    .total {
        margin-left: 6mm;
        font-size: 12px;
        text-align: right;
        margin-top: 8px;
        padding-top: 4px;
        width: 100%;
    }
    .footer {
        text-align: center;
        font-size: 11px;
        margin-top: 12px;
        width: 100%;
    }
</style>

<body>
    <div class="header">
            <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" style="width: 200px; height: 100px;">
                    <p><b>Tu mejor opción en Texistepeque</b></p>
        <h1 style="margin-bottom: 1mm;"><b>Tienda San Antonio</b></h1>
        <p><b>Casa Matriz: 3ra avenida sur, frente al Mercado de Texistepeque, Santa Ana</b></p>
        <p style="margin-bottom: 1mm;"><b>Sucursal: Final 3ra avenida sur y Calle Libertad, Texistepeque, Santa Ana</b></p>
        <p><b>Tel: 2470-0459</b></p>
        <p><b>WhatsApp: 7537-4679</b></p>
        <p><b>--------------------------------</b></p>
        <p><b>TICKET #{{ sprintf("%'.06d\n", $venta->id_venta) }}</b></p>
    </div>

    <div class="ticket-info">
        <p><b>Cliente: {{ $venta->elcliente->nombre }}</b></p>
        <p><b>Fecha: {{ date_format(date_create($venta->fecha_hora), 'd/m/Y') }}</b></p>
        <p><b>Hora: {{ date_format(date_create($venta->fecha_hora), 'H:i:s') }}</b></p>
        <p><b>--------------------------------</b></p>
    </div>

    <table class="productos">
        @php $descuentos = 0; @endphp
        @foreach ($venta->detalles as $detalle)
            @php $descuentos += $detalle->descuento * $detalle->precio_iva * $detalle->cantidad; @endphp
            <tr>
                <td colspan="2"><b>{{ $detalle->elproducto->producto }}</b></td>
            </tr>
            <tr>
                <td><b>{{ $detalle->cantidad }}x ${{ number_format($detalle->precio_iva, 2) }}</b></td>
                <td style="text-align: right"><b>${{ number_format($detalle->cantidad * $detalle->precio_iva, 2) }}</b></td>
            </tr>
            @if($detalle->descuento > 0)
            <tr>
                <td><b>Descuento:</b></td>
                <td style="text-align: right"><b>-${{ number_format($detalle->descuento * $detalle->precio_iva * $detalle->cantidad, 2) }}</b></td>
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
