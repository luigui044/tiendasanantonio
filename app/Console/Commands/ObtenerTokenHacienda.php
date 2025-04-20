<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ObtenerTokenHacienda extends Command
{
    protected $signature = 'hacienda:obtener-token';
    protected $description = 'Autentica con la API de Hacienda y almacena el token Bearer en cache';

    public function handle()
    {
        $clientId = config('hacienda.client_id');
        $clientSecret = config('hacienda.client_secret');
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = Http::withHeaders($headers)->asForm()->post('https://apitest.dtes.mh.gob.sv/seguridad/auth', [
            
            'user' => $clientId,
            'pwd' => $clientSecret,
        ]);
        if ($response->successful()) {

            $token = $response->json()['body']['token'];
            $expiresIn = 86400; // 24 horas en segundos

            // Almacenar el token en caché
            Cache::put('hacienda_bearer_token', $token, now()->addSeconds($expiresIn));

            $this->info('Token almacenado correctamente');
        } else {
            $this->error('Error al obtener token: ' . $response->body());
        }
    }
}
