<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VVenta
 * 
 * @property int $id_venta
 * @property string $nombre
 * @property string $bodega
 * @property Carbon|null $fecha_hora
 * @property float|null $total
 * @property float|null $total_iva
 * @property string|null $comentarios
 *
 * @package App\Models
 */
class VVenta extends Model
{
	protected $table = 'v_ventas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_venta' => 'int',
		'total' => 'float',
		'total_iva' => 'float'
	];

	protected $dates = [
		'fecha_hora'
	];

	protected $fillable = [
		'id_venta',
		'nombre',
		'bodega',
		'fecha_hora',
		'total',
		'total_iva',
		'comentarios'
	];
}
