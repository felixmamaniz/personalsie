<?php

namespace Database\Seeders;

use App\Models\Areaspermissions;
use Illuminate\Database\Seeder;

class AreaspermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // creacion
         Areaspermissions::create([
            'name' => 'Administracion'
     
        ]);
        Areaspermissions::create([
            'name' => 'Inventarios'
     
        ]);
        Areaspermissions::create([
            'name' => 'Servicios Supervisor'
    
        ]);
        Areaspermissions::create([
            'name' => 'Servicios Tecnico'
            
        ]);

        Areaspermissions::create([
            'name' => 'Tigo Money'
            
        ]);

        Areaspermissions::create([
            'name' => 'Ventas Cajero'
            
        ]);

        Areaspermissions::create([
            'name' => 'Ventas Supervisor'
            
        ]);
    }
}
