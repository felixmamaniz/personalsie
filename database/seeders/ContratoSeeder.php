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
            //1
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Sin Contrato',
            'nota' => 'null',
            'funcion_area_id' => '3',
            'salario' => '0',
            'estado' => 'Activo',
        ]);

        // Contrato area Admin
        Contrato::create([
            //2
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Edwin',
            'nota' => 'null',
            'funcion_area_id' => '1',
            'salario' => '4000',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //3
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Yazmin',
            'nota' => 'null',
            'funcion_area_id' => '1',
            'salario' => '2500',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //4
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Armando',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2500',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //5
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Angel',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2300',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //6
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Rosa',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'funcion_area_id' => '1',
            'salario' => '1600',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //7
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Jhonn',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1500',
            'estado' => 'Activo',
        ]);

        //Contrato Personal tecnico
        Contrato::create([
            //8
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Ernesto',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2700',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //9
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Fabio',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2500',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //10
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Roger',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2500',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //11
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Gery',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '900',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //12
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Gustavo',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2250',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //13
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Nadir',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '2300',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //14
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Mauricio',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1300',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //15
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Joshua',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1800',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //16
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Branlin',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1000',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //17
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Rocio',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1000',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //18
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Enzo',
            'nota' => 'null',
            'funcion_area_id' => '2',
            'salario' => '1300',
            'estado' => 'Activo',
        ]);

        Contrato::create([
            //19
            'fechaInicio' => '2020-09-28 00:00:00',
            'fechaFin' => '2022-09-11 14:33:34',
            'descripcion' => 'Contrato de Prueba',
            'nota' => 'Uno',
            'funcion_area_id' => '3',
            'salario' => '1000',
            'estado' => 'Finalizado',
        ]);
    }
}
