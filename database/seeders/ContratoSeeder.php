<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrato;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contrato::create([
            'fechaFin' => '2022-12-31 00:00:00',
            'descripcion' => 'contrato principal',
            'nota' => 'contrato principal',
            'salario' => '2000',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-11 14:33:34',
            'descripcion' => 'Contrato de Prueba',
            'nota' => 'Uno',
            'salario' => '1000',
            'estado' => 'Activo',
        ]);
        
    }
}
