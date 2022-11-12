<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VCliente
 * 
 * @property int $id_cliente
 * @property string $nombre
 * @property string $t_cliente
 * @property string|null $estado
 *
 * @package App\Models
 */
class VCliente extends Model
{
	protected $table = 'v_cliente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cliente' => 'int'
	];

	protected $fillable = [
		'id_cliente',
		'nombre',
		't_cliente',
		'estado'
	];
}
