<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleVentum
 * 
 * @property int|null $id_venta
 * @property int|null $producto
 * @property int|null $cantidad
 * @property float|null $precio
 * @property float|null $precio_iva
 * 
 *
 * @package App\Models
 */
class DetalleVenta extends Model
{
	protected $table = 'detalles_venta';
	protected $primaryKey = 'id_detalle';
	public $timestamps = false;

	protected $casts = [
		'cantidad' => 'int',
		'precio' => 'float',
		'descuento' => 'float',
		'precio_iva' => 'float'
	];

	protected $fillable = [
		'id_venta',
		'producto',
		'cantidad',
		'precio',
		'descuento',
		'precio_iva'
	];

	public function elproducto()
	{
		return $this->belongsTo(Producto::class, 'producto', 'id_prod');
	}

	public function venta() {
		return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
	}
}
