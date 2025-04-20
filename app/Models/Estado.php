<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado
 * 
 * @property int $id_estado
 * @property string|null $estado
 * 
 * @property Collection|Bodega[] $bodegas
 * @property Collection|Cliente[] $clientes
 * @property Collection|Producto[] $productos
 * @property Collection|Proveedore[] $proveedores
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Estado extends Model
{
	protected $table = 'estados';
	protected $primaryKey = 'id_estado';
	public $timestamps = false;

	protected $fillable = [
		'estado'
	];

	public function bodegas()
	{
		return $this->hasMany(Bodega::class, 'estado');
	}

	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'estado');
	}

	public function productos()
	{
		return $this->hasMany(Producto::class, 'estado');
	}

	public function proveedores()
	{
		return $this->hasMany(Proveedore::class, 'estado');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'ban_estado');
	}
}
