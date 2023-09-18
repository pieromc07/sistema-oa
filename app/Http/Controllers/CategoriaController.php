<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $categoria = Categoria::where('cat_id', $request->search)->first();
        }else{
            $categoria = new Categoria();
        }

        $tipoCategorias = TipoCategoria::all();
        $categorias = Categoria::orderBy('cat_id', 'desc')->get();

        return view('producto.categoria.index', compact('categorias' , 'categoria', 'tipoCategorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoCategorias = TipoCategoria::all();
        $categoria = new Categoria();
        return view('producto.categoria.create', compact('categoria', 'tipoCategorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Categoria::$rules);
        try {
            DB::beginTransaction();
            Categoria::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la categoría');
        }

        return redirect()->route('categoria.index')->with('success', 'Categoría registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $tipoCategorias = TipoCategoria::all();
        return view('producto.categoria.show', compact('categoria', 'tipoCategorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        $tipoCategorias = TipoCategoria::all();
        return view('producto.categoria.edit', compact('categoria', 'tipoCategorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $rules = Categoria::$rules;
        $rules['cat_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $categoria->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la categoría');
        }
        return redirect()->route('categoria.index')->with('success', 'Categoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        try {
            DB::beginTransaction();
            $categoria->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la categoría');
        }
        return redirect()->route('categoria.index')->with('success', 'Categoría eliminada correctamente');
    }

    public function verificarEliminar(Request $request)
    {

        try {
            $categoria = Categoria::find($request->id);

            if (count($categoria->subcategorias)>0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La categoría no se puede eliminar porque tiene una subcategoría asociada',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar la categoría',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'La categoría se eliminó correctamente',
            'status' => 'success'
        ]);
    }
}
