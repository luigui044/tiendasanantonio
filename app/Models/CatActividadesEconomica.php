<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatActividadesEconomica
 * 
 * @property string|null $codigo
 * @property string|null $descripcion
 *
 * @package App\Models
 */
class CatActividadesEconomica extends Model
{
	protected $table = 'cat_actividades_economicas';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codigo',
		'descripcion'
	];
}
