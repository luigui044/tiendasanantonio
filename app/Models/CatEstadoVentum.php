<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatEstadoVentum
 * 
 * @property int $id
 * @property string $estado
 * 
 * @property Collection|Venta[] $ventas
 *
 * @package App\Models
 */
class CatEstadoVentum extends Model
{
	protected $table = 'cat_estado_venta';
	public $timestamps = false;

	protected $fillable = [
		'estado'
	];

	public function ventas()
	{
		return $this->hasMany(Venta::class, 'estado_venta_id');
	}
}
