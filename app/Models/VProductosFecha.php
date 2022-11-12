<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VProductosFecha
 * 
 * @property string $producto
 * @property float|null $venta_total
 * @property int|null $mes
 * @property int|null $anio
 *
 * @package App\Models
 */
class VProductosFecha extends Model
{
	protected $table = 'v_productos_fecha';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'venta_total' => 'float',
		'mes' => 'int',
		'anio' => 'int'
	];

	protected $fillable = [
		'producto',
		'venta_total',
		'mes',
		'anio'
	];
}
