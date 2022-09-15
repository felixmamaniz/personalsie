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
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Uno',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Dos',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Tres',
        ]);
        PuestoTrabajo::create([
            'name' => 'Puesto Cuatro',
        ]);
    }
}
