<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assistance;

class AssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assistance::create([
            'empleado_id' => 23,
            'fecha' => '2022-08-10 00:00:00',
            'estado' => 'Presente',
        ]);
        Assistance::create([
            'empleado_id' => 24,
            'fecha' => '2022-08-20 00:00:00',
            'estado' => 'Falta',
        ]);
        Assistance::create([
            'empleado_id' => 37,
            'fecha' => '2022-08-30 00:00:00',
            'estado' => 'Licencia',
        ]);
    }
}
