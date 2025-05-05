<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\User;
use App\Models\VUsuario;
use App\Models\CatGiro;
use App\Models\CateProducto;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\VCliente;
use App\Models\Bodega;
use App\Models\MesesVenta;
use App\Models\Venta;
use App\Models\VProv;
use App\Models\VProd;
use App\Models\VProducto;
use App\Models\VInventario;
use App\Models\VVenta;
use App\Models\VVentasBodega;
use App\Models\VProductosBodega;
use App\Models\VProductosCliente;
use App\Models\VProductosFecha;
use App\Models\CatUnidadMedida;
use App\Models\CatDepartamento;
use App\Models\CatActividadesEconomica; 
use DB;
use JavaScript;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscarProductoPorCodigo($codigo) {
        $producto = VInventario::where('cod_bar', $codigo)  
        ->where('estado', 1)
        ->first();
        return response()->json($producto);
    }

    public function buscarProductos(Request $request) {
        $productos = VInventario::where(function($query) use ($request) {
            $query->where('producto', 'like', '%' . $request->term . '%')
                  ->orWhere('cod_bar', 'like', '%' . $request->term . '%');
        })->where('estado', 1)->get();
        return response()->json($productos);
    }
   
    public function modulos() {
        $rol = auth()->user()->rol;

        switch ($rol) {
            case 1:
            case 2:
                return view('modulos');
            default:
                $submodulos = Modulo::where('ban_padre', 3)->get();
                return view('submodulos', compact('submodulos')); 
        }
    }

    public function submodulos($id = 3)
    {

        

        $submodulos = null;
       
        switch (auth()->user()->rol) {
            case 1:
                if ($id == 1) {
                    $submodulos = Modulo::whereIn('id_modulo', [1, 2, 4])->get();
                } else {
                    $submodulos = Modulo::where('ban_padre', $id)->get();
                }
                break;
            case 2:
                break;
            default:
                $submodulos = Modulo::where('ban_padre', 3)->get();
                break;
        }
        return view('submodulos', compact('submodulos' ));
    }

    public function hijosSubmodulo($id) {

          $ventasPendientes = Venta::where('id_usuario', auth()->user()->id)
    ->where('estado_venta_id', 1)
    ->where('fecha_hora', '>', now()->subHours(48))
    ->count();
        //    Log::info("ventasPendientes: $ventasPendientes");


        if (!is_numeric($id))
            return abort(404);

        $submodulos = Modulo::where('ban_padre', $id)->get();
        if (count($submodulos) > 0) {
            return view('submodulos', compact('submodulos', 'ventasPendientes' ));
        }
        return abort(404);
    }

    private function creacionUsuarios()
    {
        $rol = Rol::all();
        return view('usuarios.registro', compact('rol'));
    }


    private function rolesUsuarios()
    {
        $rol = Rol::all();
        $usuarios = User::where('id', '<>', auth()->user()->id)->get();
        return view('usuarios.roles', compact('rol', 'usuarios'));
    }

    private function modUsuarios()
    {
        $usuarios = VUsuario::all();
        return view('usuarios.modificacion', compact('usuarios'));
    }

    private function proveedores()
    {
        $giro = CatGiro::all();
        $proveedores = VProv::all();
        return view('inventario.proveedores.proveedores', compact('proveedores', 'giro'));
    }

    private function productos()
    {
        $categorias = CateProducto::all();
        $productos = VProd::all();
        $proveedores = VProv::all();
        $unidades = CatUnidadMedida::all();
        return view('inventario.productos.productos', compact('proveedores', 'categorias', 'productos', 'unidades'));
    }

    private function cateProd()
    {
        $categorias = CateProducto::all();
        return view('inventario.categorias-productos.categorias', compact('categorias'));
    }
    public function clientes()
    {
        $clientes  =  VCliente::all();
        $departamentos = CatDepartamento::all();
        $actividades = CatActividadesEconomica::all();               
        return view('inventario.clientes.clientes', compact('clientes', 'departamentos', 'actividades'));
    }
    public function bodegas($modulo)
    {
        $bodegas  =  Bodega::all();
        return view('inventario.bodegas.bodegas', compact('bodegas'));
    }

    public function inventario()
    {
        $inventarios  =  VInventario::all();
        $productos = Producto::where('estado', 1)->get();
        $bodegas = Bodega::where('estado', 1)->get();
        return view('inventario.productos.inventario', compact('inventarios', 'productos', 'bodegas'));
    }

    public function operacionVenta($tipoCliente)
    {
        $clientes = Cliente::where('estado', 1)
        ->where('tipo_cliente', $tipoCliente)
        ->get();
        $departamentos = CatDepartamento::all();
        $actividades = CatActividadesEconomica::all();
        $bodega = config('custom.bodega');

        $productos = VInventario::where('estado', 1)
            ->where(function($query) use ($bodega) {
                $query->where('id_bodega', $bodega)
                      ->orWhere('es_granel', 1);
            })
            ->get();
        
        return view('operaciones.ventas.nuevo', compact('productos', 'clientes', 'tipoCliente', 'departamentos', 'actividades' ));
    }

    public function creditoFiscal()
    {
        $clientes = Cliente::where('estado', 1)->get();
        $bodega = config('custom.bodega');
        $productos = VInventario::where('id_bodega', $bodega)->where('cantidad', '>', 0)->get();
        return view('operaciones.ventas.nuevo', compact('productos', 'clientes'));
    }

    public function resumenGerencial()
    {
        $bodegas = Bodega::where('estado', 1)->orderby('bodega')->get();
        $aniosVenta = Venta::select(DB::raw('DISTINCT(YEAR(fecha_hora)) as anio'))->get();
        $mesesVenta = MesesVenta::all();

        return view('gerencial.index', compact('bodegas', 'mesesVenta', 'aniosVenta'));
    }

    public function informacionGraficosGeneral()
    {
        $topProductos = VProducto::select(DB::raw('SUM(cantidad * precio) as venta_total'), 'producto')
            ->groupby('producto')
            ->orderby(DB::raw('SUM(cantidad * precio)'), 'desc')
            ->get()
            ->take(10);

        $ventaVsCreditoF = VVenta::select(
            DB::raw('SUM(total) as total_venta'),
            DB::raw('CASE ban_cfi WHEN 1 THEN "Venta consumidor final" ELSE "Crédito fiscal" END as tipo')
        )
            ->groupby('ban_cfi')
            ->orderby(DB::raw('SUM(total)'), 'desc')
            ->get();

        $productosBajoStock = VInventario::select('producto', 'cantidad', DB::raw('10 as limite'))
            ->where('cantidad', '<=', 10)
            ->get();

        return response()->json(['topProductos' => $topProductos, 'ventaVsCreditoF' => $ventaVsCreditoF, 'productosBajoStock' => $productosBajoStock]);
    }

    public function informacionGraficosFiltrada(Request $request)
    {
        $topProductos = '';
        $ventaVsCreditoF = '';
        $productosBajoStock = '';

        if (isset($request->bodega)) {
            $idBodega = $request->bodega;

            $topProductos = VProductosBodega::where('tienda', $idBodega)->orderby('venta_total', 'desc')->get()->take(10);

            $ventaVsCreditoF = VVenta::select(
                DB::raw('SUM(total) as total_venta'),
                DB::raw('CASE ban_cfi WHEN 1 THEN "Venta consumidor final" ELSE "Crédito fiscal" END as tipo'),
                'id_bodega'
            )
                ->groupby('ban_cfi', 'id_bodega')
                ->having('id_bodega', $idBodega)
                ->orderby(DB::raw('SUM(total)'), 'desc')
                ->get();

            $productosBajoStock = VInventario::select('producto', 'cantidad', DB::raw('10 as limite'))
                ->where('cantidad', '<=', 10)
                ->where('id_bodega', $idBodega)
                ->get();
        } else if (isset($request->anio) && isset($request->mes)) {
            $anio = $request->anio;
            $mes = $request->mes;

            $topProductos = VProductosFecha::where('anio', 2021)
                ->where('mes', 2)->orderby('venta_total', 'desc')
                ->get()
                ->take(10);

            $ventaVsCreditoF = VVenta::select(
                DB::raw('SUM(total) as total_venta'),
                DB::raw('MONTH(fecha_hora) as mes'),
                DB::raw('YEAR(fecha_hora) as anio'),
                DB::raw('CASE ban_cfi WHEN 1 THEN "Venta consumidor final" ELSE "Crédito fiscal" END as tipo')
            )
                ->where(DB::raw('MONTH(fecha_hora)'), $mes)
                ->where(DB::raw('YEAR(fecha_hora)'), $anio)
                ->groupby('ban_cfi', DB::raw('MONTH(fecha_hora)'), DB::raw('YEAR(fecha_hora)'))
                ->orderby(DB::raw('SUM(total)'), 'desc')
                ->get();

            $productosBajoStock = VInventario::select('producto', 'cantidad', DB::raw('10 as limite'))
                ->where('cantidad', '<=', 10)
                ->where(DB::raw('MONTH(fecha_actualizacion)'), $mes)
                ->where(DB::raw('YEAR(fecha_actualizacion)'), $anio)
                ->get();
        }

        return response()->json([
            'topProductosFiltro' => $topProductos,
            'ventaVsCreditoFFiltro' => $ventaVsCreditoF,
            'productosBajoStockFiltro' => $productosBajoStock
        ]);
    }

    public function topProductosTipoCliente(Request $request)
    {
        $cliente = $request->cliente;
        $topProductos = VProductosCliente::where('tipo_cliente', $cliente)->orderby('venta_total', 'desc')->get()->take(10);
        return response()->json(['topProductosTipoCliente' => $topProductos]);
    }

    public function gestion($modulo)
    {
        switch ($modulo) {

            case 5:
                return $this->rolesUsuarios();
            case 6:
                return $this->creacionUsuarios();
            case 7:
                return $this->modUsuarios();
            case 8:
                return $this->clientes();
            case 9:
                return $this->proveedores();
            case 10:
                return $this->productos();
            case 11:
                return $this->inventario();
            case 12:
                return $this->operacionVenta(1);
            case 13:
                return $this->operacionVenta(2);
            case 14:
                return redirect()->route('egresos.inicio');
            case 16:
                return $this->resumenGerencial();
            case 18:
                return $this->cateProd();
            case 19:
                return $this->bodegas($modulo);
            default:
                return abort(404);
        }
    }
}
