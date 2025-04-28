<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 * 
 * @property int $id_venta
 * @property int $id_vendedor
 * @property int|null $cliente
 * @property string|null $nombre_cliente
 * @property int|null $tienda
 * @property Carbon|null $fecha_hora
 * @property float|null $total
 * @property float|null $total_iva
 * @property string|null $comentarios
 * @property string $uuid
 * @property string $numero_control
 * @property string|null $url_pdf	
 * @property Bodega|null $bodega
 * @property User $user
 * @property Collection|DetalleVenta[] $eldetalle
 * @property Collection|Factura[] $facturas
 * @property int $id_usuario
 * @property int $id_sucursal
 * @property int $tipo_venta
 * @property float|null $iva
 * @property float|null $iva_percibido
 * @property int|null $estado_venta_id
 * @property string|null $sello_recibido
 * @package App\Models
 */
class Venta extends Model
{
	protected $table = 'ventas';
	protected $primaryKey = 'id_venta';
	public $timestamps = false;

	protected $casts = [
		'id_vendedor' => 'int',
		'tienda' => 'int',
		'fecha_hora' => 'datetime',
		'total' => 'float',
		'total_iva' => 'float'
	];

	protected $fillable = [
		'id_vendedor',
		'cliente',
		'nombre_cliente',
		'tienda',
		'fecha_hora',
		'total',
		'total_iva',
		'comentarios',
		'uuid',
		'numero_control',
		'url_pdf',
		'id_usuario',
		'id_sucursal',
		'tipo_venta',
		'iva',
		'iva_percibido',
		'estado_venta_id',
		'sello_recibido'
	];

	public function elcliente()
	{
		return $this->belongsTo(Cliente::class, 'cliente');
	}

	public function bodega()
	{
		return $this->belongsTo(Bodega::class, 'tienda');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_usuario');
	}

	public function eldetalle()
	{
		return $this->hasMany(DetalleVenta::class, 'id_venta');
	}

	public function facturas()
	{
		return $this->hasMany(Factura::class, 'id_venta');
	}
}
