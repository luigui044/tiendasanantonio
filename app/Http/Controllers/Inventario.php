<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedore;
use App\Models\CatGiro;
use App\Models\CateProducto;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Bodega;
use App\Models\TInventario;
use App\Models\CatActividadesEconomica;
use Exception;
use Illuminate\Support\Facades\Log;

class Inventario extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addProv(Request $request)
    {   
        $of = isset($request->oferente) ? 1 : 0;
        $sb = isset($request->sumBienes) ? 1: 0;
        $ps = isset($request->presServ) ? 1 : 0;
        $cont = isset($request->contratista) ? 1 : 0;

        $proveedor = new Proveedore();
        $proveedor->razon_social = $request->razonSocial;
        $proveedor->giro_categoria = $request->giro;
        $proveedor->credito_fiscal = $request->creditoFiscal;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->oferente = $of;
        $proveedor->suministrante_bienes = $sb; 
        $proveedor->prestador_servicios = $ps;
        $proveedor->contratista = $cont;
        $proveedor->save();

        return back()->with('mensaje', 'El proveedor '.$request->razonSocial.' ha sido agregado exitosamente.');
    }



    public function detaProv($idProv)
    {
        $proveedor = Proveedore::findOrFail($idProv);
        $giro = CatGiro::all();
        return view('inventario.proveedores.editar',compact('proveedor','giro','idProv'));
    }

    public function editProv(Request $request,$idProv)
    {
        $of = isset($request->oferente) ? 1 : 0;
        $sb = isset($request->sumBienes) ? 1: 0;
        $ps = isset($request->presServ) ? 1 : 0;
        $cont = isset($request->contratista) ? 1 : 0;

        $proveedor = Proveedore::findOrFail($idProv);
        $proveedor->razon_social = $request->razonSocial;
        $proveedor->giro_categoria = $request->giro;
        $proveedor->credito_fiscal = $request->creditoFiscal;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->estado = $request->estado;
        $proveedor->oferente = $of;
        $proveedor->suministrante_bienes = $sb; 
        $proveedor->prestador_servicios = $ps;
        $proveedor->contratista = $cont;
        $proveedor->save();

        return back()->with('mensaje', 'Proveedor ' . $request->razonSocial . ' ha sido actualizado.');
    }

    public function listarProductos()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    function addProd(Request $request)
    {
        try {
            $producto = Producto::create([
                'producto' => $request->producto,
                'precio' => $request->precio,
                'descuento' => $request->descuento / 100,
                'bangranel' => $request->bangranel,
                'banexcento' => $request->banexcento,
                'unidad_medida' => $request->unidad_medida,
                'unidad_medida_mh' => $request->unidad_medida_hacienda,
                'cod_bar' => $request->cod_bar ?: 'SAN' . date('Y') . str_pad(Producto::max('id_prod') + 1, 8, '0', STR_PAD_LEFT)
            ]);

            $bodegas = [1, 2];
            foreach ($bodegas as $bodega) {
                TInventario::create([
                    'producto' => $producto->id_prod,
                    'cantidad' => 999999999,
                    'ubicacion' => $bodega
                ]);
            }

            if (!$request->cod_bar) {
                $producto->update([
                    'cod_bar' => 'SAN' . date('Y') . str_pad($producto->id_prod, 5, '0', STR_PAD_LEFT)
                ]);
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }

        return back()->with('mensaje', "Producto {$request->producto} agregado éxitosamente");
    }

    public function detaProd($id)
    {
       $producto =  Producto::findOrFail($id);
       $categorias = CateProducto::all();
       $proveedores = Proveedore::all();

       return view('inventario.productos.editar', compact('id','producto','categorias','proveedores'));
    }

    public function modProd(Request $request,$id)
    {
        $producto =  Producto::findOrFail($id);
        $producto->producto = $request->producto;
        $producto->precio = $request->precio;
        $producto->bangranel = $request->bangranel;
        $producto->banexcento = $request->banexcento;
        $producto->descuento = $request->descuento / 100;
        $producto->proveedor = $request->proveedor;
        $producto->descripcion = $request->descripcion;
        $producto->categoria = $request->categoria;
        $producto->cod_bar = $request->cod_bar;
        $producto->save();
        return back()->with('mensaje', "Información de producto {$request->producto} actualizada éxitosamente");


    }

    public function eliminarProducto($id) {
        Producto::where('id_prod', $id)->update(['estado' => 3]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Producto eliminado éxitosamente'
        ]);
    }

    public function addCate(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|min:3'
        ]);
        
        $categoria =  new CateProducto();
        $categoria->categoria =  $request->categoria;
        $categoria->save();
    
        return back()->with('mensaje', 'Categoría agregada éxitosamente');
    }


    public function detaCate($id)
    {
        $categoria = CateProducto::findOrFail($id);
        return view('inventario.categorias-productos.editar',compact('categoria','id'));
    }

    public function modCate(Request $request,$id)
    {
        $categoria =  CateProducto::findOrFail($id);
        $categoria->categoria =  $request->categoria;
        $categoria->save();
    
        return back()->with('mensaje', 'Categoría agregada éxitosamente');
    }

    public function eliminarCategoria($id) {
        $categoria = CateProducto::findOrFail($id);

        try {
            $categoria = CateProducto::destroy($id);
            return back()->with('mensaje', 'Categoría eliminada exitosamente.');
        } catch (Exception $e) {
            return back()->with('mensaje', 'No se pudo eliminar la categoría.');
        }
    }

    public function addCliente(Request $request)
    {
        
        // Validar según el tipo de cliente
        if ($request->input('chk_credito_hidden') === '1') {
            // Cliente con crédito fiscal
                
            $clienteExistente = Cliente::where('credito_fiscal', $request->credito_fiscal)->first();
            if ($clienteExistente) { 
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Ya existe un cliente registrado con ese número de crédito fiscal'
                ]);
            }
        } else {
            // Cliente con DUI
            $clienteExistente = Cliente::where('dui', $request->dui)->first();
            if ($clienteExistente) {
                return response()->json([
                    'success' => false, 
                    'mensaje' => 'Ya existe un cliente registrado con ese número de DUI'
                ]);
            }
        }
        $cliente = new Cliente();
        $cliente->nombre = strtoupper($request->nombre);
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->correo = $request->correo;

        $cliente->id_departamento = $request->departamento;
        $cliente->id_municipio = $request->municipio;


        if ($request->input('chk_credito_hidden') === '1') {
            $des_sactividad = CatActividadesEconomica::where('codigo', $request->actividad_economica)->first();
            $cliente->tipo_cliente = 2;
            $cliente->credito_fiscal = $request->credito_fiscal;
            $cliente->nrc = $request->nrc;
            $cliente->cod_actividad_economica = $request->actividad_economica;
            $cliente->des_actividad_economica = $des_sactividad->descripcion;

        } else {
            $cliente->tipo_cliente = 1;
            $cliente->dui = $request->dui;
        }

        $cliente->save();
        return response()->json([
            'success' => true, 
            'mensaje' => 'Cliente agregado éxitosamente',
            'cliente' => $cliente
        ]);

    }

    public function eliminarCliente($id) {
        $cliente = Cliente::findOrFail($id);

        try {
            $cliente = Cliente::destroy($id);
            return back()->with('mensaje', 'Cliente eliminado exitosamente.');
        } catch (Exception $e) {
            return back()->with('mensaje', 'No se pudo eliminar el cliente.');
        }
    }

    public function detaCliente($id)
    {
        $cliente =  Cliente::findOrFail($id);
        return view('inventario.clientes.editar',compact('cliente','id'));
    }

    public function modCliente(Request $request,$id)
    {
        $cliente =  Cliente::findOrFail($id);
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;

        if (isset($request->chk_credito)) {
            $cliente->tipo_cliente = 2;
            $cliente->credito_fiscal = $request->credito_fiscal;
            $cliente->dui = '';
        } else {
            $cliente->tipo_cliente = 1;
            $cliente->dui = $request->dui;
            $cliente->credito_fiscal = '';
        }
        
        $cliente->estado = $request->estado;
        $cliente->save();

        return back()->with('mensaje', 'Cliente actualizado éxitosamente');
    }


    public function addBodega(Request $request)
    {
        $bodega = new Bodega();

        $bodega->bodega  = $request->nombre;
        $bodega->telefono = $request->telefono;

        $bodega->direccion = $request->direccion;
        $bodega->save();
        
        return back()->with('mensaje', 'Bodega agregada éxitosamente');



    }

    public function detaBodega($id)
    {
        $bodega =  Bodega::findOrFail($id);

        return view('inventario.bodegas.edit-bodega',compact('id','bodega'));
    }

    public function editBodega(Request $request ,$id)
    {
        $bodega =  Bodega::findOrFail($id);

        $bodega->bodega  = $request->nombre;
        $bodega->telefono = $request->telefono;

        $bodega->direccion = $request->direccion;
        $bodega->estado = $request->estado;
        $bodega->save();
        return back()->with('mensaje', 'Bodega actualizada éxitosamente');

        
    }

    public function addInventario(Request $request)
    {
        $idProd = $request->producto;
        $idBod = $request->ubicacion;
        $contar =  TInventario::where('producto',$idProd)->where('ubicacion',$idBod)->count();
        if ( $contar > 0) {
            
            $actualizar =     TInventario::where('producto',$idProd)->where('ubicacion',$idBod)->firstOrFail(); 
             $actualizar->cantidad = $request->cantidad;
            //  $actualizar->unidad_medida = $request->uMedida;
            $actualizar->save();
            return back()->with('mensaje', 'Actualización de inventario éxitosa');


        } else {

            $inventario  = new TInventario();
            $inventario->producto  = $idProd;
            $inventario->cantidad = $request->cantidad;
            // $inventario->unidad_medida = $request->uMedida;
            $inventario->ubicacion= $idBod;
            $inventario->save();
    
            return back()->with('mensaje', 'Producto agregado a inventario éxitosamente');
    
        }
        




      


    }



    public function duplicarProducto(Request $request)
    {
        try {
            $producto = Producto::findOrFail($request->id_producto);
           
            $productonuevo = new Producto();
            $productonuevo->producto = $producto->producto . ' (Copia)';
            $productonuevo->precio = $producto->precio;
            $productonuevo->descripcion = $producto->descripcion;
            $productonuevo->cod_bar = $producto->cod_bar . '-COPIA';
            $productonuevo->unidad_medida = $producto->unidad_medida;
            $productonuevo->bangranel = $producto->bangranel;
            $productonuevo->banexcento = $producto->banexcento;
            $productonuevo->save();

            $bodegas = [1, 2];
            foreach ($bodegas as $bodega) {
                TInventario::create([
                    'producto' => $productonuevo->id_prod,
                    'cantidad' => 999999999,
                    'ubicacion' => $bodega
                ]);
            }
            

            return response()->json(['success' => true, 'message' => 'Producto duplicado éxitosamente',
            'producto' => $productonuevo
        ]); 
        } catch (Exception $e) {
            Log::error('Error al duplicar producto: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al duplicar el producto'], 500);
        }
    }



}
