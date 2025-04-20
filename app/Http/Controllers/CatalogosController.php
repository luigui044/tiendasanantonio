<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use App\Models\CatMunicipio;
use App\Models\CatDepartamento;
use Illuminate\Support\Facades\Log;
class CatalogosController extends Controller
{
    public function obtenerMunicipios(Request $request)
    {
        $id_departamento = CatDepartamento::where('codigo', $request->id_departamento)->first();
        $municipios = CatMunicipio::where('id_departamento', $id_departamento->id)->get();
        return response()->json($municipios);
    }
}
