<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaTrabajo; // Category = Area
use App\Models\Employee;
use Livewire\withPagination;
use Livewire\withFileUploads;

use App\Models\AsignationFunction;

class EmployeeController extends Component
{
    use withPagination;
    use withFileUploads;

    public $ci, $name, $lastname, $genero, $address, $phone, $dateAdmission, $areaid, $selected_id;
    public $pageTitle, $componentName, $search;
    public $details, $sumDetails, $countDetails, $saleId;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->areaid = 'Elegir';
        $this->genero = 'Seleccionar';

        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->saleId = 0;
    }
    
    public function render()
    {
        if(strlen($this->search) > 0)
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_id') // se uno amabas tablas
            ->select('employees.*','c.name as area')
            ->where('employees.name', 'like', '%' . $this->search . '%')    // busquedas employees
            ->orWhere('employees.ci', 'like', '%' . $this->search . '%')    // busquedas
            ->orWhere('c.name', 'like', '%' . $this->search . '%')          // busqueda nombre de categoria
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        else
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_id')
            ->select('employees.*','c.name as area')
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        
        return view('livewire.employee.component', [
            'data' => $employ,    //se envia data
            'areas' => AreaTrabajo::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store(){
        
        $rules = [
            'ci' => 'required|unique:employees',
            'name' => 'required',
            'lastname' => 'required',
            'genero' => 'required|not_in:Seleccionar',
            'address' => 'required',
            'phone' => 'required|unique:employees',
            'dateAdmission' => 'required',
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'ci.required' => 'numero de cedula de identidad requerida',
            'ci.unique' => 'ya existe el numero de documento en el sistema',

            'name.required' => 'el nombre de empleado es requerida',

            'lastname.required' => 'los apellidos del empleado son requerida',
            
            'genero.required' => 'seleccione el genero del empleado',
            'genero.not_in' => 'selecciona genero',

            'address.required' => 'la direccion es requerida',

            'phone.required' => 'el numero de telefono es requerido',
            'phone.unique' => 'el numero de telefono ya existe en sistema',

            'dateAdmission.required' => 'la fecha de admision es requerido',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $employ = Employee::create([
            'ci' =>$this->ci, 
            'name'=>$this->name,
            'lastname'=>$this->lastname,
            'genero'=>$this->genero,
            'address'=>$this->address,
            'phone'=>$this->phone,
            'dateAdmission'=>$this->dateAdmission,
            'area_id' => $this->areaid
        ]);

        $this->resetUI();
        $this->emit('employee-added', 'Empleado Registrado');
    }

    // editar informacion
    public function Edit(Employee $employee){

        $this->ci = $employee->ci;
        $this->name = $employee->name;
        $this->lastname = $employee->lastname;
        $this->genero = $employee->genero;
        $this->address = $employee->address;
        $this->phone = $employee->phone;
        $this->dateAdmission = $employee->dateAdmission;
        $this->areaid = $employee->area_id;
        $this->selected_id = $employee->id;

        $this->emit('modal-show', 'Show modal!');
    }

    // actulizar informacion
    public function Update(){
        $rules = [
            'ci' => "required|unique:employees,ci,{$this->selected_id}",
            'name' => 'required',
            'lastname' => 'required',
            'genero' => 'required|not_in:Seleccionar',
            'address' => 'required',
            'phone' => 'required',
            'dateAdmission' => 'required',
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'ci.required' => 'numero de cedula de identidad requerida',
            'ci.unique' => 'ya existe el numero de documento en el sistema',

            'name.required' => 'el nombre de empleado es requerida',
            'lastname.required' => 'los apellidos del empleado son requerida',

            'genero.required' => 'el genero del empleado es requerido',
            'genero.not_in' => 'selcciona genero',

            'address.required' => 'la direccion es requerida',
            'phone.required' => 'el numero de telefono es requerido',
            'dateAdmission.required' => 'la fecha de admision es requerido',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $employee = Employee::find($this->selected_id);


        $employee->update([
            'ci' => $this->ci,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'genero' => $this->genero,
            'address' => $this->address,
            'phone' => $this->phone,
            'dateAdmission' => $this->dateAdmission,
            'area_id' => $this->areaid
        ]);
        $employee->save();

        $this->resetUI();
        $this->emit('employee-updated', 'Datos de Empleado Actualizado');
    }

    // limpiar formulario
    public function resetUI(){
        $this->ci = '';
        $this->name = '';
        $this->lastname = '';
        $this->genero = 'Seleccionar';
        $this->address = '';
        $this->phone = '';
        $this->dateAdmission = '';
        $this->areaid = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
    }
    //
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar informacion
    public function Destroy($id){
        $employee = Employee::find($id);
        $employee->delete();
        $this->resetUI();
        $this->emit('employee-deleted','Empleado Eliminado');
    }

    public function getDetails($saleId)
    {
        $this->details = AsignationFunction::join('area_trabajos as p','p.id','sale_details.product_id')
        ->select('sale_details.id','sale_details.price','sale_details.quantity','p.name as product')
        ->where('sale_details.sale_id', $saleId)
        ->get();

        // suma de la suma y multiplicacion
        $suma = $this->details->sum(function($item){
            return $item->price *  $item->quantity;
       
        });
        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal','details loaded');
    }
}
