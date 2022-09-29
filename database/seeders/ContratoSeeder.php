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
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Sin Contrato',
            'nota' => 'null',
            'salario' => '0',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato GE',
            'nota' => 'null',
            'salario' => '900',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato BR',
            'nota' => 'null',
            'salario' => '1000',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato EM',
            'nota' => 'null',
            'salario' => '1300',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato J',
            'nota' => 'null',
            'salario' => '1440',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato G',
            'nota' => 'null',
            'salario' => '1882',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato N',
            'nota' => 'null',
            'salario' => '2300',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato R',
            'nota' => 'null',
            'salario' => '2454',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato F',
            'nota' => 'null',
            'salario' => '2768',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato ER',
            'nota' => 'null',
            'salario' => '2798',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato ED',
            'nota' => 'null',
            'salario' => '3200',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Y',
            'nota' => 'null',
            'salario' => '1620',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato AR',
            'nota' => 'null',
            'salario' => '1349',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            'fechaFin' => '2022-09-11 14:33:34',
            'descripcion' => 'Contrato de Prueba',
            'nota' => 'Uno',
            'salario' => '1000',
            'estado' => 'Finalizado',
        ]);
    }
}
