<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Colaborador;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $horario = Horario::where('hor_id', $request->search)->first();
        } else {
            $horario = new Horario();
        }
        $horarios = Horario::all();

        return view('persona.horarios.index', compact('horarios', 'horario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $horario = new Horario();
        return view('persona.horarios.create', compact('horario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, Horario::$rules);
        try {
            DB::beginTransaction();
            Horario::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el horario');
        }

        return redirect()->route('horario.index')->with('success', 'Horario registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        return view('persona.horarios.show', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        return view('persona.horarios.edit', compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $rules = Horario::$rules;
        $rules['hor_inicio'] = 'required | min:2 | max:30';
        $rules['hor_fin'] = 'required | min:2 | max:30';
        $this->validate($request, $rules);
        try {
            DB::beginTransaction();
            $horario->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el horario');
        }

        return redirect()->route('horario.index')->with('success', 'Horario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        try {
            DB::beginTransaction();
            $horario->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el horario');
        }

        return redirect()->route('horario.index')->with('success', 'Horario eliminado correctamente');
    }

    public function verificarEliminar(Request $request)
    {
        try {
            $horario = Horario::findOrFail($request->id);
            if ($horario->citas->count() > 0) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el horario porque tiene citas asociadas']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar el horario']);
        }

        return response()->json(['success' => true, 'message' => 'Se puede eliminar el horario']);
    }

    public function horarios($fecha)
    {
        if ($fecha == NULL) {
            $fecha = date('Y-m-d');
        }
        // Zona horaria de Perú
        $time = date('H:i:s',time() + (3600 * (-5)));

        if($fecha < date('Y-m-d')){
            return response()->json([]);
        }

        $date = date('Y-m-d', strtotime($fecha));
        DB::statement('CREATE TEMPORARY TABLE horarios_optometras (hoo_id int primary key auto_increment, hor_id int, hoo_fecha date, col_id int)');
        $horarios = Horario::all();
        $colaboradores = Colaborador::where('col_isOptometra', true)->get();
        foreach ($colaboradores as $colaborador) {
            foreach ($horarios as $horario) {
                DB::insert('INSERT INTO horarios_optometras (hor_id, hoo_fecha, col_id) VALUES (?, ?, ?)', [$horario->hor_id, $date, $colaborador->col_id]);
            }
        }
        if($fecha == date('Y-m-d'))
            $horarios = DB::select('SELECT col.col_id,  hor.hor_id, hoo.hoo_fecha AS fecha,  TIME_FORMAT(hor.hor_inicio, "%h:%i %p") AS inicio, TIME_FORMAT(hor.hor_fin, "%h:%i %p") AS fin, CONCAT(col.col_nombre_completo) AS optometra FROM horarios_optometras AS hoo INNER JOIN horarios AS hor ON hoo.hor_id = hor.hor_id INNER JOIN colaboradores AS col ON hoo.col_id = col.col_id WHERE hoo_fecha =
            ? AND hor.hor_inicio >= ?', [$date,  $time]);
        else
            $horarios = DB::select('SELECT col.col_id,  hor.hor_id, hoo.hoo_fecha AS fecha,  TIME_FORMAT(hor.hor_inicio, "%h:%i %p") AS inicio, TIME_FORMAT(hor.hor_fin, "%h:%i %p") AS fin, CONCAT(col.col_nombre_completo) AS optometra FROM horarios_optometras AS hoo INNER JOIN horarios AS hor ON hoo.hor_id = hor.hor_id INNER JOIN colaboradores AS col ON hoo.col_id = col.col_id WHERE hoo_fecha =
            ?', [$date]);

        $citas = Cita::where('cit_fecha', $date)->where('cit_estado', '=', true)->get();

        $response = [];
        if($citas->count() == 0){
            return response()->json($horarios);
        }
        foreach ($citas as $cita) {
            foreach ($horarios as $key => $horario) {
                if ($cita->hor_id == $horario->hor_id && $cita->col_id == $horario->col_id) {

                }else{
                    array_push($response, $horario);
                }
            }
        }


        return response()->json($response);
    }
}
