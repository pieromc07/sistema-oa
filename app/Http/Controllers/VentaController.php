<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Historia;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\TipoDocumento;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::where('ven_estado', true)->orderBy('ven_id', 'desc')->get();
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
        try {
            DB::beginTransaction();
            $codigos = $request->input('codigos');
            $cantidades = $request->input('cantidades');
            $precios = $request->input('precios');
            $subtotal = 0;
            $impuesto = 0;
            $total = 0;

            $venta = new Venta();
            $venta->cli_id = $request->input('cli_id');
            $venta->usu_id = Auth()->user()->usu_id;
            $venta->met_id = $request->input('met_id');
            $venta->ven_fecha = date('Y-m-d');
            $venta->ven_total = $total;
            $venta->ven_subtotal = $subtotal;
            $venta->ven_impuesto = $impuesto;
            $venta->ven_serie = $request->input('ven_serie');
            $venta->ven_numero = $request->input('ven_numero');
            $venta->ven_estado = true;
            $venta->save();

            foreach ($codigos as $key => $codigo) {
                $producto = Producto::where('pro_codigo_barra', $codigo)->first();
                $producto->pro_stock = $producto->pro_stock - $cantidades[$key];
                $producto->save();
                $ventaDetalle = new VentaDetalle();
                $ventaDetalle->ven_id = $venta->ven_id;
                $ventaDetalle->pro_id = $producto->pro_id;
                $ventaDetalle->vde_cantidad = $cantidades[$key];
                $ventaDetalle->vde_precio = $precios[$key];
                $ventaDetalle->vde_subtotal = ($cantidades[$key] * $precios[$key]) / 1.18;
                $ventaDetalle->vde_impuesto = ($cantidades[$key] * $precios[$key]) - $ventaDetalle->vde_subtotal;
                $ventaDetalle->save();
                $total += $cantidades[$key] * $precios[$key];
            }

            $subtotal = $total / 1.18;
            $impuesto = $total - $subtotal;

            $venta->ven_total = $total;
            $venta->ven_subtotal = $subtotal;
            $venta->ven_impuesto = $impuesto;
            $venta->save();
            DB::commit();

            return redirect()->route('venta.index')->with('success', 'Venta registrada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('venta.create')->with('error', 'Ocurrió un error al registrar la venta ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {

        $detalles = VentaDetalle::where('ven_id', $venta->ven_id)->get();

        return view('tienda.ventas.show', compact('venta', 'detalles'));
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
        try {
            DB::beginTransaction();
            $venta->ven_estado = false;
            $venta->save();
            DB::commit();
            return redirect()->route('venta.index')->with('success', 'Venta eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('venta.index')->with('error', 'Ocurrió un error al eliminar la venta ' . $e->getMessage());
        }
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
