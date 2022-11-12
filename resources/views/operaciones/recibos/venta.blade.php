<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de venta</title>
</head>

<style>
    .contenedor {
        width: 100%;
    }

    .encabezado {
        position: relative;
    }

    .info {
        position: absolute;
        top: 0;
        left: 0;
    }

    .n-factura {
        width: 220px;
        height: 100px;
        border-radius: 25px;
        border: solid 1px #000;
        position: absolute;
        top: 0;
        right: 0;
        text-align: center;
    }

    .n-factura span {
        line-height: 70px;
    }

    .cliente {
        border-radius: 25px;
        border: solid 1px #000;
        padding: 5px 10px;
        margin-top: 12%;
    }

    .productos {
        width: 100%;
        padding: 5px;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th,
    td,
    tbody,
    thead {
        border: solid 1px #000;
        padding: 5px;
        font-size: 14px;
    }

    .mt-0 {
        margin-top: 0 !important;
    }
</style>

<body>
    <div class="contenedor">
        <div class="encabezado">
            <div class="info">
                <h1 class="mt-0">Tienda San Antonio</h1>
                <h4>Departamento de Santa Ana - El Salvador</h4>
                <h4>Teléfono: (503) 2222 - 1111</h4>
            </div>
            <div class="n-factura">
                <span>FACTURA</span>
                <span>No. {{ sprintf("%'.06d\n", $venta->id_venta) }}</span>
            </div>
        </div>
        <br>
        <div class="cliente">
            <p><b>Cliente:</b> {{ $venta->elcliente->nombre }}</p>
            <p><b>DUI:</b> {{ $venta->elcliente->dui == '' ? '-' : $venta->elcliente->dui }}</p>
            <p><b>Fecha y hora:</b> {{ date_format(date_create($venta->fecha_hora), 'd/m/Y - H:i:s') }}</p>
        </div>

        <table class="productos">
            <thead>
                <tr>
                    <th>CANT.</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PRECIO UNITARIO</th>
                    <th>VENTAS NO SUJETAS</th>
                    <th>VENTAS EXENTAS</th>
                    <th>DESC. (-)</th>
                    <th>VENTAS GRAVADAS</th>
                </tr>
            </thead>
            <tbody>
                @php $descuentos = 0;  @endphp
                @foreach ($venta->detalles as $detalle)
                    @php $descuentos += $detalle->descuento*$detalle->precio_iva*$detalle->cantidad; @endphp
                    <tr>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->elproducto->producto }}</td>
                        <td>${{ number_format($detalle->precio_iva, 2) }}</td>
                        <td></td>
                        <td></td>
                        <td>${{ number_format($detalle->descuento * $detalle->precio_iva * $detalle->cantidad, 2) }}</td>
                        <td>${{ number_format($detalle->cantidad * $detalle->precio_iva, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" rowspan="2"></td>
                    <td>SUMAS</td>
                    <td>$ -</td>
                    <td>$ -</td>
                    <td>${{ $descuentos }}</td>
                    <td> ${{ number_format($venta->total_iva, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4">(-) IVA RETENIDO</td>
                    <td>$ -</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="4">SUBTOTAL</td>
                    <td>${{ number_format($venta->total_iva, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="4"></td>
                </tr>
                <tr>
                    <td colspan="4">VENTA NO SUJETA</td>
                    <td>$ -</td>
                </tr>
                <tr>
                    <td colspan="4">VENTA EXENTA</td>
                    <td>$ -</td>
                </tr>
                <tr>
                    <td colspan="4">TOTAL</td>
                    <td>${{ number_format($venta->total_iva, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
