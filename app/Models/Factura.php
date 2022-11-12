<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
	protected $table = 'facturas';
	public $timestamps = false;

	protected $casts = [
        'id_venta' => 'int',
		'generada' => 'int',
	];

	protected $dates = [
        'ultima_fecha_generacion'
	];

	protected $fillable = [
		'generada',
		'ultima_fecha_generacion',
	];

    public function venta() {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }    
}

