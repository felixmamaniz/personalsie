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
            //1
            'name' => 'Administrador',
            'description' => 'Uno',
            //'area_trabajo_id' => 1,
        ]);
        FunctionArea::create([
            //2
            'name' => 'Tecnico',
            'description' => 'Dos',
            //'area_trabajo_id' => 2,
        ]);
        FunctionArea::create([
            //3
            'name' => 'Sin Funcion',
            'description' => 'Tres',
            //'area_trabajo_id' => 3,
        ]);
    }
}
