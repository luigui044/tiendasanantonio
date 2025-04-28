<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\VInventario;
use App\Models\DetalleVenta;
use App\Models\Factura;
use App\Models\Venta;
use App\Models\VVenta;
use App\Models\VProducto;
use App\Models\TEmpresa;
use App\Models\VCliente;
use PDF;
use Exception;
use JavaScript;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Events\FacturaGenerada;
use App\Services\DTEBuilder;    
use App\Models\Bodega;


class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function inicio() {
        $ventas = Venta::join('clientes', 'ventas.cliente', '=', 'clientes.id_cliente')
            ->select('ventas.*', 'clientes.nombre as nombre_cliente')
            ->whereNotNull('ventas.tipo_venta')
            ->get();

        return view('operaciones.ventas.inicio', compact('ventas'));
    }

    public function nueva(Request $request)
    {
        try {
            // Crear y guardar la venta
            $venta = Venta::create([
                'id_vendedor' => auth()->id(),
                'cliente' => $request->cliente ?: null,
                'nombre_cliente' => $request->cliente_nuevo ?: null,
                'tienda' => 1,
                'fecha_hora' => now()->setTimezone('America/El_Salvador'),
                'total' => $request->total / 1.13,
                'total_iva' => $request->total,
                'comentarios' => $request->comentarios,
                'uuid' => $this->generarUUIDUnico(),    
                'numero_control' => $this->generarNumeroControl($request->tipo_venta),
                'tipo_venta' => $request->tipo_venta,
                'id_usuario' => auth()->id(),
                'id_sucursal' => env('BODEGA'),
                'iva' => ($request->total / 1.13) * 0.13,
                'iva_percibido' => ($request->total / 1.13) >= 100 ? ($request->total / 1.13) * 0.01 : 0

            ]);

            // Crear detalles de venta
            $detalles = collect($request->producto)->map(function($producto) use ($venta) {
                [$codBar, $cantidad, $precio, $descuento] = explode(';', $producto);
                $producto = Producto::where('cod_bar', $codBar)->first();
                
                return [
                    'id_venta' => $venta->id_venta,
                    'producto' => $producto->id_prod,
                    'cantidad' => $cantidad,
                    'precio' => $precio / 1.13,
                    'precio_iva' => $precio,
                    'descuento' => floatval($descuento) / 100
                ];
            });

            DetalleVenta::insert($detalles->toArray());
        
            // Generar factura
       
            try {
                // Verificar si todos los productos son exentos
                $todosExentos = true;
                foreach($venta->eldetalle as $detalle) {
                    if($detalle->elproducto->banexcento == 0) {
                        $todosExentos = false;
                        break;
                    }
                }

                if(!$todosExentos) {
                    $resultadoDTE = $this->enviarDTE($venta);
                    $selloRecibido = $resultadoDTE['selloRecibido'];

                    $venta->sello_recibido = $selloRecibido;
                    $venta->estado_venta_id = 2;
                    $venta->save();

                    if (!$resultadoDTE) {
                        Log::error('Error al enviar DTE para venta ID: ' . $venta->id_venta);
                        $venta->estado_venta_id = 4;
                        $venta->save();
                        session()->flash('error', 'Error al enviar DTE para venta ID: ' . $venta->id_venta);
                        return redirect()->route('ventas.detalle', $venta->id_venta);
                    }
                } else {
                    // Si todos los productos son exentos, marcamos la venta como completada
                    $venta->estado_venta_id = 2;
                    $venta->save();
                }
            } catch (Exception $e) {
                Log::error('Excepción al enviar DTE para venta ID: ' . $venta->id_venta . ' - ' . $e->getMessage());
                $venta->estado_venta_id = 4;
                $venta->save();
                session()->flash('error', 'Error al enviar DTE para venta ID: ' . $venta->id_venta);
                return redirect()->route('ventas.detalle', $venta->id_venta);
            }
            
            event(new FacturaGenerada($venta));
            session()->flash('success', 'Venta realizada con éxito');
            return redirect()->route('ventas.detalle', $venta->id_venta);

        } catch (Exception $error) {
            session()->flash('error', 'Ocurrió un error al registrar la venta.');
            return $error->getMessage();
        }
    }
    public function generarUUIDUnico() {
        $nuevoUUID = strtoupper(Str::uuid()->toString());   
        $existeUUID = Venta::where('uuid', $nuevoUUID)->exists();
        if ($existeUUID) {
            return $this->generarUUIDUnico();
        }
        return $nuevoUUID;
    }

    public function guardarVenta(Request $request)
    {
        try {
       $venta = Venta::create([
                'id_vendedor' => auth()->id(),
                'cliente' => $request->cliente ?: null,
                'nombre_cliente' => $request->cliente_nuevo ?: null,
                'tienda' => 1,
                'fecha_hora' => now()->setTimezone('America/El_Salvador'),
                'total' => $request->total / 1.13,
                'total_iva' => $request->total,
                'comentarios' => $request->comentarios,
                'uuid' => $this->generarUUIDUnico(),    
                'numero_control' => $this->generarNumeroControl($request->tipo_venta),
                'tipo_venta' => $request->tipo_venta,
                'id_usuario' => auth()->id(),
                'id_sucursal' => env('BODEGA'),
                'iva' => ($request->total / 1.13) * 0.13,
                'iva_percibido' => ($request->total / 1.13) >= 100 ? ($request->total / 1.13) * 0.01 : 0

            ]);

            // Crear detalles de venta
            $detalles = collect($request->producto)->map(function($producto) use ($venta) {
                [$codBar, $cantidad, $precio, $descuento] = explode(';', $producto);
                $producto = Producto::where('cod_bar', $codBar)->first();
                
                return [
                    'id_venta' => $venta->id_venta,
                    'producto' => $producto->id_prod,
                    'cantidad' => $cantidad,
                    'precio' => $precio / 1.13,
                    'precio_iva' => $precio,
                    'descuento' => floatval($descuento) / 100
                ];
            });

            DetalleVenta::insert($detalles->toArray());

            return response()->json(['success' => 'Venta guardada con éxito', 'id_venta' => $venta->id_venta]);
        } catch (Exception $error) {
            return response()->json(['error' => 'Ocurrió un error al guardar la venta.']);
        }
    }

    private function generarNumeroControl($tipo_venta)
    {
        $bodega = env('BODEGA');
        $establecimiento = Bodega::where('id_bodega', $bodega)->first();
        $ultimaVenta = Venta::orderBy('id_venta', 'desc')->first();
        $ultimoNumero = $ultimaVenta ? intval(substr($ultimaVenta->numero_control, -12)) : 0;
        $nuevoNumero = str_pad($ultimoNumero + 1, 15, '0', STR_PAD_LEFT);
        if ($tipo_venta == 2) {
            $numeroControl = "DTE-03-{$establecimiento->cod_dte}-{$nuevoNumero}";
            return $numeroControl;
        }

        $numeroControl = "DTE-01-{$establecimiento->cod_dte}-{$nuevoNumero}";
        return $numeroControl;
    }

    public function detalle($id) {
        $venta = Venta::findOrFail($id);

        $cliente = VCliente::where('id_cliente', $venta->cliente)->first();
     
        return view('operaciones.ventas.detalle', compact('venta', 'cliente'));
    }

    public function filtProd(Request $request)
    {
        $bodegas = $request->bodega;
        $productos = VInventario::where('id_bodega',$bodegas)->where('cantidad','>',0)->get();
        JavaScript::put([
            'productos' =>  $productos,
        ]);
        return view('partials.productos',compact('productos'));
    }

    public function filtProd2(Request $request)
    {
        $bodegas = $request->bodega;
        $codBar = $request->codBar;
        $cantidad = $request->cantidad;

        $producto = VInventario::where('id_bodega',$bodegas)->where('cantidad','>',0)->where('cod_bar',$codBar)->firstOrFail();
      
        
        $subtotal = $producto->precio * $cantidad;

        JavaScript::put([
            'subtotal' =>  round($subtotal,2),
            
        ]);
        return view('partials.productos2',compact('producto','cantidad','subtotal','codBar'));
    }

    public function filtCant(Request $request)
    {
        $bodegas = $request->bodega;
        $codBar = $request->codBar;
        $producto = VInventario::where('id_bodega',$bodegas)->where('cantidad','>',0)->where('cod_bar',$codBar)->firstOrFail();
      
        return view('partials.cantidad',compact('producto'));
    }

    public function factura($id_venta)
    {
        $venta = Venta::findOrFail($id_venta);

        // Si ya existe el PDF, retornarlo directamente
        if ($venta->url_pdf) {
            return response()->file(storage_path('app/public/' . $venta->url_pdf));
        }

        $factura = Factura::where('id_venta', $id_venta)->first();

        if ($factura === null) {
            $nuevaFactura = new Factura();
            $nuevaFactura->id_venta = $id_venta;
            $nuevaFactura->generada = 1;
            $nuevaFactura->ultima_fecha_generacion = date('Y-m-d');
            $nuevaFactura->save();
        } else {
            $factura->generada += 1;
            $factura->ultima_fecha_generacion = date('Y-m-d');
            $factura->save();
        }

        // Convertir logo a base64
        $logoPath = public_path('assets/logo3.png');
        $logoBase64 = base64_encode(file_get_contents($logoPath));

        // Generar URL para el QR
        $urlFactura = route('ventas.detalle', $venta->id_venta);
        
        // Generar QR como base64
        $qrCode = QrCode::format('png')
                        ->size(100)
                        ->margin(1)
                        ->generate($urlFactura);
        $qrBase64 = base64_encode($qrCode);

        $pdf = new Dompdf();
        $pdf->loadHtml(view('operaciones.recibos.venta', compact('venta', 'logoBase64', 'qrBase64'))->render());    
        $pdf->setPaper([0, 0, 164.409, 950.394], 'portrait');   // 58mm x 300mm = 164.409pt x 850.394pt
        $pdf->render();
        // Generar nombre único para el archivo PDF
        $nombreArchivo = "venta_{$venta->id_venta}_" . date_format(date_create($venta->fecha_hora), 'd-m-Y') . '.pdf';
        
        // Guardar PDF en storage/app/public/facturas
        $rutaGuardado = storage_path('app/public/facturas/' . $nombreArchivo);
        file_put_contents($rutaGuardado, $pdf->output());

        // Actualizar la URL del PDF en la venta
        $venta->url_pdf = 'facturas/' . $nombreArchivo;
        $venta->save();
        
        return $pdf->stream("venta_{$venta->id_venta}_" . date_format(date_create($venta->fecha_hora), 'd-m-Y') . '.pdf');            
    }


