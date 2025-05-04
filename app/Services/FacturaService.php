<?php

namespace App\Services;

use App\Models\Venta;
use App\Models\Factura;
use App\Models\TEmpresa;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class FacturaService
{
    public function generarFactura(Venta $venta)
    {
        try {
            // Si ya existe el PDF, retornar la ruta
            if ($venta->url_pdf) {
                return storage_path('app/public/' . $venta->url_pdf);
            }   
            $empresa = TEmpresa::first();
            $factura = Factura::where('id_venta', $venta->id_venta)->first();

            if ($factura === null) {
                $nuevaFactura = new Factura();
                $nuevaFactura->id_venta = $venta->id_venta;
                $nuevaFactura->generada = 1;
                $nuevaFactura->ultima_fecha_generacion = date('Y-m-d');
                $nuevaFactura->save();
            } else {
                $factura->generada += 1;
                $factura->ultima_fecha_generacion = date('Y-m-d');
                $factura->save();
            }

            // Convertir logo a base64
            $logoPath = public_path('assets/logo3.png');
            $logoBase64 = base64_encode(file_get_contents($logoPath));

            // Generar URL para el QR
            $urlFactura = 'https://admin.factura.gob.sv/consultaPublica?ambiente='.config('custom.ambiente_dte') .'&codGen='.$venta->uuid.'&fechaEmi='.date_format(date_create($venta->fecha_hora), 'Y-m-d');
            
            // Generar QR como base64
            $qrCode = QrCode::format('png')
                            ->size(100)
                            ->margin(1)
                            ->generate($urlFactura);
            $qrBase64 = base64_encode($qrCode);

            $pdf = new Dompdf();
            $pdf->loadHtml(view('operaciones.recibos.venta', compact('empresa', 'venta', 'logoBase64', 'qrBase64'))->render());    
            $pdf->setPaper([0, 0, 141.732, 950.394], 'portrait'); // 50mm x 335mm
            $pdf->render();

            // Generar nombre único para el archivo PDF
            $nombreArchivo = "venta_{$venta->id_venta}_" . date_format(date_create($venta->fecha_hora), 'd-m-Y') . '.pdf';
            
            // Guardar PDF en storage/app/public/facturas
            $rutaGuardado = storage_path('app/public/facturas/' . $nombreArchivo);
            file_put_contents($rutaGuardado, $pdf->output());

            // Actualizar la URL del PDF en la venta
            $venta->url_pdf = 'facturas/' . $nombreArchivo;
            $venta->save();

            return $rutaGuardado;
        } catch (\Exception $e) {
            Log::error('Error al generar factura: ' . $e->getMessage());
            throw $e;
        }
    }
} 