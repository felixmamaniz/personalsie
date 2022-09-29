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
            'nameArea' => 'Area Administrativa',
            'descriptionArea' => 'Admin',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'Area Tecnica',
            'descriptionArea' => 'Tec',
        ]);
        AreaTrabajo::create([
            'nameArea' => 'No Definido',
            'descriptionArea' => 'null',
        ]);
    }
}
