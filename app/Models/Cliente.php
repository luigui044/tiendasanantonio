<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $id_cliente
 * @property string $nombre
 * @property string $telefono
 * @property string $direccion
 * @property string $credito_fiscal
 * @property string $dui
 * @property int $estado
 * 
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	protected $primaryKey = 'id_cliente';
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'nombre',
		'telefono',
		'direccion',
		'credito_fiscal',
		'dui',
		'estado'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'estado');
	}

	public function ventas() {
		return $this->hasMany(Venta::class, 'cliente', 'id_cliente');
	}
}
