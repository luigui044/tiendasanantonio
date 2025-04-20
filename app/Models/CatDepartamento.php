<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatDepartamento
 * 
 * @property int $id
 * @property string $descripcion
 * @property string $iso_code
 * @property int $zona_id
 * @property string|null $codigo
 * 
 * @property CatZonasSv $cat_zonas_sv
 * @property Collection|CatMunicipio[] $cat_municipios
 *
 * @package App\Models
 */
class CatDepartamento extends Model
{
	protected $table = 'cat_departamentos';
	public $timestamps = false;

	protected $casts = [
		'zona_id' => 'int'
	];

	protected $fillable = [
		'descripcion',
		'iso_code',
		'zona_id',
		'codigo'
	];

	public function cat_zonas_sv()
	{
		return $this->belongsTo(CatZonasSv::class, 'zona_id');
	}

	public function cat_municipios()
	{
		return $this->hasMany(CatMunicipio::class, 'id_departamento');
	}
}
