<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VInventario
 * 
 * @property string $producto
 * @property string|null $cantidad
 * @property string $bodega
 * @property Carbon|null $fecha_actualizacion
 * @property int $precio
 * @package App\Models
 */
class VInventario extends Model
{
	protected $table = 'v_inventarios';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'fecha_actualizacion'
	];

	protected $fillable = [
		'producto',
		'cantidad',
		'bodega',
		'fecha_actualizacion',
		'precio',
		'descuento'
	];
}
