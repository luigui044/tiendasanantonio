<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;

class EgresosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function inicio() {
        $egresos = Egreso::all();
        return view('operaciones.egresos.inicio', compact('egresos'));
    }

    public function nuevo () {
        return view('operaciones.egresos.nuevo');
    }

    public function guardar(Request $request) {
        $request->validate([
            'concepto' => 'required|string|min:5',
            'monto' => 'required',
            'fecha' => 'required'
        ]);

        $egreso = new Egreso();
        $egreso->concepto = $request->concepto;
        $egreso->monto = $request->monto;
        $egreso->fecha = $request->fecha;
        $egreso->save();

        session()->flash('success', 'Egreso registrado con éxito.');
        return redirect()->route('egresos.crear.get');
    }

    public function detalles($id) {
        $egreso = Egreso::findOrFail($id);

        return view('operaciones.egresos.detalle', compact('egreso'));
    }
}
