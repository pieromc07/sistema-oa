<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\SubCategoria;
use App\Models\UnidadMedida;
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
        return view('producto.producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategorias = SubCategoria::all();
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $unidadesMedidas = UnidadMedida::all();
        $producto = new Producto();
        $status = false;

        return view('producto.producto.create', compact('subcategorias', 'marcas', 'modelos', 'unidadesMedidas', 'producto', 'status'));
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
        $subcategorias = SubCategoria::all();
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $unidadesMedidas = UnidadMedida::all();
        $status = true;

        return view('producto.producto.show', compact('producto', 'subcategorias', 'marcas', 'modelos', 'unidadesMedidas', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $subcategorias = SubCategoria::all();
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $unidadesMedidas = UnidadMedida::all();
        $status = false;

        return view('producto.producto.edit', compact('producto', 'subcategorias', 'marcas', 'modelos', 'unidadesMedidas', 'status'));
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
}
