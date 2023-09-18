<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $modelo = Modelo::where('mod_id', $request->search)->first();
        }else{
            $modelo = new Modelo();
        }
        $modelos = Modelo::orderBy('mod_id', 'desc')->get();
        return view('producto.modelo.index', compact('modelos' , 'modelo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modelo = new Modelo();
        return view('producto.modelo.create', compact('modelo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Modelo::$rules);
        try {
            DB::beginTransaction();
            Modelo::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el modelo');
        }

        return redirect()->route('modelo.index')->with('success', 'Modelo registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo)
    {
        return view('producto.modelo.show', compact('modelo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        return view('producto.modelo.edit', compact('modelo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modelo $modelo)
    {
        $rules = Modelo::$rules;
        $rules['mod_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $modelo->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el modelo');
        }
        return redirect()->route('modelo.index')->with('success', 'Modelo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        try {
            DB::beginTransaction();
            $modelo->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el modelo');
        }
        return redirect()->route('modelo.index')->with('success', 'Modelo eliminado correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $modelo = Modelo::find($request->id);

            if (count($modelo->productos)>0) {
                return response()->json([
                    'success' => false,
                    'message' => 'El modelo no se puede eliminar porque tiene una producto asociado',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar el modelo',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'El modelo se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