public function ticketRawBT2($id_venta)
{
    $venta = Venta::findOrFail($id_venta);
    $path = storage_path('app/public/facturas/venta_' . $venta->id_venta . '_' . date_format(date_create($venta->fecha_hora), 'd-m-Y') . '.pdf');
    $pdf = file_get_contents($path);
    $base64 = base64_encode($pdf);
    return response($base64)->header('Content-Type', 'text/plain');
}

    public function convertirFormato($valor){
        return str_replace("$", "", $valor);
    }


    public function enviarDTE($venta){
        $empresa = TEmpresa::first();
        $url_firmador = $empresa->url_firmador;

        $checkStatus = $url_firmador . 'firmardocumento/status';
        try {
            $response = Http::get($checkStatus);
            if ($response->successful()) {
                $firmarDTE = $url_firmador . 'firmardocumento/';
                $tipo_venta = $venta->tipo_venta;
                $json = DTEBuilder::build($venta, $empresa, $tipo_venta);
                // Log::info(json_encode($json));


                $response = Http::post($firmarDTE, $json); 
                $facturaFirmada = $response->json()['body'];
            if ($response->successful()) {
              //pasamos a enviar factura a hacienda
                $enviarFactura = $this->enviarFactura($facturaFirmada, (string)$venta->uuid, $tipo_venta);
                $selloRecibido = $enviarFactura['selloRecibido'];
              $result = [
                'success' => 'Factura enviada con éxito',
                'status' => $response->status(),
                'response' => $response->json(),
                'selloRecibido' => $selloRecibido
              ];

              return $result;
            }



                
            } else {
                return [
                    'error' => 'Error al consultar el estado del servicio',
                    'status' => $response->status()
                ];
            }
        } catch (Exception $e) {
            Log::error('Error en el servicio:', [
                'url' => $checkStatus,
                'error' => $e->getMessage()
            ]);

            return [
                'error' => 'Error de conexión con el servicio', 
                'message' => $e->getMessage()
            ];
        }
    }
    
        public function convertirNumeroALetras($numero)
        {
            $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
            
            $numero = round($numero, 2);
            $partes = explode('.', number_format($numero, 2, '.', ''));

            $entero = (int)$partes[0];
            $decimal = str_pad($partes[1], 2, '0', STR_PAD_RIGHT); // Asegura dos dígitos

            $texto = strtoupper($formatter->format($entero));
            $resultado = $texto . ' CON ' . $decimal . '/100';

            return $resultado;
        }


    public function obtenerCentavos($numero) {
        $partes = explode('.', (string)$numero);
        $decimal = isset($partes[1]) ? $partes[1] : '';

        return $decimal;
    }

    public function convertirMillones($numero) {
        $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];    
        $decenas = ['', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE'];
        $centenas = ['', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA', 'CIEN'];

        $resultado = '';

        if ($numero >= 1000000) {   
            $millones = floor($numero / 1000000);
            $resultado = $this->convertirCentenas($millones) . ' MILLONES';
            $numero %= 1000000;
        }

        if ($numero >= 1000) {  
            $miles = floor($numero / 1000);
            $resultado .= $this->convertirCentenas($miles) . ' MIL';
            $numero %= 1000;
        }

        if ($numero > 0) {  
            $resultado .= $this->convertirCentenas($numero);
        }

        return $resultado;
    }   
    public function convertirCentenas($numero) {
        $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        $decenas = ['', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE'];
        $centenas = ['', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA', 'CIEN'];

        $resultado = '';
        if ($numero >= 100) {
            $resultado .= $centenas[floor($numero / 100)];
            $numero %= 100;
        }

        if ($numero >= 20) {    
            $resultado .= $decenas[floor($numero / 10)];
            $numero %= 10;
        }

        if ($numero > 0) {
            $resultado .= $unidades[$numero];
        }   

        return $resultado;
    }       
    

    public function enviarFactura($facturaFirmada, $codigoGeneracion, $tipo_venta){
        $url_dte = 'https://apitest.dtes.mh.gob.sv/fesv/recepciondte';
        // Log::info('facturaFirmada: ' . json_encode($facturaFirmada));
        switch ($tipo_venta) {
            case 2:
            
                $tipoDte = '03';
                $version = 3;
                break;
            default:
              
                $tipoDte = '01';
                $version = 1;
                break;
        }
            $ambiente = env('AMBIENTE_DTE');
        $envio = 1;

        if (!Cache::has('hacienda_bearer_token')) {
                Artisan::call('hacienda:obtener-token');
            }

        $token = Cache::get('hacienda_bearer_token');
            
        $headers = [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ];

        $json = [
            "ambiente" => $ambiente,
            "tipoDte" => $tipoDte,
            "version" => $version,
            "idEnvio" => $envio,
            "documento" => $facturaFirmada,
            "codigoGeneracion" => (string)$codigoGeneracion,
        ];

            $response = Http::withHeaders($headers)->post($url_dte, $json);
        if ($response->successful()) {
            // Log::info('Factura enviada con éxito', $response->json());
            $selloRecibido = $response->json()['selloRecibido'];
  
            
            
            return [
                'success' => 'Factura enviada con éxito',
                'status' => $response->status(),
                'response' => $response->json(),
                'selloRecibido' => $selloRecibido,
              ];
        } else {
            Log::error('Error al enviar factura', $response->json());
            return [
                'error' => 'Error al enviar factura',
                'status' => $response->status()
            ];
        }
         
    }
}
