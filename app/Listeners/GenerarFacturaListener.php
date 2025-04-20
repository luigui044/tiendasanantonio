<?php

namespace App\Listeners;

use App\Events\FacturaGenerada;
use App\Services\FacturaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerarFacturaListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $facturaService;

    public function __construct(FacturaService $facturaService)
    {
        $this->facturaService = $facturaService;
    }

    public function handle(FacturaGenerada $event)
    {
        try {
            $this->facturaService->generarFactura($event->venta);
        } catch (\Exception $e) {
            \Log::error('Error en GenerarFacturaListener: ' . $e->getMessage());
            throw $e;
        }
    }
} 