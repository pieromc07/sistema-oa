<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermisosController extends Controller
{

    /**
     *  Rules for validation
     */
    public static $rules = [
        "name" => "required | max:255 | unique:permissions",
        "description" => "required | max:255",
        "group" => "required | max:255",
    ];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permisos = Permission::orderBy('id', 'desc')->get();
        return view('seguridad.permisos.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permiso = new Permission();
        return view('seguridad.permisos.create', compact('permiso'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(self::$rules);

        DB::beginTransaction();
        try {
            Permission::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el permiso');
        }

        return redirect()->route('permiso.index')->with('success', 'Permiso registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permiso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permiso)
    {
        //
        return view('seguridad.permisos.edit', compact('permiso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permiso)
    {
        $rules = self::$rules;
        $rules['name'] = 'required | max:255';
        $request->validate($rules);
        DB::beginTransaction();
        try {
            $permiso->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el permiso');
        }

        return redirect()->route('permiso.index')->with('success', 'Permiso actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permiso)
    {
        try {
            DB::beginTransaction();
            $permiso->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el permiso');
        }
        return redirect()->route('permiso.index')->with('success', 'Permiso eliminado correctamente');
    }
}
