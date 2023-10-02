<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('pro_id', 'desc')->get();
        return view('producto.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $producto = new Producto();
        $status = false;

        return view('producto.productos.create', compact('marcas','producto', 'status', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Producto::$rules);
        try {
            DB::beginTransaction();
            Producto::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el producto');
        }

        return redirect()->route('producto.index')->with('success', 'Producto registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $status = true;

        return view('producto.productos.show', compact('producto', 'marcas', 'categorias', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {

        $marcas = Marca::all();
        $categorias = Categoria::all();
        $status = false;

        return view('producto.productos.edit', compact('producto', 'marcas', 'categorias', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $rules = Producto::$rules;
        $rules['pro_nombre'] = 'required | min : 2 | max: 30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $producto->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el producto');
        }

        return redirect()->route('producto.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            DB::beginTransaction();
            $producto->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el producto');
        }
        return redirect()->route('producto.index')->with('success', 'Producto eliminado correctamente');
    }

    /**
     * Busca productos por codigo de barra
     * @param String $codigo
     * @return \Illuminate\Http\JsonResponse
     */

    public function buscarCodigo(String $codigo){
        try {
            DB::beginTransaction();
            $producto = Producto::where('pro_codigo_barra', $codigo)->first();
            if ($producto) {
                return response()->json([
                    'success' => true,
                    'producto' => $producto,
                    'marca' => $producto->marca
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el producto'
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar el producto'
            ]);
        }
    }

    /**
     * Busca productos por id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarId(int $id){
        try {
            DB::beginTransaction();
            $producto = Producto::where('pro_id', $id)->first();
            if ($producto) {
                return response()->json([
                    'success' => true,
                    'producto' => $producto,
                    'marca' => $producto->marca
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el producto'
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar el producto'
            ]);
        }
    }
}
