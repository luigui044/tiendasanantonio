<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VUsuario
 * 
 * @property string $name
 * @property string $email
 * @property string|null $rol
 * @property string|null $estado
 *
 * @package App\Models
 */
class VUsuario extends Model
{
	protected $table = 'v_usuarios';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'name',
		'email',
		'rol',
		'estado'
	];
}
