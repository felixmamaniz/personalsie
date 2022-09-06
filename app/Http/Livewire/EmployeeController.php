<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use App\Models\AreaTrabajo;
use App\Models\PuestoTrabajo;
use App\Models\Employee;
use Livewire\withPagination;
use Livewire\withFileUploads;
use App\Models\Contrato;



use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Component
{
    use withPagination;
    use withFileUploads;

    // Datos de Empleados
    public $ci, $name, $lastname, $genero, $dateNac, $address, $phone, $estadoCivil, $areaid, $puestoid, $image, $selected_id;
    public $pageTitle, $componentName, $search, $employeeId;
    private $pagination = 5;

    public $TiempoTranscurrido;

    // Datos de Contrato
    public $fechaInicio, $fechaFin, $descripcion, $nota, $select_contrato_id;
    
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->areaid = 'Elegir';
        $this->puestoid = 'Elegir';
        $this->genero = 'Seleccionar';
        $this->estadoCivil = 'Seleccionar';
    }

    public function render()
    {
        if(strlen($this->search) > 0){
            //$data = Contrato::where('descripcion','like','%' . $this->search . '%')->paginate($this->pagination);

            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id') // se uno amabas tablas
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->select('employees.*','c.name as area')
            ->where('employees.name', 'like', '%' . $this->search . '%')    // busquedas employees
            ->orWhere('employees.ci', 'like', '%' . $this->search . '%')    // busquedas
            ->orWhere('c.name', 'like', '%' . $this->search . '%')          // busqueda nombre de categoria
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        }
        else
            //$data = Contrato::orderBy('id','desc')->paginate($this->pagination);

            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id')
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->select('employees.*','c.name as area')
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        
        return view('livewire.employee.component', [
            //'contratos' => $data ,
            'data' => $employ,    //se envia data
            'areas' => AreaTrabajo::orderBy('name', 'asc')->get(),
            'puestos' => PuestoTrabajo::orderBy('name', 'asc')->get(),
            //'tiempos' => $TiempoTranscurrido
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // Registro de empleado nuevo
    public function Store(){
        
        $rules = [
            // datos de empleado
            'ci' => 'required|unique:employees',
            'name' => 'required',
            'lastname' => 'required',
            'genero' => 'required|not_in:Seleccionar',
            'dateNac' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:employees',
            //'dateAdmission' => 'required',
            'estadoCivil' => 'required|not_in:Seleccionar',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir',

            // datos de contrato
            'fechaInicio' => 'required',
            'fechaFin' => 'required',
        ];
        $messages =  [
            // datos de empleado
            'ci.required' => 'numero de cedula de identidad requerida',
            'ci.unique' => 'ya existe el numero de documento en el sistema',

            'name.required' => 'el nombre de empleado es requerida',

            'lastname.required' => 'los apellidos del empleado son requerida',
            
            'genero.required' => 'seleccione el genero del empleado',
            'genero.not_in' => 'selecciona genero',

            'dateNac.required' => 'la fecha de nacimiento es requerido',

            'address.required' => 'la direccion es requerida',

            'phone.required' => 'el numero de telefono es requerido',
            'phone.unique' => 'el numero de telefono ya existe en sistema',

            //'dateAdmission.required' => 'la fecha de admision es requerido',

            'estadoCivil.required' => 'seleccione estado civil del empleado',
            'estadoCivil.not_in' => 'selecciona estado civil',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',

            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir',

            'fechaInicio.required' => 'la fecha de Inicio es requerido',
            'fechaFin.required' => 'la fecha Final de contrato es requerido',
        ];

        $this->validate($rules, $messages);

        $contrato = Contrato::create([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota
        ]);

        $employ = Employee::create([
            'ci' =>$this->ci, 
            'name'=>$this->name,
            'lastname'=>$this->lastname,
            'genero'=>$this->genero,
            'dateNac'=>$this->dateNac,
            'address'=>$this->address,
            'phone'=>$this->phone,
            //'dateAdmission'=>$this->dateAdmission,
            'estadoCivil'=>$this->estadoCivil,
            'area_trabajo_id' => $this->areaid,
            'puesto_trabajo_id' => $this->puestoid
        ]);

        //$customFileName;
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/employees', $customFileName);
            $employ->image = $customFileName;
            $employ->save();
        }

        $this->resetUI();
        $this->emit('employee-added', 'Empleado Registrado');
    }

    // editar informacion
    public function Edit(Employee $employee, Contrato $contrato){

        $this->ci = $employee->ci;
        $this->name = $employee->name;
        $this->lastname = $employee->lastname;
        $this->genero = $employee->genero;
        $this->dateNac = $employee->dateNac;
        $this->address = $employee->address;
        $this->phone = $employee->phone;
        //$this->dateAdmission = $employee->dateAdmission;
        $this->estadoCivil = $employee->estadoCivil;
        $this->areaid = $employee->area_trabajo_id;
        $this->puestoid = $employee->puesto_trabajo_id;
        $this->selected_id = $employee->id;
        $this->image = $employee->null;

        // editar contrato
        /*$this->fechaInicio = $contrato->fechaInicio;
        $this->fechaFin = $contrato->fechaFin;
        $this->descripcion = $contrato->descripcion;
        $this->nota = $contrato->nota;*/

        $this->emit('modal-show', 'Show modal!');
    }

    // actulizar informacion
    public function Update(){
        $rules = [
            'ci' => "required|unique:employees,ci,{$this->selected_id}",
            'name' => 'required',
            'lastname' => 'required',
            'genero' => 'required|not_in:Seleccionar',
            'dateNac' => 'required',
            'address' => 'required',
            'phone' => 'required',
            //'dateAdmission' => 'required',
            'estadoCivil' => 'required|not_in:Seleccionar',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir',

            // datos de contrato
            /*'fechaInicio' => 'required',
            'fechaFin' => 'required',*/
        ];
        $messages =  [
            'ci.required' => 'numero de cedula de identidad requerida',
            'ci.unique' => 'ya existe el numero de documento en el sistema',

            'name.required' => 'el nombre de empleado es requerida',
            'lastname.required' => 'los apellidos del empleado son requerida',

            'genero.required' => 'el genero del empleado es requerido',
            'genero.not_in' => 'selcciona genero',

            'dateNac.required' => 'la fecha de nacimiento es requerido',

            'address.required' => 'la direccion es requerida',
            'phone.required' => 'el numero de telefono es requerido',
            //'dateAdmission.required' => 'la fecha de admision es requerido',
            'estadoCivil.required' => 'seleccione estado civil del empleado',
            'estadoCivil.not_in' => 'selecciona estado civil',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',

            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir',

            // datos de contrato
            /*'fechaInicio.required' => 'la fecha de Inicio es requerido',
            'fechaFin.required' => 'la fecha Final de contrato es requerido',*/
        ];

        $this->validate($rules, $messages);

        /*$contrato = Contrato::find($this->select_contrato_id);
        $contrato -> update([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota
        ]);*/

        $employee = Employee::find($this->selected_id);
        $employee->update([
            'ci' => $this->ci,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'genero' => $this->genero,
            'dateNac' => $this->dateNac,
            'address' => $this->address,
            'phone' => $this->phone,
            //'dateAdmission' => $this->dateAdmission,
            'estadoCivil'=>$this->estadoCivil,
            'area_trabajo_id' => $this->areaid,
            'puesto_trabajo_id' => $this->puestoid
        ]);

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/employees', $customFileName);
            $imageName = $employee->image;

            $employee->image = $customFileName;
            $employee->save();

            if($imageName !=null){
                if(file_exists('storage/employees' . $imageName)){
                    unlink('storage/employees' . $imageName);
                }
            }
        }

        $employee->save();

        $this->resetUI(); // limpia las cajas de texto
        $this->emit('employee-updated', 'Datos de Empleado Actualizado');
    }

    // limpiar formulario
    public function resetUI(){
        $this->ci = '';
        $this->name = '';
        $this->lastname = '';
        $this->genero = 'Seleccionar';
        $this->dateNac = '';
        $this->address = '';
        $this->phone = '';
       // $this->dateAdmission = '';
        $this->estadoCivil = 'Seleccionar';
        $this->areaid = 'Elegir';
        $this->puestoid = 'Elegir';
        $this->image=null;
        $this->search = '';
        $this->selected_id = 0;

        // datos de contrato
        $this->fechaInicio='';
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
    }
    //
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar informacion
    public function Destroy($id){
        $employee = Employee::find($id);
        $imageName = $employee->image; //imagen temporal
        $employee->delete();

        if($imageName !=null){
            unlink('storage/employees/' . $imageName);
        }

        $this->resetUI();
        $this->emit('employee-deleted','Empleado Eliminado');
    }

    // $data = Employees::all(); devuelve toda la informacion de la tabla empleados
    // ver detalle de empleados 
     public function getDetails($id)
     {
         $employee = Employee::find($this->selected_id);
         $this->emit('detail-show','details loaded');
     }
}
