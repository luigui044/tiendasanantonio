<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id_prod
 * @property string|null $producto
 * @property float|null $precio
 * @property float|null $descuento
 * @property int|null $proveedor
 * @property string|null $descripcion
 * @property int|null $categoria
 * @property string|null $cod_bar
 * @property int|null $estado
 * @property string $unidad_medida
 * @property int $unidad_medida_mh
 * @property string|null $codigo
 * @property int|null $bangranel
 * @property int|null $banexcento
 * 
 * @property CatEstadoProducto|null $cat_estado_producto
 * @property Proveedore|null $proveedore
 * @property CateProducto|null $cate_producto
 * @property Collection|DetallesVentum[] $detalles_venta
 * @property TInventario|null $t_inventario
 *
 * @package App\Models
 */
class Producto extends Model
{
	protected $table = 'productos';
	protected $primaryKey = 'id_prod';
	public $timestamps = false;

	protected $casts = [
		'precio' => 'float',
		'descuento' => 'float',
		'proveedor' => 'int',
		'categoria' => 'int',
		'estado' => 'int',
		'unidad_medida_mh' => 'int',
		'bangranel' => 'int',
		'banexcento' => 'int'
	];

	protected $fillable = [
		'producto',
		'precio',
		'descuento',
		'proveedor',
		'descripcion',
		'categoria',
		'cod_bar',
		'estado',
		'unidad_medida',
		'unidad_medida_mh',
		'codigo',
		'bangranel',
		'banexcento'
	];

	public function cat_estado_producto()
	{
		return $this->belongsTo(CatEstadoProducto::class, 'estado');
	}

	public function proveedore()
	{
		return $this->belongsTo(Proveedore::class, 'proveedor');
	}

	public function cate_producto()
	{
		return $this->belongsTo(CateProducto::class, 'categoria');
	}

	public function detalles_venta()
	{
		return $this->hasMany(DetallesVentum::class, 'producto');
	}

	public function t_inventario()
	{
		return $this->hasOne(TInventario::class, 'producto');
	}
}
