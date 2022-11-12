<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VProv
 * 
 * @property string|null $razon_social
 * @property int|null $credito_fiscal
 * @property Carbon|null $fecha_ingreso
 * @property string|null $telefono
 * @property string|null $direccion
 * @property int|null $Suministrante_bienes
 * @property int|null $prestador_servicios
 * @property int|null $contratista
 * @property string|null $desc_giro
 *
 * @package App\Models
 */
class VProv extends Model
{
	protected $table = 'v_prov';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'credito_fiscal' => 'int',
		'Suministrante_bienes' => 'int',
		'prestador_servicios' => 'int',
		'contratista' => 'int'
	];

	protected $dates = [
		'fecha_ingreso'
	];

	protected $fillable = [
		'razon_social',
		'credito_fiscal',
		'fecha_ingreso',
		'telefono',
		'direccion',
		'Suministrante_bienes',
		'prestador_servicios',
		'contratista',
		'desc_giro'
	];
}
