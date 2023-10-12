<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Colaborador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return Response::json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $nombre = $request->nombre;
            $apeMaterno = $request->apellidoMaterno;
            $apePaterno = $request->apellidoPaterno;
            $contraseña = $request->contraseña;

            $count = Colaborador::count();
            $count = $count + 1;
            $colaborador = new Colaborador();
            $colaborador->col_nombres = $nombre;
            $colaborador->col_apellido_materno = $apeMaterno;
            $colaborador->col_apellido_paterno = $apePaterno;
            $colaborador->tdo_id = 1;
            $colaborador->col_numero_documento = self::dni($count);
            $colaborador->pue_id = 1;
            $colaborador->col_isOptometra = 0;
            $colaborador->dis_id = 1;
            $colaborador->save();

            $user = new User();
            $user->usu_nombre = $nombre;
            $user->usu_contraseña = $contraseña;
            $user->usu_estado = 1;
            $user->col_id = $colaborador->col_id;
            $user->save();
            DB::commit();
            return Response::json([
                'message' => 'Usuario creado correctamente',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => 'Error al crear usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function dni($count)
    {
        if ($count < 10) {
            $dni = '0000000' . $count;
        } else if ($count < 100) {
            $dni = '000000' . $count;
        } else if ($count < 1000) {
            $dni = '00000' . $count;
        } else if ($count < 10000) {
            $dni = '0000' . $count;
        } else if ($count < 100000) {
            $dni = '000' . $count;
        } else if ($count < 1000000) {
            $dni = '00' . $count;
        } else if ($count < 10000000) {
            $dni = '0' . $count;
        } else {
            $dni = $count;
        }
        return $dni;
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        $user = User::find($id);
        return Response::json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Int $id)
    {
        try {
            DB::beginTransaction();
            $nombre = $request->nombre;
            $apeMaterno = $request->apellidoMaterno;
            $apePaterno = $request->apellidoPaterno;
            $contraseña = $request->contraseña;

            $user = User::find($id);

            $colaborador = Colaborador::find($user->col_id);
            $colaborador->col_nombres = $nombre;
            $colaborador->col_apellido_materno = $apeMaterno;
            $colaborador->col_apellido_paterno = $apePaterno;
            $colaborador->save();

            $user->usu_nombre = $nombre;
            $user->usu_contraseña = $contraseña;
            $user->save();
            DB::commit();
            return Response::json([
                'message' => 'Usuario actualizado correctamente',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => 'Error al actualizar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Int $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->usu_estado = 0;
            $user->save();
            DB::commit();
            return Response::json([
                'message' => 'Usuario eliminado correctamente',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => 'Error al eliminar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
