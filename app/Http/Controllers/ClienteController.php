<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::OrderBy('cli_nombre_completo', 'ASC')->get();
        return view('tienda.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoDocumentos = TipoDocumento::all();
        $cliente = new Cliente();
        return view('tienda.clientes.create', compact('tipoDocumentos', 'cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Cliente::$rules);
        try {
            DB::beginTransaction();
            Cliente::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el cliente');
        }
        return redirect()->route('cliente.index')->with('success', 'Cliente registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $tipoDocumentos = TipoDocumento::all();
        $distrito = Distrito::find($cliente->dis_id);
        $provincia = Provincia::find($distrito->pro_id);
        $departamento = Departamento::find($provincia->dep_id);
        $cliente->pro_id = $provincia->pro_id;
        $cliente->dep_id = $departamento->dep_id;
        return view('tienda.clientes.show', compact('cliente', 'tipoDocumentos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $tipoDocumentos = TipoDocumento::all();
        $distrito = Distrito::find($cliente->dis_id);
        $provincia = Provincia::find($distrito->pro_id);
        $departamento = Departamento::find($provincia->dep_id);
        $cliente->pro_id = $provincia->pro_id;
        $cliente->dep_id = $departamento->dep_id;
        return view('tienda.clientes.edit', compact('cliente', 'tipoDocumentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $rules = Cliente::$rules;
        $rules['cli_numero_documento'] = 'required | min:8';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $cliente->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el cliente');
        }
        return redirect()->route('cliente.index')->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            DB::beginTransaction();
            $cliente->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el cliente');
        }
        return redirect()->route('cliente.index')->with('success', 'Cliente eliminado correctamente');
    }

    /**
     * Verificar si se puede eliminar el cliente
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarEliminar(Request $request)
    {
        try {
            $cliente = Cliente::find($request->id);
            if ($cliente->ventas->count() > 0 || $cliente->historias->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el cliente porque tiene ventas o historias asociadas',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar el cliente',
                'status' => 'error'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Se puede eliminar el cliente',
            'status' => 'success'
        ]);
    }

    /**
     * Registra un cliente desde la venta
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request)
    {
        $this->validate($request, Cliente::$rules);
        try {
            DB::beginTransaction();
            $cliente = Cliente::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al registrar el cliente'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente',
            'cliente' => $cliente
        ]);
    }
}
