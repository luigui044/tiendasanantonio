<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetallesVentum
 * 
 * @property int $id_detalle
 * @property int|null $id_venta
 * @property int|null $producto
 * @property float|null $cantidad
 * @property float|null $precio
 * @property float|null $descuento
 * @property float|null $precio_iva
 * 
 * @property Venta|null $venta
 *
 * @package App\Models
 */
class DetalleVenta extends Model
{
	protected $table = 'detalles_venta';
	protected $primaryKey = 'id_detalle';
	public $timestamps = false;

	protected $casts = [
		'id_venta' => 'int',
		'producto' => 'int',
		'cantidad' => 'float',
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

	public function venta()
	{
		return $this->belongsTo(Venta::class, 'id_venta');
	}
}
