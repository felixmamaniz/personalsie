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
            'name' => 'Area Uno',
            'description' => 'Uno',
        ]);
        AreaTrabajo::create([
            'name' => 'Area Dos',
            'description' => 'Dos',
        ]);
        AreaTrabajo::create([
            'name' => 'Area Tres',
            'description' => 'Tres',
        ]);
        AreaTrabajo::create([
            'name' => 'Area Cuatro',
            'description' => 'Cuatro',
        ]);
    }
}
