<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $marca = Marca::where('mar_id', $request->search)->first();
        } else {
            $marca = new Marca();
        }
        $marcas = Marca::orderBy('mar_id', 'desc')->get();
        return view('producto.marcas.index', compact('marcas', 'marca'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marca = new Marca();
        return view('producto.marcas.create', compact('marca'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Marca::$rules);
        try {
            DB::beginTransaction();
            Marca::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la marca');
        }

        return redirect()->route('marca.index')->with('success', 'Marca registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        return view('producto.marcas.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        return view('producto.marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        $rules = Marca::$rules;
        $rules['mar_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $marca->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la marca');
        }
        return redirect()->route('marca.index')->with('success', 'Marca actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        try {
            DB::beginTransaction();
            $marca->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la marca');
        }
        return redirect()->route('marca.index')->with('success', 'Marca eliminada correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $marca = Marca::find($request->id);

            if (count($marca->productos) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La marca no se puede eliminar porque tiene un producto asociado',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar la marca',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'La marca se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
