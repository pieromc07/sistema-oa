<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Puesto extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        \App\Models\Puesto::create([
            'pue_nombre' => 'SOPORTE',
            'pue_descripcion' => 'SOPORTE DEL SISTEMA'
        ]);
    }
}
