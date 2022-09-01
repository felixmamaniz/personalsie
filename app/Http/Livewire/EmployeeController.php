<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaTrabajo;
use App\Models\PuestoTrabajo;
use App\Models\Employee;
use Livewire\withPagination;
use Livewire\withFileUploads;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Component
{
    use withPagination;
    use withFileUploads;

    public $ci, $name, $lastname, $genero, $dateNac, $address, $phone, $dateAdmission, $areaid, $puestoid, $image, $selected_id;
    public $pageTitle, $componentName, $search, $employeeId;
    private $pagination = 5;

    public $TiempoTranscurrido;

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
    }

    public function render()
    {
        Carbon::setLocale('es');
        $TiempoTranscurrido = setlocale(LC_TIME, 'es_ES.utf8');

        $date = Carbon::now();
        $TiempoC = Carbon::parse($date)->format('Y-m-d');

        $fechaInicio = '$dateAdmission';
        $fechaActual = $TiempoC;

        //pruebadbhvdg

        $segundos = strtotime($fechaActual) - strtotime($fechaInicio);  // segundos
        $segRedondeados = floor($segundos);

        $minutos = $segRedondeados / 60;    // minutos
        $minRedondeados = floor($minutos);

        $horas = $minRedondeados / 60;  // horas
        $horasRedondeados = floor($horas);

        $dias = $horasRedondeados / 24;     // dias
        $diasRedondeados = floor($dias);    // para redondeo de un dia mas ceil()

        $meses = $diasRedondeados / 28;     // meses
        $mesesRedondeados = floor($meses);

        $años = $mesesRedondeados - 12;     // años
        $añosRedondeados = floor($años);

        //dd( $TiempoTranscurrido);
        if($añosRedondeados > 0){
            $TiempoTranscurrido = $añosRedondeados . " Años ". $mesesRedondeados . " Meses y ". $diasRedondeados . " Dias";
        }else{
            if($añosRedondeados < 1){
                $TiempoTranscurrido = $mesesRedondeados . " Meses y ". $diasRedondeados . " Dias";
            }else{
                $TiempoTranscurrido = $diasRedondeados . " Dias";
            }
        }

        if(strlen($this->search) > 0)
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id') // se uno amabas tablas
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->select('employees.*','c.name as area')
            ->where('employees.name', 'like', '%' . $this->search . '%')    // busquedas employees
            ->orWhere('employees.ci', 'like', '%' . $this->search . '%')    // busquedas
            ->orWhere('c.name', 'like', '%' . $this->search . '%')          // busqueda nombre de categoria
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        else
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id')
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->select('employees.*','c.name as area')
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        
        return view('livewire.employee.component', [
            'data' => $employ,    //se envia data
            'areas' => AreaTrabajo::orderBy('name', 'asc')->get(),
            'puestos' => PuestoTrabajo::orderBy('name', 'asc')->get(),
            'tiempos' => $TiempoTranscurrido
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // Registro de empleado nuevo
    public function Store(){
        
        $rules = [
            'ci' => 'required|unique:employees',
            'name' => 'required',
            'lastname' => 'required',
            'genero' => 'required|not_in:Seleccionar',
            'dateNac' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:employees',
            'dateAdmission' => 'required',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir'
        ];
        $messages =  [
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

            'dateAdmission.required' => 'la fecha de admision es requerido',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',

            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $employ = Employee::create([
            'ci' =>$this->ci, 
            'name'=>$this->name,
            'lastname'=>$this->lastname,
            'genero'=>$this->genero,
            'dateNac'=>$this->dateNac,
            'address'=>$this->address,
            'phone'=>$this->phone,
            'dateAdmission'=>$this->dateAdmission,
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
    public function Edit(Employee $employee){

        $this->ci = $employee->ci;
        $this->name = $employee->name;
        $this->lastname = $employee->lastname;
        $this->genero = $employee->genero;
        $this->dateNac = $employee->dateNac;
        $this->address = $employee->address;
        $this->phone = $employee->phone;
        $this->dateAdmission = $employee->dateAdmission;
        $this->areaid = $employee->area_trabajo_id;
        $this->puestoid = $employee->puesto_trabajo_id;
        $this->selected_id = $employee->id;
        $this->image = $employee->null;

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
            'dateAdmission' => 'required',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir'
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
            'dateAdmission.required' => 'la fecha de admision es requerido',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',

            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir'
        ];

        $this->validate($rules, $messages);

        $employee = Employee::find($this->selected_id);
        $employee->update([
            'ci' => $this->ci,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'genero' => $this->genero,
            'dateNac' => $this->dateNac,
            'address' => $this->address,
            'phone' => $this->phone,
            'dateAdmission' => $this->dateAdmission,
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
                if(file_exists('storage/employees') . $imageName){
                    unlink('storage/employees' . $imageName);
                }
            }
        }

        //$employee->save();

        $this->resetUI();
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
        $this->dateAdmission = '';
        $this->areaid = 'Elegir';
        $this->puestoid = 'Elegir';
        $this->image=null;
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
        $imageName = $employee->image; //imagen temporal
        $employee->delete();

        if($imageName !=null){
            unlink('storage/employees/' . $imageName);
        }

        $this->resetUI();
        $this->emit('employee-deleted','Empleado Eliminado');
    }

    // ver detalle de datos de empleados
    public function viewDetails(Employee $employee)
    {
        $this->details = Employee::join('area_trabajos as at', 'at.id','employees.area_trabajo_id')
        ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
        ->select('employees.*','at.name as area')
        //->select('e.id','e.ci','e.name','e.lastname','e.genero','e.dateNac','e.address','e.phone','e.dateAdmission','area_trabajo_id','puesto_trabajo_id','image')
        ->get();

        $this->emit('show-modal2', 'open modal');
    }
}
