<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Provincia;
use Illuminate\Http\Request;

class PublicaController extends Controller
{
    // RUTAS PUBLICAS

    /*
    * RUTAS CIUDAD
    */
    function departamentos(Request $request)
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos);
    }

    function provincias(Request $request)
    {
        if ($request->dep_id == null) {
            $provincias = Provincia::all();
            return response()->json($provincias);
        }
        $provincias = Provincia::where('dep_id', $request->dep_id)->get();
        return response()->json($provincias);
    }

    function distritos(Request $request)
    {
        if ($request->pro_id == null) {
            $distritos = Distrito::all();
            return response()->json($distritos);
        }
        $distritos = Distrito::where('pro_id', $request->pro_id)->get();
        return response()->json($distritos);
    }
}
