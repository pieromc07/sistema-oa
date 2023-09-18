<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\Puesto;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColaboradorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaboradores = Colaborador::orderBy('col_id', 'desc')->get();
        return view('personal.colaboradores.index', compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoDocumentos = TipoDocumento::all();
        $colaborador = new Colaborador();
        $puestos = Puesto::all();

        return view('personal.colaboradores.create', compact('tipoDocumentos', 'colaborador' , 'puestos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, Colaborador::$rules);
        try {
            DB::beginTransaction();
            Colaborador::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el colaborador');
        }

        return redirect()->route('colaborador.index')->with('success', 'Colaborador registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colaborador $colaborador)
    {
        $tipoDocumentos = TipoDocumento::all();
        $distrito = Distrito::find($colaborador->dis_id);
        $provincia = Provincia::find($distrito->pro_id);
        $departamento = Departamento::find($provincia->dep_id);
        $colaborador->pro_id = $provincia->pro_id;
        $colaborador->dep_id = $departamento->dep_id;
        return view('personal.colaboradores.show', compact('colaborador', 'tipoDocumentos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colaborador $colaborador)
    {
        $tipoDocumentos = TipoDocumento::all();
        $puestos = Puesto::all();
        $distrito = Distrito::find($colaborador->dis_id);
        $provincia = Provincia::find($distrito->pro_id);
        $departamento = Departamento::find($provincia->dep_id);
        $colaborador->pro_id = $provincia->pro_id;
        $colaborador->dep_id = $departamento->dep_id;

        return view('personal.colaboradores.edit', compact('colaborador', 'tipoDocumentos', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colaborador $colaborador)
    {

        $rules = Colaborador::$rules;
        $rules['col_numero_documento'] = 'required | min:8';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $colaborador->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el colaborador');
        }

        return redirect()->route('colaborador.index')->with('success', 'Colaborador actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colaborador $colaborador)
    {
        try {
            DB::beginTransaction();
            $colaborador->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el colaborador');
        }
        return redirect()->route('colaborador.index')->with('success', 'Colaborador eliminado correctamente');
    }

    /**
     * Verificar si se puede eliminar el colaborador
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarEliminar(Request $request)
    {

        try {
            $colaborador = Colaborador::find($request->id);

            if ($colaborador->usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'El colaborador no se puede eliminar porque tiene un usuario asociado',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar el colaborador',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'El colaborador se puede eliminar',
            'status' => 'success'
        ]);
    }
}
