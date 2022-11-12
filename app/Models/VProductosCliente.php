<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VProductosCliente
 * 
 * @property string $producto
 * @property float|null $venta_total
 * @property int $tipo_cliente
 *
 * @package App\Models
 */
class VProductosCliente extends Model
{
	protected $table = 'v_productos_cliente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'venta_total' => 'float',
		'tipo_cliente' => 'int'
	];

	protected $fillable = [
		'producto',
		'venta_total',
		'tipo_cliente'
	];
}
