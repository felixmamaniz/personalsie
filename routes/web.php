<?php

use App\Http\Livewire\AsignarController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\CompaniesController;
use App\Http\Livewire\SucursalController;
use App\Http\Livewire\EmployeeController;
use App\Http\Livewire\AreaTrabajoController;
use App\Http\Livewire\FunctionAreaController;

use App\Http\Livewire\InicioController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', InicioController::class)->name('home');
    Route::get('/home', InicioController::class);
    Route::group(['middleware' => ['role:ADMIN']], function () {
    });
    /* ADMINISTRACION */
    Route::get('roles', RolesController::class)->name('roles')->middleware('permission:Roles_Index');
    Route::get('permisos', PermisosController::class)->name('permisos')->middleware('permission:Permission_Index');
    Route::get('asignar', AsignarController::class)->name('asignar')->middleware('permission:Asignar_Index');
    Route::get('users', UsersController::class)->name('usuarios')->middleware('permission:Usuarios_Index');
    Route::get('companies', CompaniesController::class)->name('empresa')->middleware('permission:Empresa_Index');
    Route::get('sucursales', SucursalController::class)->name('sucursal')->middleware('permission:Sucursal_Index');
    Route::get('employees', EmployeeController::class);
    Route::get('areas_de_trabajos', AreaTrabajoController::class);
    Route::get('function_areas', FunctionAreaController::class);

});




