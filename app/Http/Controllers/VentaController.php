<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Historia;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\TipoDocumento;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::all();
        return view('tienda.ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $metodos = MetodoPago::all();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $historias = Historia::all();
        $tipoDocumentos = TipoDocumento::all();
        $cliente = new Cliente();

        return view('tienda.ventas.create', compact('metodos', 'clientes', 'productos', 'historias', 'tipoDocumentos', 'cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }

    /**
     * Busca el numero de una serie
     */
    public function correlativo(String $serie)
    {
        try {
            DB::beginTransaction();
            $venta = Venta::where('ven_serie', $serie)->orderBy('ven_numero', 'desc')->first();
            if ($venta) {
                return response()->json([
                    'success' => true,
                    'numero' => $venta->ven_numero + 1,
                    'documento' => $this->formatoDocumento($venta->ven_numero + 1, $serie)
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'numero' => 1,
                    'documento' => $this->formatoDocumento(1, $serie)
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al obtener el correlativo'
            ]);
        }
    }

    /**
     * Crear formato de documento de venta (serie + numero)
     * @param integer $numero
     * @param string $serie
     */
    private function formatoDocumento(int $numero, String $serie)
    {
        // Si serie es BOL cambiar a B
        if ($serie == 'BOL') {
            $serie = 'B';
        } else if ($serie == 'FAC') {
            $serie = 'F';
        } else if ($serie == 'NV') {
            $serie = 'P';
        }

        $numero = str_pad($numero, 4, '0', STR_PAD_LEFT);
        return $serie . $numero;
    }
}
