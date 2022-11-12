<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Modulo
 * 
 * @property int $id_modulo
 * @property string|null $desc_modulo
 * @property int|null $ban_padre
 *
 * @package App\Models
 */
class Modulo extends Model
{
	protected $table = 'modulos';
	protected $primaryKey = 'id_modulo';
	public $timestamps = false;

	protected $casts = [
		'ban_padre' => 'int'
	];

	protected $fillable = [
		'desc_modulo',
		'ban_padre',
		'icono'
	];
}
