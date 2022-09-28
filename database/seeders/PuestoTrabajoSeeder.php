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
            'name' => 'Gerente',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Contador',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Encargado de Ventas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Cajero Sucursal',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Encargada de Plataformas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Cajero',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);

        PuestoTrabajo::create([
            'name' => 'Supervisor',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Tecnico',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Encargado de Area de Impresoras',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Tecnico en Electronica',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Desarrollador de Sistemas',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Mensajeria',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Programador',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'No Definido',
            'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
    }
}
