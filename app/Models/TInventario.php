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
 * 
 * @property Bodega|null $bodega
 *
 * @package App\Models
 */
class TInventario extends Model
{
	protected $table = 't_inventarios';
	protected $primaryKey = null;

	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'producto' => 'int',
		'cantidad' => 'int',
		'ubicacion' => 'int'
	];

	protected $dates = [
		'fecha_actualizacion'
	];

	protected $fillable = [
		'producto',
		'cantidad',
		'unidad_medida',
		'ubicacion',
		'fecha_actualizacion'
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
