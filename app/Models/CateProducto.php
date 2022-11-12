<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CateProducto
 * 
 * @property int $id_categoria
 * @property string $categoria
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class CateProducto extends Model
{
	protected $table = 'cate_productos';
	protected $primaryKey = 'id_categoria';
	public $timestamps = false;

	protected $fillable = [
		'categoria'
	];

	public function productos()
	{
		return $this->hasMany(Producto::class, 'categoria');
	}
}
