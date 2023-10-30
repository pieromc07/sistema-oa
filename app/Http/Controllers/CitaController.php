<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Colaborador;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::all();
        return view('cita.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cita = new Cita();
        $cliente = new Cliente();
        $tipoDocumentos = TipoDocumento::all();
        $colaboradores = Colaborador::where('col_isOptometra', 1)->get();
        return view('cita.create', compact('cita', 'colaboradores', 'cliente', 'tipoDocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $numeroDocumento = $request->cli_numero_documento;
            $cliente = Cliente::where('cli_numero_documento', $numeroDocumento)->first();
            if ($cliente) {
                $request->merge(['cli_id' => $cliente->cli_id]);
                $request->merge(['cit_estado' => 1]);
                Cita::create($request->all());
                DB::commit();
            } else {
                $request->merge(['cli_contraseña' => bcrypt($request->cli_numero_documento)]);
                $cliente = Cliente::create($request->all());
                $request->merge(['cli_id' => $cliente->cli_id]);
                $request->merge(['cit_estado' => 1]);
                Cita::create($request->all());
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al registrar la cita',
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cita registrada correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        //
    }

    /**
     *  Get Citas by Cliente
     */
    public function citasCliente($id){
        $citas = Cita::where('cli_id', $id)->get();
        // mapear respuesta
        $response = [];
        foreach ($citas as $cita) {

            array_push($response, [
                'cit_id' => $cita->cit_id,
                'cli_id' => $cita->cli_id,
                'col_id' => $cita->col_id,
                'hor_id' => $cita->hor_id,
                'cit_fecha' => $cita->cit_fecha,
                'cit_estado' => $cita->cit_estado,
                'optometra' => $cita->colaboradores->col_nombre_completo,
                'horario' => $cita->horarios->hor_inicio . ' - ' . $cita->horarios->hor_fin,
                'cliente' => $cita->clientes->cli_nombre_completo,
            ]);
        }
        return response()->json([
            'success' => true,
            'citas' => $response
        ]);
    }
}
