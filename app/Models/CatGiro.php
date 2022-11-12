<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatGiro
 * 
 * @property int $id_giro
 * @property string $no_giro
 * @property string|null $desc_giro
 * 
 * @property Collection|Proveedore[] $proveedores
 *
 * @package App\Models
 */
class CatGiro extends Model
{
	protected $table = 'cat_giros';
	protected $primaryKey = 'id_giro';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_giro' => 'int'
	];

	protected $fillable = [
		'no_giro',
		'desc_giro'
	];

	public function proveedores()
	{
		return $this->hasMany(Proveedore::class, 'giro_categoria');
	}
}
