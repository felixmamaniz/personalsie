<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaTrabajo;

class AreaTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaTrabajo::create([
            'nameArea' => 'No definido',
            'descriptionArea' => 'null',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'Area Uno',
            'descriptionArea' => 'Uno',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'Area Dos',
            'descriptionArea' => 'Dos',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'Area Tres',
            'descriptionArea' => 'Tres',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'Area Cuatro',
            'descriptionArea' => 'Cuatro',
        ]);
    }
}
