<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VProductosBodega
 * 
 * @property string $producto
 * @property float|null $venta_total
 * @property int|null $tienda
 *
 * @package App\Models
 */
class VProductosBodega extends Model
{
	protected $table = 'v_productos_bodega';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'venta_total' => 'float',
		'tienda' => 'int'
	];

	protected $fillable = [
		'producto',
		'venta_total',
		'tienda'
	];
}
