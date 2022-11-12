<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
	protected $table = 'egresos';
	protected $primaryKey = 'id_egreso';
	public $timestamps = false;

	protected $casts = [
		'proveedor' => 'int',
		'cantidad' => 'int',
		'monto' => 'float',
	];

	protected $dates = [
		'fecha',
        'fecha_registro'
	];

	protected $fillable = [
		'concepto',
		'proveedor',
		'cantidad',
		'unidad',
		'monto',
		'fecha',
	];
}
