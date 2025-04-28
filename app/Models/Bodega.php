<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bodega
 * 
 * @property int $id_bodega
 * @property string $telefono
 * @property string $bodega
 * @property int $estado
 * @property string|null $direccion
 * @property string $cod_dte
 *
 * @package App\Models
 */
class Bodega extends Model
{
	protected $table = 'bodegas';
	protected $primaryKey = 'id_bodega';
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'telefono',
		'bodega',
		'estado',
		'direccion',
		'cod_dte'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'estado');
	}
}
