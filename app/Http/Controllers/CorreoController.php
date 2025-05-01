<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TEmpresa;
use App\Models\Venta;

class CorreoController extends Controller
{
    public function verPlantillaCorreo()

    {
        $empresa = TEmpresa::first();
        $venta = Venta::find(65);   
        $logo = base64_encode(file_get_contents(public_path('assets/logocolor.png')));
        return view('emails.factura', compact('empresa', 'venta', 'logo'));
    }
}
