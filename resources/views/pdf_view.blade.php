<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de Venta</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mdb.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">


</head>
<body>  
 
    <style>
        th,  td {
  border: 1px solid black;
}
    </style>
    <div class="row">
        <div  style="background-color: yellow; boder-radius: 50px; border:solid black">
            <h1>    Recibo de Venta No. {{$header->id_venta}} </h1>

            @php
                $fecha = date("d/m/Y", strtotime($header->fecha_hora));
            @endphp
            <p>Fecha: {{$header->fecha}}  </p>
            <p>Sucursal: {{$header->bodega}}</p>
            <p>Cliente: {{$header->nombre}}</p>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>               
                     <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Subtotal+IVA</th>
            </tr>

            </thead>
            <tbody>
                @foreach ($body as $item)
                    <tr>
                        <td>
                            {{$item->producto}}
                        </td>
                        <td>
                            {{$item->cantidad}}
                        </td>
                        <td>
                            {{round($item->precio,2)}}
                        </td>
                        <td>
                            {{round($item->precio*$item->cantidad,2)}}
                        </td>
                        <td>
                            {{round($item->precio*$item->cantidad+($item->precio*$item->cantidad*0.13),2)}}
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
        <div class="col-md-4">
            <p>Sub-total: {{$header->total}}</p>
            <p>IVA: {{round($header->total*0.13,2)}}</p>
            <p>Total+ IVA: {{round($header->total+($header->total*0.13),2)}}</p>
        </div>
    </div>



    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/mdb.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/addons/datatables.min.js')}}"></script>
</body>
</html>