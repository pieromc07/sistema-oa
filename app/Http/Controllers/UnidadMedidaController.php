<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $unidadMedida = UnidadMedida::where('unm_id', $request->search)->first();
        }else{
            $unidadMedida = new UnidadMedida();
        }
        $unidadMedidas = UnidadMedida::orderBy('unm_id', 'desc')->get();
        // dd($unidadMedida);
        return view('producto.unidadmedida.index', compact('unidadMedidas' , 'unidadMedida'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidadMedida = new UnidadMedida();
        return view('producto.unidadmedida.create', compact('unidadMedida'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, UnidadMedida::$rules);
        try {
            DB::beginTransaction();
            UnidadMedida::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la unidad de medida');
        }

        return redirect()->route('unidadmedida.index')->with('success', 'Unidad de medida registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnidadMedida $unidadMedida)
    {
        return view('producto.unidadmedida.show', compact('unidadMedida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnidadMedida $unidadMedida)
    {
        return view('producto.unidadmedida.edit', compact('unidadMedida'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnidadMedida $unidadMedida, $id)
    {
        $rules = UnidadMedida::$rules;
        $rules['unm_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            UnidadMedida::find($id)->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la unidad de medida');
        }
        return redirect()->route('unidadmedida.index')->with('success', 'Unidad de medida actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadMedida $unidadMedida, $id)
    {
        try {
            DB::beginTransaction();
            UnidadMedida::find($id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la unidad de medida');
        }
        return redirect()->route('unidadmedida.index')->with('success', 'Unidad de medida eliminada correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $unidadMedida = UnidadMedida::find($request->id);

            if (count($unidadMedida->productos)>0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La unidad de medida no se puede eliminar porque tiene un producto asociado',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar la unidad de medida',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'La unidad de medida se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
