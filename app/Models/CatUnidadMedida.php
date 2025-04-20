<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatUnidadMedida
 * 
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 *
 * @package App\Models
 */
class CatUnidadMedida extends Model
{
	protected $table = 'cat_unidad_medida';
	public $timestamps = false;

	protected $fillable = [
		'codigo',
		'nombre'
	];
}
