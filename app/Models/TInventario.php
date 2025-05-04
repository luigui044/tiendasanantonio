<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TInventario
 * 
 * @property int|null $producto
 * @property int|null $cantidad
 * @property string|null $unidad_medida
 * @property int|null $ubicacion
 * @property Carbon|null $fecha_actualizacion
 * @property int|null $no_lote
 * @property Carbon|null $fecha_vencimiento
 * 
 * @property Bodega|null $bodega
 *
 * @package App\Models
 */
class TInventario extends Model
{
	protected $table = 't_inventarios';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'producto' => 'int',
		'cantidad' => 'int',
		'ubicacion' => 'int',
		'fecha_actualizacion' => 'datetime',
		'no_lote' => 'int',
		'fecha_vencimiento' => 'datetime'
	];

	protected $fillable = [
		'producto',
		'cantidad',
		'unidad_medida',
		'ubicacion',
		'fecha_actualizacion',
		'no_lote',
		'fecha_vencimiento'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'producto');
	}

	public function bodega()
	{
		return $this->belongsTo(Bodega::class, 'ubicacion');
	}
}
