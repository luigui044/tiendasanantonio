<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatEstadoProducto
 * 
 * @property int $id
 * @property string $estado
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class CatEstadoProducto extends Model
{
	protected $table = 'cat_estado_productos';

	protected $fillable = [
		'estado'
	];

	public function productos()
	{
		return $this->hasMany(Producto::class, 'estado');
	}
}
