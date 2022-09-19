<?php

namespace Database\Seeders;

use App\Models\CompraDetalle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(CompanySeeder::class);
      $this->call(SucursalSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(SucursalUserSeeder::class);
      $this->call(SucursalSeeder::class);
      $this->call(AreaspermissionsSeeder::class);
      $this->call(PermissionSeeder::class);
      $this->call(RoleSeeder::class);
      $this->call(ModelHasRolesSeeder::class);
      $this->call(RoleHasPermissionSeeder::class);
      $this->call(AreaTrabajoSeeder::class);
      $this->call(PuestoTrabajoSeeder::class);
      $this->call(FunctionAreaSeeder::class);
	    $this->call(ContratoSeeder::class);
      $this->call(EmployeeSeeder::class);
      $this->call(AssistanceSeeder::class);
    }
}
