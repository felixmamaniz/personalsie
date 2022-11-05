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
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Sin Contrato',
            //'nota' => 'null',
            'salario' => '0',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);

        // Contrato area Admin
        Contrato::create([
            //2
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Edwin',
            //'nota' => 'null',
            'salario' => '4000',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //3
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Yazmin',
            //'nota' => 'null',
            'salario' => '2500',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //4
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Armando',
            //'nota' => 'null',
            'salario' => '2500',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //5
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Angel',
            //'nota' => 'null',
            'salario' => '2300',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //6
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Rosa',
            //'nota' => 'null',
            'salario' => '1600',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //7
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Jhonn',
            //'nota' => 'null',
            'salario' => '1500',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);

        //Contrato Personal tecnico
        Contrato::create([
            //8
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Ernesto',
            //'nota' => 'null',
            'salario' => '2700',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //9
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Fabio',
            //'nota' => 'null',
            'salario' => '2500',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //10
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Roger',
            //'nota' => 'null',
            'salario' => '2500',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //11
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Gery',
            //'nota' => 'null',
            'salario' => '900',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //12
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Gustavo',
            //'nota' => 'null',
            'salario' => '2250',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //13
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Nadir',
            //'nota' => 'null',
            'salario' => '2300',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //14
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Mauricio',
            //'nota' => 'null',
            'salario' => '1300',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //15
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Joshua',
            //'nota' => 'null',
            'salario' => '1800',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //16
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Branlin',
            //'nota' => 'null',
            'salario' => '1000',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //17
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Rocio',
            //'nota' => 'null',
            'salario' => '1000',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);
        Contrato::create([
            //18
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-28 00:00:00',
            'descripcion' => 'Contrato Enzo',
            //'nota' => 'null',
            'salario' => '1300',
            'funcion_id' => '3',
            'estado' => 'Activo',
        ]);

        Contrato::create([
            //19
            'Employee_id' => 'No definido',
            'fechaInicio' => '2018-01-01 00:00:00',
            'fechaFin' => '2022-09-11 14:33:34',
            'descripcion' => 'Contrato de Prueba',
            //'nota' => 'Uno',
            'salario' => '1000',
            'funcion_id' => '3',
            'estado' => 'Finalizado',
        ]);
    }
}
