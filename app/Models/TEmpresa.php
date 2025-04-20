<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TEmpresa
 * 
 * @property int $id
 * @property string $nombre_empresa
 * @property string|null $nombre_comercial
 * @property string $nit
 * @property string $direccion_empresa
 * @property string|null $telefono_empresa
 * @property string|null $correo_empresa
 * @property string|null $tipo_regimen_tributario
 * @property string|null $actividad_economica
 * @property string|null $cod_actividad_economica
 * @property Carbon|null $fecha_inscripcion
 * @property string|null $nrc
 * @property string|null $representante_legal
 * @property string|null $licencia_funcionamiento
 * @property Carbon|null $fecha_vencimiento_licencia
 * @property string|null $certificacion_iva
 * @property string|null $numero_licencia_actividad
 * @property string|null $moneda_local
 * @property float|null $descuento_predeterminado
 * @property string|null $condiciones_pago
 * @property string|null $logo_empresa
 * @property string|null $politicas_empresa
 * @property float|null $limite_credito
 * @property string|null $sucursales
 * @property string|null $idiomas_disponibles
 * @property string|null $configuracion_impuestos
 * @property Carbon $fecha_creacion
 * @property Carbon $fecha_actualizacion
 * @property string|null $usuario_api
 * @property string|null $contrasena_api
 * @property string|null $usuario_firmador
 * @property string|null $contrasena_firmador
 * @property string|null $certificado_digital
 * @property Carbon|null $fecha_expiracion_certificado
 * @property string|null $url_firmador
 * @property string|null $password_firmador
 *
 * @package App\Models
 */
class TEmpresa extends Model
{
	protected $table = 't_empresa';
	public $timestamps = false;

	protected $casts = [
		'fecha_inscripcion' => 'datetime',
		'fecha_vencimiento_licencia' => 'datetime',
		'descuento_predeterminado' => 'float',
		'limite_credito' => 'float',
		'fecha_creacion' => 'datetime',
		'fecha_actualizacion' => 'datetime',
		'fecha_expiracion_certificado' => 'datetime'
	];

	protected $fillable = [
		'nombre_empresa',
		'nombre_comercial',
		'nit',
		'direccion_empresa',
		'telefono_empresa',
		'correo_empresa',
		'tipo_regimen_tributario',
		'actividad_economica',
		'cod_actividad_economica',
		'fecha_inscripcion',
		'nrc',
		'representante_legal',
		'licencia_funcionamiento',
		'fecha_vencimiento_licencia',
		'certificacion_iva',
		'numero_licencia_actividad',
		'moneda_local',
		'descuento_predeterminado',
		'condiciones_pago',
		'logo_empresa',
		'politicas_empresa',
		'limite_credito',
		'sucursales',
		'idiomas_disponibles',
		'configuracion_impuestos',
		'fecha_creacion',
		'fecha_actualizacion',
		'usuario_api',
		'contrasena_api',
		'usuario_firmador',
		'contrasena_firmador',
		'certificado_digital',
		'fecha_expiracion_certificado',
		'url_firmador',
		'password_firmador'
	];
}
