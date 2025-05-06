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
        // Inicialización de variables
        $totalGravado = 0;
        $totalIva = 0;
        $items = [];

        // Procesamiento de detalles de venta
        foreach ($venta->eldetalle as $detalle) {
            if ($detalle->elproducto->banexcento == 0) {
                $precioUnitario = round($detalle->precio, 2);
                $precioUnitarioIva = round($detalle->precio_iva, 2);
                           $cantidad = $detalle->cantidad;
                $ivaUnitario = round($precioUnitario * 0.13, 2);
                $montoIva = round($ivaUnitario * $cantidad, 2);
                $ventaGravada = round($precioUnitarioIva * $cantidad, 2);

                $totalGravado += $ventaGravada;
                $totalIva += $montoIva;

                $items[] = [
                    'detalle' => $detalle,
                    'precioUnitario' => $precioUnitario,
                    'cantidad' => $cantidad,
                    'montoIva' => $montoIva,
                    'ventaGravada' => $ventaGravada,
                    'precioUnitarioIva' => $precioUnitarioIva
                ];
            }
        }

        // Cálculo de totales finales
        $totalGravado = round($totalGravado, 2);
        $totalIva = round($totalIva, 2);
        $totalGeneral = round($totalGravado, 2);

        // Construcción de estructura base del JSON
        $json = [
            "nit" => $empresa->nit,
            "activo" => true,
            "passwordPri" => $empresa->password_firmador,
            "dteJson" => [
                "identificacion" => [
                    "version" => 1,
                    "ambiente" => config('custom.ambiente_dte'),
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
                    "codEstableMH" => "S001",
                    "codEstable" => "S001",
                    "codPuntoVentaMH" => "P001",
                    "codPuntoVenta" => "P001",
                    "direccion" => [
                        "departamento" => "02",
                        "municipio" => "17",
                        "complemento" => 'CALLE LIBERTAD 3 AV. SUR,TEXISTEPEQUE, SANTA ANA'
                    ],
                    "telefono" => $empresa->telefono_empresa,
                    "correo" => $empresa->correo_empresa
                ],
                "receptor" => [
                    "nombre" => null,
                    "tipoDocumento" => null,
                    "numDocumento" => null,
                    "nrc" => null,
                    "codActividad" => null,
                    "descActividad" => null,
                    "direccion" => null,
                    "telefono" => null,
                    "correo" => null
                ],
                "otrosDocumentos" => null,
                "ventaTercero" => null,
                "cuerpoDocumento" => [],
                "resumen" => [
                    "totalNoSuj" => 0.0,
                    "totalExenta" => 0.0,
                    "totalGravada" => round($totalGravado, 2),
                    "subTotalVentas" => round($totalGravado, 2),
                    "descuNoSuj" => 0.0,
                    "descuExenta" => 0.0,
                    "descuGravada" => 0.0,
                    "porcentajeDescuento" => 0.0,
                    "totalDescu" => 0.0,
                    "tributos" => null,
                    "subTotal" => round($totalGravado, 2),
                    "ivaRete1" => 0.0,
                    "reteRenta" => 0.0,
                    "totalNoGravado" => 0.0,
                    "totalPagar" => round($totalGeneral, 2),
                    "totalIva" => round($totalIva, 2),
                    "saldoFavor" => 0.0,
                    "montoTotalOperacion" => round($totalGeneral, 2),
                    "totalLetras" => self::convertirNumeroALetras(round($totalGeneral, 2)) . "     DÓLARES CON " . self::obtenerCentavos(round($totalGeneral, 2)) . "/100",
                    "condicionOperacion" => 1,
                    "numPagoElectronico" => null,
                    "pagos" => null
                ],
                "documentoRelacionado" => null,
                "extension" => null,
                "apendice" => null
            ]
        ];

        // Agregar items al cuerpo del documento
        foreach ($items as $index => $item) {
            $json["dteJson"]["cuerpoDocumento"][] = [
                "numItem" => $index + 1,
                "tipoItem" => 1,
                "numeroDocumento" => null,
                "cantidad" => $item['cantidad'],
                "codigo" => $item['detalle']->elproducto->cod_bar,
                "codTributo" => null,
                "uniMedida" => $item['detalle']->elproducto->unidad_medida_mh,
                "descripcion" => $item['detalle']->elproducto->producto,
                "precioUni" => round($item['precioUnitarioIva'], 2),
                "montoDescu" => 0.0,
                "ventaNoSuj" => 0.0,
                "ventaExenta" => 0.0,
                "ventaGravada" => round($item['ventaGravada'], 2),
                "tributos" => null,
                "psv" => 0.0,
                "noGravado" => 0.0,
                "ivaItem" => round($item['montoIva'], 2)
            ];
        }

        return $json;
    }

    private static function buildCreditoFiscal($venta, $empresa)
    {
      // Inicializar variables para totales
      $totalGravado = 0;
      $totalGravadoSinIva = 0;
      $totalIva = 0;
      $totalConIva = 0;
      $ivaPercibido = 0;

      // Calcular totales gravados e IVA para productos no exentos
      foreach($venta->eldetalle as $detalle) {
          if ($detalle->elproducto->banexcento == 0) {
                        
            $cantidad = $detalle->cantidad;
            $precioUnitario = $detalle->precio;
            $ivaItem = self::redondeoMH(($precioUnitario * 0.13) * $cantidad);
             $precioUnitarioIva =  self::redondeoMH($precioUnitario * 1.13);
  
              $subtotal = $precioUnitarioIva * $cantidad;
              $subtotalSinIva = $precioUnitario * $cantidad;
             $totalGravadoSinIva += $subtotalSinIva;
  

            
              $totalIva += $ivaItem;
          }
      }

      // Redondear totales
        $totalIva = self::redondeoMH($totalIva);       
    $totalGravadoSinIva = self::redondeoMH($totalGravadoSinIva );
    $totalGravado = self::redondeoMH($totalGravadoSinIva + $totalIva);      
      $totalConIva = self::redondeoMH($totalGravado + $totalIva);
      $ivaPercibido = self::redondeoMH($totalGravadoSinIva * 0.01); // 1%

      // Construir estructura base del JSON
      $json = [
          "nit" => $empresa->nit,
          "activo" => true,
          "passwordPri" => $empresa->password_firmador,
          "dteJson" => [
              "identificacion" => [
                  "version" => 3,
                  "ambiente" => config('custom.ambiente_dte'),
                  "tipoDte" => "03",
                  "numeroControl" => $venta->numero_control,
                  "codigoGeneracion" => (string)$venta->uuid,
                  "tipoModelo" => 1,
                  "tipoOperacion" => 1,
                  "tipoContingencia" => null,
                  "motivoContin" => null,
                  "fecEmi" => date('Y-m-d', strtotime($venta->fecha_hora)),
                  "horEmi" => date('H:i:s', strtotime($venta->fecha_hora)),
                  "tipoMoneda" => "USD"
              ],
              "emisor" => [
                  "nit" => $empresa->nit,
                  "nrc" => $empresa->nrc,
                  "nombre" => $empresa->nombre_empresa,
                  "codActividad" => $empresa->cod_actividad_economica,
                  "descActividad" => $empresa->actividad_economica,
                  "nombreComercial" => $empresa->nombre_empresa,
                  "tipoEstablecimiento" => "01",
                  "codEstableMH" => "S001",
                  "codEstable" => "S001",
                  "codPuntoVentaMH" => "P001",
                  "codPuntoVenta" => "P001",
                  "direccion" => [
                      "departamento" => "02",
                      "municipio" => "17",
                      "complemento" => 'CALLE LIBERTAD 3 AV. SUR,TEXISTEPEQUE, SANTA ANA'
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
              "resumen" => [
                  "totalNoSuj" => 0.0,
                  "totalExenta" => 0.0,
                  "totalGravada" => $totalGravadoSinIva,
                  "subTotalVentas" => $totalGravadoSinIva,
                  "descuNoSuj" => 0.0,
                  "descuExenta" => 0.0,
                  "descuGravada" => 0.0,
                  "porcentajeDescuento" => 0.0,
                  "totalDescu" => 0.0,
                  "tributos" => [
                      [
                          "codigo" => "20",
                          "descripcion" => "Impuesto al Valor Agregado 13%",
                          "valor" => $totalIva
                      ]
                  ],
                  "subTotal" =>      $totalGravadoSinIva,
                  "ivaPerci1" =>  $venta->elcliente->ban_g_contribuyente == 1 && $totalGravadoSinIva > 100 ? $ivaPercibido : 0.0,
                  "ivaRete1" => 0.0,
                  "reteRenta" => 0.0,
                  "montoTotalOperacion" => $totalGravado,
                  "totalNoGravado" => 0.0,
                  "totalPagar" => $venta->elcliente->ban_g_contribuyente == 1 && $totalGravadoSinIva > 100 ? $ivaPercibido + $totalGravado : $totalGravado,
                  "totalLetras" => self::convertirNumeroALetras($venta->elcliente->ban_g_contribuyente == 1 && $totalGravadoSinIva > 100 ? $ivaPercibido + $totalGravado : $totalGravado),
                  "saldoFavor" => 0.0,
                  "condicionOperacion" => 1,
                  "pagos" => [
                      [
                          "codigo" => "01",
                          "montoPago" =>$venta->elcliente->ban_g_contribuyente == 1 && $totalGravadoSinIva > 100 ? $ivaPercibido + $totalGravado : $totalGravado,
                          "referencia" => null,
                          "plazo" => null,
                          "periodo" => null
                      ]
                  ],
                  "numPagoElectronico" => null
              ],
              "documentoRelacionado" => null,
              "otrosDocumentos" => null,
              "ventaTercero" => null,
              "cuerpoDocumento" => [],
              "extension" => null,
              "apendice" => null
          ]
      ];

      // Agregar detalle de productos al cuerpo del documento
      $contadorItem = 1;
      foreach($venta->eldetalle as $detalle) {
          if ($detalle->elproducto->banexcento == 0) {
                   $cantidad = $detalle->cantidad;  
              $precioUnitario = $detalle->precio;
              $precioUnitarioIva = self::redondeoMH($detalle->precio * 1.13);
       
              $ventaGravada = self::redondeoMH($precioUnitario * $cantidad);
              $montoIva = self::redondeoMH(($precioUnitario - $precioUnitario) * $cantidad);

              $json["dteJson"]["cuerpoDocumento"][] = [
                  "numItem" => $contadorItem,
                  "tipoItem" => 2,
                  "numeroDocumento" => null,
                  "codigo" => $detalle->elproducto->cod_bar,
                  "codTributo" => null,
                  "descripcion" => $detalle->elproducto->producto,
                  "cantidad" => $cantidad,
                  "uniMedida" => $detalle->elproducto->unidad_medida_mh,
                  "precioUni" => $precioUnitario,
                  "montoDescu" => 0.0,
                  "ventaNoSuj" => 0.0,
                  "ventaExenta" => 0.0,
                  "ventaGravada" => $ventaGravada,
                  "tributos" => ["20"],
                  "psv" => 0.0,
                  "noGravado" => 0.0
              ];
              $contadorItem++;
          }
      }

      return $json;

    }

    public static function redondeoMH($valor) {
    $valor = floatval($valor);
    $multiplicado = $valor * 1000; // Para llegar al tercer decimal
    $entero = floor($multiplicado); // Elimina cualquier exceso
    $tercerDecimal = $entero % 10;
    $base = floor($entero / 10); // Esto es el valor con 2 decimales sin redondear

    if ($tercerDecimal >= 5) {
        $base += 1;
    }

    return $base / 100;
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
