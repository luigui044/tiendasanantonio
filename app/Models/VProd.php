<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VProd
 * 
 * @property int $id_prod
 * @property string $producto
 * @property float $precio
 * @property string $descripcion
 * @property string|null $razon_social
 * @property string $categoria
 *
 * @package App\Models
 */
class VProd extends Model
{
	protected $table = 'v_prod';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_prod' => 'int',
		'precio' => 'float'
	];

	protected $fillable = [
		'id_prod',
		'producto',
		'precio',
		'descripcion',
		'razon_social',
		'categoria'
	];
}
