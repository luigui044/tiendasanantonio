<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MesesVentum
 * 
 * @property int|null $mes_numero
 * @property string|null $mes_nombre
 *
 * @package App\Models
 */
class MesesVenta extends Model
{
	protected $table = 'meses_venta';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'mes_numero' => 'int'
	];

	protected $fillable = [
		'mes_numero',
		'mes_nombre'
	];
}
