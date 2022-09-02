<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FunctionArea;

class FunctionAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FunctionArea::create([
            'name' => 'Funcion Uno',
            'description' => 'Uno',
            'area_trabajo_id' => 1,
        ]);
        FunctionArea::create([
            'name' => 'Funcion Dos',
            'description' => 'Dos',
            'area_trabajo_id' => 2,
        ]);
        FunctionArea::create([
            'name' => 'Funcion Tres',
            'description' => 'Tres',
            'area_trabajo_id' => 3,
        ]);
        FunctionArea::create([
            'name' => 'Funcion Cuatro',
            'description' => 'Cuatro',
            'area_trabajo_id' => 1,
        ]);
    }
}
