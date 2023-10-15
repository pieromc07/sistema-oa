<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * DEPARTAMENTOS
         */
        \App\Models\Departamento::create([
            'dep_nombre' => 'LA LIBERTAD'
        ]);

        /**
         * PROVINCIAS
         */

        \App\Models\Provincia::create([
            'pro_nombre' => 'PACASMAYO',
            'dep_id' => 1
        ]);

        /**
         * DISTRITOS
         */

        \App\Models\Distrito::create([
            'dis_nombre' => 'PACASMAYO',
            'dis_ubigeo' => '130704',
            'pro_id' => 1
        ]);

        /**
         * TIPO DOCUMENTOS
         */

        \App\Models\TipoDocumento::create([
            'tdo_nombre' => 'DNI'
        ]);

        \App\Models\TipoDocumento::create([
            'tdo_nombre' => 'RUC'
        ]);

        /**
         * PUESTOS
         */

        \App\Models\Puesto::create([
            'pue_nombre' => 'ADMINISTRADOR',
            'pue_descripcion' => 'ADMINISTRADOR DEL SISTEMA'

        ]);

        \App\Models\Puesto::create([
            'pue_nombre' => 'OPTOMETRA',
            'pue_descripcion' => 'OPTOMETRA DEL SISTEMA'
        ]);

        \App\Models\Puesto::create([
            'pue_nombre' => 'VENDEDOR',
            'pue_descripcion' => 'VENDEDOR DEL SISTEMA'
        ]);


        /**
         * COLABORADORES
         */
        \App\Models\Colaborador::create([
            'col_nombre_completo' => 'MERINO CARPIO CARLOS PIERO JUNIOR',
            'tdo_id' => 1,
            'col_numero_documento' => '73951068',
            'col_direccion' => 'LAS PALMERAS 123',
            'col_celular' => '934689657',
            'col_isOptometra' => false,
            'dis_id' => 1,
            'pue_id' => 1
        ]);

        \App\Models\Colaborador::create([
            'col_nombre_completo' => 'TANTALEAN GIL ELIAS SAMUEL',
            'tdo_id' => 1,
            'col_numero_documento' => '70674955',
            'col_direccion' => 'INDENDENCIA 123',
            'col_celular' => '999999999',
            'col_isOptometra' => true,
            'dis_id' => 1,
            'pue_id' => 2
        ]);



        /**
         * ROLES
         */

        $admin = Role::create([
            'name' => 'ADMIN',
            'description' => 'ADMINISTRADOR DEL SISTEMA'
        ]);

        $optometra = Role::create([
            'name' => 'OPTOMETRA',
            'description' => 'OPTOMETRA DEL SISTEMA'
        ]);

        $venta = Role::create([
            'name' => 'VENTAS',
            'description' => 'VENTAS DEL SISTEMA'
        ]);

        /**
         * PERMISOS
         */

        Permission::create([
            'name' => 'roles.index',
            'description' => 'LISTAR ROLES',
            'group' => 'roles'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'roles.create',
            'description' => 'CREAR ROLES',
            'group' => 'roles'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'roles.edit',
            'description' => 'EDITAR ROLES',
            'group' => 'roles'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'roles.destroy',
            'description' => 'ELIMINAR ROLES',
            'group' => 'roles'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'roles.show',
            'description' => 'VER ROLES',
            'group' => 'roles'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'usuarios.index',
            'description' => 'LISTAR USUARIOS',
            'group' => 'usuarios'
        ]);

        Permission::create([
            'name' => 'usuarios.create',
            'description' => 'CREAR USUARIOS',
            'group' => 'usuarios'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'usuarios.edit',
            'description' => 'EDITAR USUARIOS',
            'group' => 'usuarios'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'usuarios.destroy',
            'description' => 'ELIMINAR USUARIOS',
            'group' => 'usuarios'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'usuarios.show',
            'description' => 'VER USUARIOS',
            'group' => 'usuarios'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'colaboradores.index',
            'description' => 'LISTAR COLABORADORES',
            'group' => 'colaboradores'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'colaboradores.create',
            'description' => 'CREAR COLABORADORES',
            'group' => 'colaboradores'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'colaboradores.edit',
            'description' => 'EDITAR COLABORADORES',
            'group' => 'colaboradores'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'colaboradores.destroy',
            'description' => 'ELIMINAR COLABORADORES',
            'group' => 'colaboradores'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'colaboradores.show',
            'description' => 'VER COLABORADORES',
            'group' => 'colaboradores'
        ])->syncRoles([$admin]);

        Permission::create([
            'name' => 'clientes.index',
            'description' => 'LISTAR CLIENTES',
            'group' => 'clientes'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'clientes.create',
            'description' => 'CREAR CLIENTES',
            'group' => 'clientes'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'clientes.edit',
            'description' => 'EDITAR CLIENTES',
            'group' => 'clientes'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'clientes.destroy',
            'description' => 'ELIMINAR CLIENTES',
            'group' => 'clientes'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'clientes.show',
            'description' => 'VER CLIENTES',
            'group' => 'clientes'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'productos.index',
            'description' => 'LISTAR PRODUCTOS',
            'group' => 'productos'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'productos.create',
            'description' => 'CREAR PRODUCTOS',
            'group' => 'productos'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'productos.edit',
            'description' => 'EDITAR PRODUCTOS',
            'group' => 'productos'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'productos.destroy',
            'description' => 'ELIMINAR PRODUCTOS',
            'group' => 'productos'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'productos.show',
            'description' => 'VER PRODUCTOS',
            'group' => 'productos'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.index',
            'description' => 'LISTAR VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.create',
            'description' => 'CREAR VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.edit',
            'description' => 'EDITAR VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.destroy',
            'description' => 'ELIMINAR VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.show',
            'description' => 'VER VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.anular',
            'description' => 'ANULAR VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'ventas.reporte',
            'description' => 'REPORTE VENTAS',
            'group' => 'ventas'
        ])->syncRoles([$admin, $venta]);

        Permission::create([
            'name' => 'historias.index',
            'description' => 'LISTAR HISTORIAS',
            'group' => 'historias'
        ])->syncRoles([$admin, $optometra]);

        Permission::create([
            'name' => 'historias.create',
            'description' => 'CREAR HISTORIAS',
            'group' => 'historias'
        ])->syncRoles([$admin, $optometra]);

        Permission::create([
            'name' => 'historias.edit',
            'description' => 'EDITAR HISTORIAS',
            'group' => 'historias'
        ])->syncRoles([$admin, $optometra]);

        Permission::create([
            'name' => 'historias.destroy',
            'description' => 'ELIMINAR HISTORIAS',
            'group' => 'historias'
        ])->syncRoles([$admin, $optometra]);

        Permission::create([
            'name' => 'historias.show',
            'description' => 'VER HISTORIAS',
            'group' => 'historias'
        ])->syncRoles([$admin, $optometra]);

        Permission::create([
            'name' => 'seguridad.modulo',
            'description' => 'MODULO SEGURIDAD',
            'group' => 'seguridad'
        ])->syncRoles([$admin]);

        /**
         * USUARIOS
         */

        \App\Models\User::create([
            'usu_nombre' => 'ADMIN',
            'usu_contraseña' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'col_id' => 1
        ])->syncPermissions([Permission::all()])->assignRole([$admin]);

        \App\Models\User::create([
            'usu_nombre' => 'OPTOMETRA',
            'usu_contraseña' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'col_id' => 2
        ])->syncPermissions([
            Permission::where('group', 'historias')->get(),
        ])->assignRole([$optometra]);
    }
}
