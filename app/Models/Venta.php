<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ventum
 * 
 * @property int $id_venta
 * @property int|null $cliente
 * @property int|null $tienda
 * @property Carbon|null $fecha_hora
 * @property float|null $total
 * @property float|null $total_iva
 * @property string|null $comentarios
 * 
 * @property Bodega|null $bodega
 *
 * @package App\Models
 */
class Venta extends Model
{
	protected $table = 'ventas';
	protected $primaryKey = 'id_venta';
	public $timestamps = false;

	protected $casts = [
		'id_vendedor' => 'int',
		'cliente' => 'int',
		'tienda' => 'int',
		'total' => 'float',
		'total_iva' => 'float'
	];

	protected $dates = [
		'fecha_hora'
	];

	protected $fillable = [
		'cliente',
		'nombre_cliente',
		'tienda',
		'fecha_hora',
		'total',
		'total_iva',
		'comentarios',
		'id_vendedor'
	];

	public function elcliente()
	{
		return $this->belongsTo(Cliente::class, 'cliente', 'id_cliente');
	}

	public function bodega()
	{
		return $this->belongsTo(Bodega::class, 'tienda');
	}
	
	public function detalles() {
		return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
	}

	public function factura() {
		return $this->hasOne(Factura::class, 'id_venta', 'id_venta');
	}
}
