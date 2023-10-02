<?php

namespace App\Http\Controllers;

use App\Models\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $tipoCategoria = TipoCategoria::where('tic_id', $request->search)->first();
        } else {
            $tipoCategoria = new TipoCategoria();
        }
        $tipoCategorias = TipoCategoria::orderBy('tic_id', 'desc')->get();
        return view('producto.tipocategorias.index', compact('tipoCategorias', 'tipoCategoria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoCategoria = new TipoCategoria();
        return view('producto.tipocategorias.create', compact('tipoCategoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, TipoCategoria::$rules);
        try {
            DB::beginTransaction();
            TipoCategoria::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el el tipo de categoría');
        }

        return redirect()->route('tipocategoria.index')->with('success', 'Tipo de categoría registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCategoria $tipoCategoria)
    {
        return view('producto.tipocategorias.show', compact('tipoCategoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoCategoria $tipoCategoria)
    {
        return view('producto.tipocategorias.edit', compact('tipoCategoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoCategoria $tipoCategoria, $id)
    {
        $rules = TipoCategoria::$rules;
        $rules['tic_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            TipoCategoria::find($id)->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el tipo de categoría');
        }
        return redirect()->route('tipocategoria.index')->with('success', 'Tipo de categoría actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCategoria $tipoCategoria, $id)
    {
        try {
            DB::beginTransaction();
            TipoCategoria::find($id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el tipo de categoría');
        }
        return redirect()->route('tipocategoria.index')->with('success', 'Tipo de categoriaa eliminado correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $tipoCategoria = TipoCategoria::find($request->id);
            if (count($tipoCategoria->categorias) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'El tipo de categoría no se puede eliminar porque tiene una categoría asociada',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar el tipo de categoría',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'El tipo de categoría se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
