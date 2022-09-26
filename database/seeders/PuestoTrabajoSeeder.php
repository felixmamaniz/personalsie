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
            'name' => 'No definido',
            'nrovacantes' => '2',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Uno',
            'nrovacantes' => '2',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Dos',
            'nrovacantes' => '2',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Tres',
            'nrovacantes' => '2',
            'estado' => 'Disponible',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Cuatro',
            'nrovacantes' => '2',
            'estado' => 'Disponible',
        ]);
    }
}
