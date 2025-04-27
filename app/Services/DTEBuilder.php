<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class DTEBuilder
{
    public static function build($venta, $empresa, $tipo)
    {
        // Log::info("Tipo de DTE: $tipo");
        
        switch ($tipo) {
            case 1:
                return self::buildConsumidorFinal($venta, $empresa);
            case 2:
                return self::buildCreditoFiscal($venta, $empresa);
            default:
                throw new \Exception("Tipo de DTE no soportado: $tipo");
        }
    }

    private static function buildConsumidorFinal($venta, $empresa)
    {
        $json = [
                "nit" => $empresa->nit,
                "activo" => true,
                "passwordPri" => $empresa->password_firmador,
                "dteJson" => [
                    "identificacion" => [
                        "version" => 1,
                        "ambiente" => env('AMBIENTE_DTE'),  
                        "tipoDte" => "01",
                        "numeroControl" => $venta->numero_control,
                        "codigoGeneracion" => (string)$venta->uuid,
                        "tipoModelo" => 1,
                        "tipoOperacion" => 1,
                        "fecEmi" => date('Y-m-d', strtotime($venta->fecha_hora)),
                        "horEmi" => date('H:i:s', strtotime($venta->fecha_hora)),
                        "tipoMoneda" => "USD",
                        "tipoContingencia" => null,
                        "motivoContin" => null
                    ],
                    "emisor" => [
                        "nit" => $empresa->nit,
                        "nrc" => $empresa->nrc, 
                        "nombre" => $empresa->nombre_empresa,
                        "codActividad" => $empresa->cod_actividad_economica,
                        "descActividad" => $empresa->actividad_economica,
                        "nombreComercial" => $empresa->nombre_empresa,
                        "tipoEstablecimiento" => "01",
                        "codEstableMH" => "0001",
                        "codEstable" => "0001",
                        "codPuntoVentaMH" => "0001",
                        "codPuntoVenta" => "0001",
                        "direccion" => [
                            "departamento" => "02",
                            "municipio" => "17",
                            "complemento" => $empresa->direccion_empresa
                        ],
                        "telefono" => $empresa->telefono_empresa,
                        "correo" => $empresa->correo_empresa
                    ],
                    "receptor" => [
                        "nombre" => $venta->elcliente->dui != '00000000-0'   ? $venta->elcliente->nombre : null,
                        "tipoDocumento" => $venta->elcliente->dui != '00000000-0' ? '13' : null,
                        "numDocumento" => $venta->elcliente->dui != '00000000-0' ? $venta->elcliente->dui : null,
                        "nrc" => $venta->elcliente->credito_fiscal ? $venta->elcliente->credito_fiscal : null,
                        "codActividad" => null,
                        "descActividad" => null,
                        "direccion" => null,
                        "telefono" => $venta->elcliente->dui != '00000000-0' ? $venta->elcliente->telefono : null,
                        "correo" => $venta->elcliente->dui != '00000000-0' ? $venta->elcliente->correo : null
                    ],
                    "otrosDocumentos" => null,
                    "ventaTercero" => null,
                    "cuerpoDocumento" => [],
                    "resumen" => [
                        "totalNoSuj" => 0.0,
                        "totalExenta" => 0.0,
                        "totalGravada" => round($venta->total_iva, 2),
                        "subTotalVentas" => round($venta->total_iva, 2) ,
                        "descuNoSuj" => 0.0,
                        "descuExenta" => 0.0,
                        "descuGravada" => 0.0,
                        "porcentajeDescuento" => 0.0,
                        "totalDescu" => 0.0,
                        "tributos" => null,
                        "subTotal" => round($venta->total_iva, 2),
                        "ivaRete1" => 0.0,
                        "reteRenta" => 0.0,
                        "totalNoGravado" => 0.0,
                        "totalPagar" => round($venta->total_iva, 2),    
                        "totalIva" => round($venta->total_iva - $venta->total, 2),
                        "saldoFavor" => 0.0,
                        "montoTotalOperacion" => round($venta->total_iva, 2),   
                        "totalLetras" => self::convertirNumeroALetras(round($venta->total_iva, 2)) . "     DOLARES CON " . self::obtenerCentavos(round($venta->total_iva, 2)) . "/100",       
                        "condicionOperacion" => 1,
                        "numPagoElectronico" => null,
                        "pagos" => null
                    ],
                    "documentoRelacionado" => null,
                    "extension" => null,
                    "apendice" => null
                ]
            ];

            foreach($venta->detalles as $index => $detalle) {
                if($detalle->elproducto->banexcento == 0) {
                    $json["dteJson"]["cuerpoDocumento"][] = [
                        "numItem" => $index + 1,
                        "tipoItem" => 2,
                        "numeroDocumento" => null,
                        "codigo" => $detalle->elproducto->cod_bar,
                        "codTributo" => null,
                    "cantidad" => $detalle->cantidad,
                    "uniMedida" => $detalle->elproducto->unidad_medida_mh,
                    "descripcion" => $detalle->elproducto->producto,
                    "precioUni" => round($detalle->precio_iva, 2),
                        "montoDescu" => 0.0,
                    "ventaNoSuj" => 0.0,
                    "ventaExenta" => 0.0,
                    "ventaGravada" => round($detalle->precio_iva * $detalle->cantidad, 2),
                    "tributos" => null,
                    "psv" => 0.0,
                    "noGravado" => 0.0,
                    "ivaItem" => round( ($detalle->precio_iva - $detalle->precio) * $detalle->cantidad, 2)
                    ];
                }
            }
         //   Log::info(json_encode($json));

        return $json;
    }

    private static function buildCreditoFiscal($venta, $empresa)
    {
        $json = [
            "nit" => $empresa->nit,
            "activo" => true,
            "passwordPri" => $empresa->password_firmador,
            "dteJson" => [
                "identificacion" => [
                    "version" => 3,
                    "ambiente" => env('AMBIENTE_DTE'), 
                    "tipoDte" => "03",
                    "numeroControl" => $venta->numero_control,
                    "codigoGeneracion" => (string)$venta->uuid,
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "tipoContingencia" => null,
                    "motivoContin" => null,
                    "fecEmi" => date('Y-m-d', strtotime($venta->fecha)),
                    "horEmi" => date('H:i:s', strtotime($venta->fecha)),
                    "tipoMoneda" => "USD"
                ],
                "documentoRelacionado" => null,
                 "emisor" => [
                        "nit" => $empresa->nit,
                        "nrc" => $empresa->nrc, 
                        "nombre" => $empresa->nombre_empresa,
                        "codActividad" => $empresa->cod_actividad_economica,
                        "descActividad" => $empresa->actividad_economica,
                        "nombreComercial" => $empresa->nombre_empresa,
                        "tipoEstablecimiento" => "01",
                        "codEstableMH" => "0001",
                        "codEstable" => "0001",
                        "codPuntoVentaMH" => "0001",
                        "codPuntoVenta" => "0001",
                        "direccion" => [
                            "departamento" => "02",
                            "municipio" => "17",
                            "complemento" => $empresa->direccion_empresa
                        ],
                        "telefono" => $empresa->telefono_empresa,
                        "correo" => $empresa->correo_empresa
                    ],
                
                "receptor" => [
                    "nit" => $venta->elcliente->credito_fiscal,
                    "nrc" => $venta->elcliente->nrc,
                    "nombre" => $venta->elcliente->nombre,
                    "codActividad" => $venta->elcliente->cod_actividad_economica,
                    "descActividad" => $venta->elcliente->des_actividad_economica,
                    "nombreComercial" => $venta->elcliente->nombre,
                    "direccion" => [
                        "departamento" => $venta->elcliente->id_departamento,
                        "municipio" => $venta->elcliente->id_municipio,
                        "complemento" => $venta->elcliente->direccion
                    ],
                    "telefono" => $venta->elcliente->telefono,
                    "correo" => $venta->elcliente->correo
                ],
                "otrosDocumentos" => null,
                "ventaTercero" => null,
                "cuerpoDocumento" => [],
                "resumen" => [
                    "totalNoSuj" => 0.0,
                    "totalExenta" => 0.0,
                    "totalGravada" => round($venta->total, 2),
                    "subTotalVentas" => round($venta->total, 2),
                    "descuNoSuj" => 0.0,
                    "descuExenta" => 0.0,
                    "descuGravada" => 0.0,
                    "porcentajeDescuento" => 0.0,
                    "totalDescu" => 0.0,
                    "tributos" => [
                        [
                            "codigo" => "20",
                            "descripcion" => "Impuesto al Valor Agregado 13%",
                            "valor" => round($venta->total_iva - $venta->total, 2)
                        ]
                    ],
                    "subTotal" => round($venta->total, 2),
                    "ivaPerci1" => round($venta->iva_percibido, 2),
                    "ivaRete1" => 0.0,
                    "reteRenta" => 0.0,
                    "montoTotalOperacion" => round($venta->total_iva, 2),
                    "totalNoGravado" => 0.0,
                    "totalPagar" => round($venta->total_iva, 2),
                    "totalLetras" => self::convertirNumeroALetras(round($venta->total_iva, 2)),
                    "saldoFavor" => 0.0,
                    "condicionOperacion" => 1,
                    "pagos" => [
                        [
                            "codigo" => "01",
                            "montoPago" => round($venta->total_iva, 2),
                            "referencia" => null,
                            "plazo" => null,
                            "periodo" => null
                        ]
                    ],
                    "numPagoElectronico" => null
                ],
                "extension" => null,
                "apendice" => null
            ]
        ];

        foreach($venta->detalles as $index => $detalle) {
            $json["dteJson"]["cuerpoDocumento"][] = [
                "numItem" => $index + 1,
                "tipoItem" => 2,
                "numeroDocumento" => null,
                "codigo" => $detalle->elproducto->cod_bar,
                "codTributo" => null,
                "descripcion" => $detalle->elproducto->producto,
                "cantidad" => $detalle->cantidad,
                "uniMedida" => $detalle->elproducto->unidad_medida_mh,
                "precioUni" => round($detalle->precio, 2),
                "montoDescu" => 0.0,
                "ventaNoSuj" => 0.0,
                "ventaExenta" => 0.0,
                "ventaGravada" => round($detalle->precio * $detalle->cantidad, 2),
                "tributos" => ["20"],
                "psv" => 0.0,
                "noGravado" => 0.0
            ];
        }

        return $json;
    }

    public static function buildNotaDeDebito($venta, $empresa)
    {
        $json = [
            "nit" => $empresa->nit,
            "activo" => true,
            "passwordPri" => $empresa->password_firmador,
        ];

        return $json;
    }
    public static function convertirNumeroALetras($numero)
    {
        $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        
        $numero = round($numero, 2);
        $partes = explode('.', number_format($numero, 2, '.', ''));

        $entero = (int)$partes[0];
        $decimal = str_pad($partes[1], 2, '0', STR_PAD_RIGHT);

        $texto = strtoupper($formatter->format($entero));
        $resultado = $texto . ' CON ' . $decimal . '/100';

        return $resultado;
    }

    public static function obtenerCentavos($numero) {
        $partes = explode('.', (string)$numero);
        $decimal = isset($partes[1]) ? $partes[1] : '';

        return $decimal;
    }
}
