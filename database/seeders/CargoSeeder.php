<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::create([
            //1
            'name' => 'Gerente',
            'area_id' => 1,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //2
            'name' => 'Contador',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //3
            'name' => 'Encargado de Ventas',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //4
            'name' => 'Cajero Sucursal',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //5
            'name' => 'Encargada de Plataformas',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //6
            'name' => 'Cajero',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);

        Cargo::create([
            //7
            'name' => 'Supervisor',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //8
            'name' => 'Tecnico',
            'area_id' => 2,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //9
            'name' => 'Encargado de Area de Impresoras',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //10
            'name' => 'Tecnico en Electronica',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //11
            'name' => 'Desarrollador de Sistemas',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //12
            'name' => 'Mensajeria',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //13
            'name' => 'Programador',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //14
            'name' => 'Pasante',
            'area_id' => 3,
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
    }
}
