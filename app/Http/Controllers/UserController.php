<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $usuarios = User::all();
        return view('seguridad.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = new User();
        $colaboradores = Colaborador::all();
        $roles = Role::all();
        $role = new Role();
        // $role->id = 0;
        return view('seguridad.usuarios.create', compact('usuario', 'colaboradores', 'roles', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['usu_estado' => 1]);
        $this->validate($request, User::$rules);
        try {
            $request->merge(['usu_contraseña' => bcrypt($request->usu_contraseña)]);
            DB::beginTransaction();
            $usuario = User::create($request->all());
            $role = Role::findById($request->role);
            $usuario->assignRole($role);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el usuario');
        }

        return redirect()->route('usuario.index')->with('success', 'Usuario registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $colaboradores = Colaborador::all();
        $roles = Role::all();
        $role = $usuario->roles->first();
        $usuario->usu_contraseña = '';
        return view('seguridad.usuarios.edit', compact('usuario', 'colaboradores', 'roles', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        if ($request->usu_contraseña == null) {
            $request->merge(['usu_contraseña' => $usuario->usu_contraseña]);
        } else {
            $request->merge(['usu_contraseña' => bcrypt($request->usu_contraseña)]);
        }
        $this->validate($request, User::$rules);
        try {
            DB::beginTransaction();

            $usuario->update($request->all());
            $role = Role::findById($request->rol_id);
            $usuario->syncRoles($role);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el usuario');
        }

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            DB::beginTransaction();
            $usuario->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el usuario');
        }

        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado correctamente');
    }
}
