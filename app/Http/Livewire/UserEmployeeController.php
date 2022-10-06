<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserEmployee;
use App\Models\Employee;
use App\Models\User;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class UserEmployeeController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $userid, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Usuario Empleado';
        
        $this -> empleadoid = 'Elegir';
        $this -> userid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = UserEmployee::join('users as u', 'u.id', 'user_employees.user_id')
            ->join('employees as e', 'e.id', 'user_employees.employee_id')
            ->select('user_employees.*','u.email as email', 'e.name as name', 'user_employees.id as idUserEmploy', DB::raw('0 as verificar'))
            ->where('e.name', 'like', '%' . $this->search . '%')   
            ->orWhere('u.email', 'like', '%' . $this->search . '%')         
            ->orderBy('e.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idUserEmploy);
            }
        }
        else
        {
            $data = UserEmployee::join('users as u', 'u.id', 'user_employees.user_id')
            ->join('employees as e', 'e.id', 'user_employees.employee_id')
            ->select('user_employees.*','u.email as email', 'e.name as name', 'user_employees.id as idUserEmploy', DB::raw('0 as verificar'))
            ->orderBy('e.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idUserEmploy);
            }
        }

        return view('livewire.userEmployee.component', [
        'datos' => $data,    //se envia datos
        'usuarios' => User::orderBy('name', 'asc')->get(),
        'empleados' => Employee::orderBy('name', 'asc')->get(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar empleado
    public function verificar($idUserEmploy)
    {
        return "si";
    }

    // Registrar nuevO UsuarioEmpleado
    public function Store()
    {
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'userid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            //'empleadoid.required' => 'Empleado requerido seleccione uno',
            'empleadoid.not_in' => 'elije un nombre de Empleado diferente de elegir',

            //'userid.required' => 'Usuario requerido',
            'userid.not_in' => 'elije un nombre de usuario diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $userEmployee = UserEmployee::create([
            'user_id' => $this->userid,
            'employee_id' => $this->empleadoid
        ]);

        $this->resetUI();
        $this->emit('usuem-added', 'Datos Registrados');
    }

    // Muestra datos en panel
    public function Edit(UserEmployee $userEmployee)
    {
        $this->selected_id = $userEmployee->id;
        $this->userid = $userEmployee->user_id;
        $this->empleadoid = $userEmployee->employee_id;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos de userEmployee
    public function Update()
    {
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'userid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            //'empleadoid.required' => 'Empleado requerido seleccione uno',
            'empleadoid.not_in' => 'elije un nombre de Empleado diferente de elegir',

            //'userid.required' => 'Usuario requerido',
            'userid.not_in' => 'elije un nombre de usuario diferente de elegir',
        ];
        $this->validate($rules,$messages);

        $userEmployee = UserEmployee::find($this->selected_id);
        $userEmployee -> update([
            'user_id' => $this->userid,
            'employee_id' => $this->empleadoid
        ]);

        $this->resetUI();
        $this->emit('usuem-updated','datos Actualizados');
    }

    // vaciar formulario
    public function resetUI()
    {
        $this->userid = 'Elegir';
        $this->empleadoid = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(UserEmployee $userEmployee){
        $userEmployee->delete();
        $this->resetUI();
        $this->emit('usuem-deleted','Producto Eliminada');
    }
}
