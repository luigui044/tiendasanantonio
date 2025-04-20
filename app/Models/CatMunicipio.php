<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatMunicipio
 * 
 * @property int $id
 * @property string $codigo_municipio
 * @property string $nombre_municipio
 * @property int|null $id_departamento
 * 
 * @property CatDepartamento|null $cat_departamento
 *
 * @package App\Models
 */
class CatMunicipio extends Model
{
	protected $table = 'cat_municipios';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'id_departamento' => 'int'
	];

	protected $fillable = [
		'codigo_municipio',
		'nombre_municipio',
		'id_departamento'
	];

	public function cat_departamento()
	{
		return $this->belongsTo(CatDepartamento::class, 'id_departamento');
	}
}
