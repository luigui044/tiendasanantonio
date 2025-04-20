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
 * @property string $correo
 * @property string $direccion
 * @property string $credito_fiscal
 * @property string $dui
 * @property string $nrc
 * @property int $estado
 * @property string $id_departamento
 * @property string $id_municipio
 * @property string $tipo_cliente
 * @property string $cod_actividad_economica
 * @property string $des_actividad_economica
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
		'correo',
		'direccion',
		'credito_fiscal',
		'dui',
		'nrc',
		'id_departamento',
		'id_municipio',
		'tipo_cliente',
		'cod_actividad_economica',
		'des_actividad_economica'
	];

	public function estado()
	{
		return $this->belongsTo(Estado::class, 'estado');
	}

	public function ventas() {
		return $this->hasMany(Venta::class, 'cliente', 'id_cliente');
	}

}
