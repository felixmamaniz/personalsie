<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PuestoTrabajo;

class PuestoTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PuestoTrabajo::create([
            //1
            'name' => 'Gerente',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //2
            'name' => 'Contador',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //3
            'name' => 'Encargado de Ventas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //4
            'name' => 'Cajero Sucursal',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //5
            'name' => 'Encargada de Plataformas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //6
            'name' => 'Cajero',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);

        PuestoTrabajo::create([
            //7
            'name' => 'Supervisor',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //8
            'name' => 'Tecnico',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //9
            'name' => 'Encargado de Area de Impresoras',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //10
            'name' => 'Tecnico en Electronica',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //11
            'name' => 'Desarrollador de Sistemas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //12
            'name' => 'Mensajeria',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //13
            'name' => 'Programador',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            //14
            'name' => 'No Definido',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
    }
}
