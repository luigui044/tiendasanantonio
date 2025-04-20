<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id_prod
 * @property string $producto
 * @property float $precio
 * @property int $proveedor
 * @property string $descripcion
 * @property int $categoria
 * @property string $unidad_medida
 * @property string $unidad_medida_mh
 * @property string $cod_bar
 * @property float $descuento
 * @property Proveedore $proveedore
 * @property CateProducto $cate_producto
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
		'categoria' => 'int'
	];

	protected $fillable = [
		'producto',
		'precio',
		'descuento',
		'proveedor',
		'descripcion',
		'categoria',
		'unidad_medida',
		'unidad_medida_mh',
		'cod_bar'
		
	];

	public function proveedore()
	{
		return $this->belongsTo(Proveedore::class, 'proveedor');
	}

	public function cate_producto()
	{
		return $this->belongsTo(CateProducto::class, 'categoria');
	}

	public function detalles()
	{
		return $this->hasMany(DetalleVenta::class, 'producto');
	}
}
