<?php

use App\Http\Controllers\EgresosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Inventario;
use App\Http\Controllers\Operaciones;

use App\Http\Controllers\Impresiones;
use App\Http\Controllers\VentasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false, // Register Routes...
]);

Route::get('/', [HomeController::class, 'modulos'])->middleware('auth')->name('inicio');
Route::get('/submodulos/{id?}', [HomeController::class,'submodulos'])->name('submodulos');
Route::get('/submodulo/{id}', [HomeController::class, 'hijosSubmodulo'])->name('submodulo.hijos');
Route::get('/gestion/{modulo}', [HomeController::class,'gestion'])->name('operacion');
Route::post('registro',[Usuarios::class,'registro'])->name('registro');

Route::put('roles', [Usuarios::class,'cambioRol'])->name('actRol');
Route::get('actUser/{id}',[Usuarios::class,'actUser'])->name('actUser');
Route::put('actUser/{id}',[Usuarios::class,'actUser2'])->name('actUser2');
Route::put('resetpass/{id}',[Usuarios::class,'resetpass'])->name('resetpass');
Route::put('cambiarPass',[Usuarios::class,'cambiarPass'])->name('cambiarPass');

Route::get('detaProv/{idProv}',[Inventario::class,'detaProv'])->name('detaProv');

Route::post('addProv',[Inventario::class,'addProv'])->name('addProv');

Route::put('editProv/{idProv}',[Inventario::class,'editProv'])->name('editProv');


Route::post('addProd',[Inventario::class,'addProd'])->name('addProd');
Route::get('modProd/{id}',[Inventario::class,'detaProd'])->name('detaProd');
Route::put('modProd/{id}',[Inventario::class,'modProd'])->name('modProd');


Route::post('addCate',[Inventario::class,'addCate'])->name('addCate');
Route::get('modCate/{id}',[Inventario::class,'detaCate'])->name('detaCate');
Route::put('modCate/{id}',[Inventario::class,'modCate'])->name('modCate');
Route::delete('categorias/eliminar/{id}',[Inventario::class, 'eliminarCategoria'])->name('categorias.eliminar');

Route::post('addCliente',[Inventario::class,'addCliente'])->name('addCliente');
Route::get('modCliente/{id}',[Inventario::class,'detaCliente'])->name('detaCliente');
Route::put('modCliente/{id}',[Inventario::class,'modCliente'])->name('modCliente');
Route::delete('clientes/eliminar/{id}', [Inventario::class, 'eliminarCliente'])->name('clientes.eliminar');

Route::post('addBodega',[Inventario::class,'addBodega'])->name('addBodega');
Route::get('modBodega/{id}',[Inventario::class,'detaBodega'])->name('detaBodega');
Route::put('modBodega/{id}',[Inventario::class,'editBodega'])->name('editBodega');


Route::post('addInventario',[Inventario::class,'addInventario'])->name('addInventario');


Route::post('filtProd',[VentasController::class,'filtProd'])->name('filtProd');
Route::post('filtProd2',[VentasController::class,'filtProd2'])->name('filtProd2');
Route::post('filtCant',[VentasController::class,'filtCant'])->name('filtCant');

// Ventas consumidor final
Route::get('/ventas/inicio', [VentasController::class, 'inicio'])->name('ventas.inicio');
Route::post('/ventas/nueva',[VentasController::class, 'nueva'])->name('ventas.crear.post');
Route::get('/ventas/detalle/{id}', [VentasController::class, 'detalle'])->name('ventas.detalle');
Route::get('/ventas/factura/{id_venta}',[VentasController::class, 'factura'])->name('ventas.factura');

Route::get('prin/{venta}',[Impresiones::class,'reciboVenta'])->name('reciboVenta2');
Route::get('print/{venta}',[Impresiones::class,'reciboVenta'])->name('reciboVenta3');

// Egresos
Route::get('/egresos/inicio', [EgresosController::class, 'inicio'])->name('egresos.inicio');
Route::get('/egresos/nuevo', [EgresosController::class, 'nuevo'])->name('egresos.crear.get');
Route::post('/egresos/nuevo', [EgresosController::class, 'guardar'])->name('egresos.crear.post');
Route::get('/egresos/detalle/{id}', [EgresosController::class, 'detalles'])->name('egresos.detalle');

// Resumen gerencial
Route::get('/informacion-graficos-general', [HomeController::class, 'informacionGraficosGeneral'])->name('informacionGraficosGeneral');
Route::post('/informacion-graficos-filtrada', [HomeController::class, 'informacionGraficosFiltrada'])->name('informacionGraficosFiltrada');
Route::post('top-productos-tipo-cliente', [HomeController::class, 'topProductosTipoCliente'])->name('topProductosTipoCliente');

Route::get('/prueba', function() {
    $ventaVsCreditoF = App\Models\VVenta::select(DB::raw('SUM(total) as total_venta'), 
                DB::raw('MONTH(fecha_hora) as mes'), DB::raw('YEAR(fecha_hora) as anio'),
                DB::raw('CASE ban_cfi WHEN 1 THEN "Venta consumidor final" ELSE "Crédito fiscal" END as tipo'))
                ->where(DB::raw('MONTH(fecha_hora)'), 2)
                ->where(DB::raw('YEAR(fecha_hora)'), 2021)
                ->groupby('ban_cfi', DB::raw('MONTH(fecha_hora)'), DB::raw('YEAR(fecha_hora)'))
                ->orderby(DB::raw('SUM(total)'), 'desc')
                ->get();
    return $ventaVsCreditoF;
});

Route::view('/proof', 'prueba');