<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     *  Rules for validation
     */
    public static $rules = [
        "name" => "required | max:255 | unique:roles",
        "description" => "required | max:255",
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::orderBy('id', 'desc')->get();
        return view('seguridad.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rol = new Role();
        $permissions = Permission::all()->groupBy('group');

        return view('seguridad.roles.create', compact('rol', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(self::$rules);
        // dd($request->all());
        try {
            DB::beginTransaction();
            $permissions = $request->permissions ?? [];
            $role = Role::create($request->all());
            for ($i = 0; $i < count($permissions); $i++) {
                $permission = Permission::find($permissions[$i]);
                $role->givePermissionTo($permission);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el rol');
        }

        return redirect()->route('rol.index')->with('success', 'Rol registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $rol)
    {
        $permissions = Permission::all()->groupBy('group');

        return view('seguridad.roles.show', compact('rol', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $rol)
    {

        $permissions = Permission::all()->groupBy('group');

        return view('seguridad.roles.edit', compact('rol', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $rol)
    {
        $rules = self::$rules;
        $rules['name'] = 'required | max:255';
        $request->validate($rules);
        try {
            DB::beginTransaction();
            $permissions = $request->permissions ?? [];

            $rol->update($request->all());
            $rol->permissions()->detach();
            for ($i = 0; $i < count($permissions); $i++) {
                $permission = Permission::find($permissions[$i]);
                $rol->givePermissionTo($permission);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el rol');
        }

        return redirect()->route('rol.index')->with('success', 'Rol actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $rol)
    {
        try {
            DB::beginTransaction();
            $rol->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el rol');
        }

        return redirect()->route('rol.index')->with('success', 'Rol eliminado correctamente');
    }

    /**
     * Verificar si se puede eliminar el rol
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function verificarEliminar(Request $request)
    {
        try {
            $rol = Role::find($request->id);

            if ($rol->users->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el rol porque tiene usuarios asignados',
                    'status' => 'warning'
                ]);
            } else if ($rol->permissions->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el rol porque tiene permisos asignados',
                    'status' => 'warning'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al verificar el rol',
                'status' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Se puede eliminar el rol',
            'status' => 'success'
        ]);
    }
}
