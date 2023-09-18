<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $subCategoria = SubCategoria::where('subc_id', $request->search)->first();
        }else{
            $subCategoria = new SubCategoria();
        }

        $categorias = Categoria::all();
        $subCategorias = SubCategoria::orderBy('subc_id', 'desc')->get();

        return view('producto.subcategoria.index', compact('subCategoria' , 'subCategorias', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $subCategoria = new SubCategoria();
        return view('producto.subcategoria.create', compact('categoria', 'subCategoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, SubCategoria::$rules);
        try {
            DB::beginTransaction();
            SubCategoria::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la subcategoría');
        }

        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategoria $subCategoria)
    {
        $categorias = Categoria::all();
        return view('producto.subcategoria.show', compact('subCategoria', 'categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategoria $subCategoria)
    {
        $categorias = Categoria::all();
        return view('producto.subcategoria.edit', compact('subCategoria', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategoria $subCategoria, $id)
    {
        $rules = SubCategoria::$rules;
        $rules['subc_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            SubCategoria::find($id)->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la subcategoría');
        }
        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategoria $subCategoria, $id)
    {
        try {
            DB::beginTransaction();
            SubCategoria::find($id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la subcategoría');
        }
        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría eliminada correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $subcategoria = SubCategoria::find($request->id);

            if (count($subcategoria->productos)>0){
                return response()->json([
                    'success' => false,
                    'message' => 'La subcategoría no se puede eliminar porque tiene un producto asociado',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar la subcategoría',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'La subcategoría se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
