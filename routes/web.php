<?php

use App\Http\Controllers\EgresosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Inventario;
use App\Http\Controllers\Operaciones;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\Impresiones;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\CorreoController;

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
Route::delete('prod/eliminar/{id}', [Inventario::class, 'eliminarProducto'])->name('prod.eliminar');
Route::post('duplicar-producto', [Inventario::class, 'duplicarProducto'])->name('duplicar-producto');
Route::get('buscar-productos', [HomeController::class, 'buscarProductos'])->name('buscar-productos');

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
Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::controller(VentasController::class)->group(function () {
        Route::get('/inicio', 'inicio')->name('inicio');
        Route::post('/nueva', 'nueva')->name('crear.post');
        Route::get('/detalle/{id}', 'detalle')->name('detalle');
        Route::get('/factura/{id_venta}', 'factura')->name('factura');
        Route::get('/ticket/{id_venta}', 'ticketRawBT')->name('ticket');
        Route::get('/ticket2/{id_venta}', 'ticketRawBT2')->name('ticket2');
        Route::post('/guardar-venta', 'guardarVenta')->name('guardar-venta');
    });
});

Route::get('prin/{venta}',[Impresiones::class,'reciboVenta'])->name('reciboVenta2');
Route::get('print/{venta}',[Impresiones::class,'reciboVenta'])->name('reciboVenta3');

// Egresos
// Egresos
Route::prefix('egresos')->name('egresos.')->group(function () {
    Route::controller(EgresosController::class)->group(function () {
        Route::get('/inicio', 'inicio')->name('inicio');
        Route::get('/nuevo', 'nuevo')->name('crear.get');
        Route::post('/nuevo', 'guardar')->name('crear.post');
        Route::get('/detalle/{id}', 'detalles')->name('detalle');
    });
});

// Resumen gerencial
Route::get('/informacion-graficos-general', [HomeController::class, 'informacionGraficosGeneral'])->name('informacionGraficosGeneral');
Route::post('/informacion-graficos-filtrada', [HomeController::class, 'informacionGraficosFiltrada'])->name('informacionGraficosFiltrada');
Route::post('top-productos-tipo-cliente', [HomeController::class, 'topProductosTipoCliente'])->name('topProductosTipoCliente');

Route::get('/producto/{codigo}', [HomeController::class, 'buscarProductoPorCodigo']);

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

Route::get('/obtener-municipios', [CatalogosController::class, 'obtenerMunicipios'])->name('obtenerMunicipios');     

Route::post('/enviarDTE', [VentasController::class, 'enviarDTE'])->name('enviarDTE');

Route::get('/ver-plantilla-correo', [CorreoController::class, 'verPlantillaCorreo'])->name('verPlantillaCorreo');
