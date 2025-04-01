<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VInventario;
use App\Models\DetalleVenta;
use App\Models\Factura;
use App\Models\Venta;
use App\Models\VVenta;
use App\Models\VProducto;
use PDF;
use Exception;
use JavaScript;
use Dompdf\Dompdf;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function inicio() {
        $ventas = Venta::join('clientes', 'ventas.cliente', '=', 'clientes.id_cliente')
            ->select('ventas.*', 'clientes.nombre as nombre_cliente')
            ->get();

        return view('operaciones.ventas.inicio', compact('ventas'));
    }

    public function nueva(Request $request)
    {
        try {
            $venta = new Venta();
            $venta->id_vendedor = auth()->user()->id;
            $venta->cliente = $request->cliente == '' ? null : $request->cliente;
            $venta->nombre_cliente = $request->cliente_nuevo == '' ? null : $request->cliente_nuevo;
            $venta->tienda = 1;
            $venta->fecha_hora = date('Y-m-d H:i:s');
            $venta->total = ($request->total / 1.13 );
            $venta->total_iva = $request->total;
            $venta->comentarios = $request->comentarios;
            $venta->save();

            foreach ($request->producto as $producto) {
                $datosProducto = explode(';', $producto);
                $detalleVenta = new DetalleVenta();
                $detalleVenta->id_venta = $venta->id_venta;
                // Id del producto
                $detalleVenta->producto = $datosProducto[0];
                // Cantidad del producto
                $detalleVenta->cantidad = $datosProducto[1];
                // Precio del producto
                $detalleVenta->precio = $datosProducto[2] / 1.13;
                $detalleVenta->precio_iva = $datosProducto[2];
                $detalleVenta->descuento = $datosProducto[3];
                $detalleVenta->save();
            }

            session()->flash('success', 'Venta realizada con éxito');
            return redirect()->route('ventas.detalle', $venta->id_venta);
        } catch (Exception $error) {
            session()->flash('error', 'Ocurrió un error al registrar la venta.');
            return $error->getMessage();
        } 
    }

    public function detalle($id) {
        $venta = Venta::findOrFail($id);

        return view('operaciones.ventas.detalle', compact('venta'));
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
        $logoPath = public_path('assets/logo2.png');
        $logoBase64 = base64_encode(file_get_contents($logoPath));

        $pdf = new Dompdf();
        $pdf->loadHtml(view('operaciones.recibos.venta', compact('venta', 'logoBase64'))->render());    
        $pdf->setPaper([0, 0, 164.409, 425.197], 'portrait'); // 58mm x 150mm = 164.409pt x 425.197pt
        $pdf->render();
        return $pdf->stream("venta_{$venta->id_venta}_" . date_format(date_create($venta->fecha_hora), 'd-m-Y') . '.pdf');            
    }

    public function convertirFormato($valor){
        return str_replace("$", "", $valor);
    }
}
