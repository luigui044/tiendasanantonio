<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Swift_Image;

class EnviarFactura extends Mailable
{
   use Queueable, SerializesModels;

      public $venta;
    public $empresa;
    protected $pdfPath;
    protected $jsonPath;
    protected $logoCid; // este contendrá el CID de la imagen
       public function __construct($venta, $empresa, $pdfPath, $jsonPath, $logo)
    {
               $this->venta = $venta;
        $this->empresa = $empresa;
        $this->pdfPath = $pdfPath;
        $this->jsonPath = $jsonPath;
    }

    public function build()
    {
    $logoPath = public_path('assets/logocolor2.png');

        // Usamos withSymfonyMessage para insertar la imagen y obtener el CID
        $this->withSymfonyMessage(function ($message) use ($logoPath) {
            $this->logoCid = $message->embed(Swift_Image::fromPath($logoPath));
        });

        return $this->view('emails.factura')
            ->subject("Factura Electrónica #{$this->venta->numero_control}")
            ->with([
                'venta' => $this->venta,
                'empresa' => $this->empresa,
                'logo' => $this->logoCid, // importante: pasamos el CID ya generado
            ])
            ->attach(storage_path('app/public/' . $this->pdfPath), [
                'as' => "Factura-{$this->venta->uuid}.pdf",
                'mime' => 'application/pdf',
            ])
            ->attach(storage_path('app/public/' . $this->jsonPath), [
                'as' => "Factura-{$this->venta->uuid}.json",
                'mime' => 'application/json',
            ]);

    }
}
