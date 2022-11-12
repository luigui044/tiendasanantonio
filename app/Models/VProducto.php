<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VProducto
 * 
 * @property int|null $id_venta
 * @property string $producto
 * @property int|null $cantidad
 * @property float|null $precio
 * @property float|null $precio_iva
 *
 * @package App\Models
 */
class VProducto extends Model
{
	protected $table = 'v_productos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_venta' => 'int',
		'cantidad' => 'int',
		'precio' => 'float',
		'precio_iva' => 'float'
	];

	protected $fillable = [
		'id_venta',
		'producto',
		'cantidad',
		'precio',
		'precio_iva'
	];
}
