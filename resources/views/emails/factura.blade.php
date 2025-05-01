<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: left;
            margin-bottom: 20px;
        }
        .logo {
            width: 250px;
            height: auto;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 15px;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .confidential {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
<img src="{{ $message->embed(public_path('assets/logocolor2.png')) }}" alt="Logo" class="logo" style="display: block; max-width: 250px; height: auto;">
        <hr>
        
        <h2>Confirmación de Compra</h2>
        
        <p>Estimado/a cliente,</p>

        <p>
            Le confirmamos que su compra realizada el <strong>{{ $venta->fecha_hora->format('d/m/Y') }}</strong> 
            por el valor de <strong>${{ number_format($venta->total_iva, 2, ',', '.') }}</strong> 
            ha sido procesada exitosamente.
        </p>

        <p>Adjunto encontrará la factura correspondiente a su transacción.</p>

        <div class="contact-info">
            <h3>Información de Contacto</h3>
            <ul>
                <li>📞 Teléfono: {{ $empresa->telefono_empresa }}</li>
                <li>📧 Correo electrónico: {{ $empresa->correo_empresa }}</li>
            </ul>
        </div>

        <div class="confidential">
            <h3>Mensaje de Confidencialidad</h3>
            <p>
                Este correo electrónico y sus anexos contienen información confidencial y están destinados exclusivamente 
                para el uso del destinatario. Si usted no es el destinatario previsto, por favor notifíquelo inmediatamente 
                y elimine este mensaje. La divulgación, copia o uso no autorizado de la información contenida en este 
                correo electrónico está estrictamente prohibida.
            </p>
        </div>

        <p class="footer">
            Gracias por su preferencia,<br>
            <strong>Tienda San Antonio</strong>
        </p>
    </div>
</body>
</html>
