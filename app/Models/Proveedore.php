<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Proveedore
 * 
 * @property int $id_proveedor
 * @property string|null $razon_social
 * @property int|null $giro_categoria
 * @property int|null $credito_fiscal
 * @property Carbon|null $fecha_ingreso
 * @property string|null $telefono
 * @property string|null $direccion
 * @property int|null $Oferente
 * @property int|null $Suministrante_bienes
 * @property int|null $prestador_servicios
 * @property int|null $contratista
 * @property int|null $estado
 * 
 * @property CatGiro|null $cat_giro
 *
 * @package App\Models
 */
class Proveedore extends Model
{
	protected $table = 'proveedores';
	protected $primaryKey = 'id_proveedor';
	public $timestamps = false;

	protected $casts = [
		'giro_categoria' => 'int',
		'credito_fiscal' => 'int',
		'Oferente' => 'int',
		'Suministrante_bienes' => 'int',
		'prestador_servicios' => 'int',
		'contratista' => 'int',
		'estado' => 'int'
	];

	protected $dates = [
		'fecha_ingreso'
	];

	protected $fillable = [
		'razon_social',
		'giro_categoria',
		'credito_fiscal',
		'fecha_ingreso',
		'telefono',
		'direccion',
		'Oferente',
		'Suministrante_bienes',
		'prestador_servicios',
		'contratista',
		'estado'
	];

	public function cat_giro()
	{
		return $this->belongsTo(CatGiro::class, 'giro_categoria');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'estado');
	}
}
