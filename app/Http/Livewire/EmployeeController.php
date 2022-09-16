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
use Intervetion\Image\Facades\Image;

class EmployeeController extends Component
{
    use withPagination;
    use withFileUploads;

    // Datos de Empleados
    public $idEmpleado, $ci, $name, $lastname, $genero, $dateNac, $address, $phone, $estadoCivil, $areaid, $puestoid, $contratoid, $fechaInicio, $image, $selected_id;
    public $pageTitle, $componentName, $search, $componentNuevoContrato;
    private $pagination = 6;

    public $anioRestante, $mesesRestante, $diasRestante;

    public $yearEmployee, $mouthEmployee, $dayEmployee;

    // Datos de Contrato
    public $fechaFin, $descripcion, $nota, $salario, $estado, $select_contrato_id;
    
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->componentNuevoContrato = 'Nuevo Contrato';
        $this->areaid = 'Elegir';
        $this->puestoid = 'Elegir';
        $this->genero = 'Seleccionar';
        $this->estadoCivil = 'Seleccionar';
        $this->contratoid = 'Elegir';

        $this->estado = 'Elegir';
        
        $this->idEmpleado = 0;
    }

    public function render()
    {
        $tiempoRestante = "prueba";
        $estadoContrato = 'Activo';
        if(strlen($this->search) > 0){
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id') // se uno amabas tablas
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->join('contratos as ct', 'ct.id', 'employees.contrato_id')
            ->select('employees.*','c.name as area', 'pt.name as puesto', 'ct.descripcion as contrato')
            ->where('employees.name', 'like', '%' . $this->search . '%')    // busquedas employees
            ->orWhere('employees.ci', 'like', '%' . $this->search . '%')    // busquedas
            ->orWhere('c.name', 'like', '%' . $this->search . '%')          // busqueda nombre de categoria
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        }
        else
            $employ = Employee::join('area_trabajos as c', 'c.id', 'employees.area_trabajo_id')
            ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
            ->join('contratos as ct', 'ct.id', 'employees.contrato_id')
            ->select('employees.*','c.name as area','pt.name as puesto', 'ct.descripcion as contrato', 
                DB::raw('0 as year'), DB::raw('0 as mouth'), DB::raw('0 as day'))
            ->orderBy('employees.name', 'asc')
            ->paginate($this->pagination);
        

            foreach ($employ as $e)
            {
                $e->year = $this->year($e->id);
                $e->mouth = $this->mouth($e->id);
                $e->day = $this->day($e->id);

                $e->yearR = $this->yearR($e->id);
                $e->mouthR = $this->yearR($e->id);
                $e->dayR = $this->yearR($e->id);
            }

        return view('livewire.employee.component', [
            'data' => $employ,    //se envia data
            'areas' => AreaTrabajo::orderBy('name', 'asc')->get(),
            'puestos' => PuestoTrabajo::orderBy('name', 'asc')->get(),
            'contratos' => Contrato::orderBy('descripcion', 'asc')->get(),
            'estadocontrato' => $estadoContrato,
            'pruebas' => $tiempoRestante
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // TIEMPO TRASCURRIDO
    // años transcurridos
    public function year($idUsuario)
    {
        $TiempoTranscurrido = 0;
        $anioInicio = Carbon::parse(Employee::find($idUsuario)->fechaInicio)->format('Y');

        if($anioInicio != Carbon::parse(Carbon::now())->format('Y'))
        {
            $TiempoTranscurrido = Carbon::parse(Carbon::now())->format('Y') - $anioInicio;
        }
        return $TiempoTranscurrido;
    }

    // meses transcurridos
    public function mouth($idUsuario)
    {
        $TiempoTranscurrido = 0;
        $meses = Carbon::parse(Employee::find($idUsuario)->fechaInicio)->format('m');

        if($meses != Carbon::parse(Carbon::now())->format('m'))
        {
            $TiempoTranscurrido = Carbon::parse(Carbon::now())->format('m') - $meses;
            if($TiempoTranscurrido < 0){
                $TiempoTranscurrido = $TiempoTranscurrido * -1;
            }
        }
        return $TiempoTranscurrido;
    }

    // dias transcurridos
    public function day($idUsuario)
    {
        $TiempoTranscurrido = 0;
        $diasInicio = Carbon::parse(Employee::find($idUsuario)->fechaInicio)->format('d');
        
        if($diasInicio != Carbon::parse(Carbon::now())->format('d'))
        {
            $TiempoTranscurrido = Carbon::parse(Carbon::now())->format('d') - $diasInicio;
            if($TiempoTranscurrido < 0){
                $TiempoTranscurrido = $TiempoTranscurrido * -1;
            }
        }
        return $TiempoTranscurrido;
    }

    //  TIEMPO RESTANTE
    // años restantes
    public function yearR($idUsuario)
    {
        $tiempoRestante = 0;

        $tiempoR = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
        ->select('employees.id as idEmpleado', 'ct.fechaFin as fechafinal')
        ->where('employees.id', $idUsuario)
        ->get()
        ->first();

        $aniosR = Carbon::parse($tiempoR->fechafinal)->format('Y');
 
        if($aniosR != Carbon::parse(Carbon::now())->format('Y'))
        {
            $tiempoRestante = $aniosR - Carbon::parse(Carbon::now())->format('Y');
        }
        return $tiempoRestante;
    }
    
    // meses restantes
    public function mouthR($idUsuario)
    {
        $tiempoRestante = 0;

        $tiempoR = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
        ->select('employees.id as idEmpleado', 'ct.fechaFin as fechafinal')
        ->where('employees.id', $idUsuario)
        ->get()
        ->first();

        $mesesR = Carbon::parse($tiempoR->fechafinal)->format('m');
 
        if($mesesR != Carbon::parse(Carbon::now())->format('m'))
        {
            $tiempoRestante = $mesesR - Carbon::parse(Carbon::now())->format('m');
        }
        return $tiempoRestante;
    }

    // dias restantes
    public function dayR($idUsuario)
    {
        $tiempoRestante = 0;

        $tiempoR = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
        ->select('employees.id as idEmpleado', 'ct.fechaFin as fechafinal')
        ->where('employees.id', $idUsuario)
        ->get()
        ->first();      // permite tomar solo el primer dato

        $diasR = Carbon::parse($tiempoR->fechafinal)->format('d');
 
        if($diasR != Carbon::parse(Carbon::now())->format('d'))
        {
            $tiempoRestante = $diasR - Carbon::parse(Carbon::now())->format('d');
        }
        return $tiempoRestante;
    }

    // Abre el modal de Nuevo empleado
    public function NuevoEmpleado()
    {
        $this->resetUI();
        $this->emit('modal-show', 'show modal!');
    }

    // Abre el modal de Nuevo contrato
    public function NuevoContrato()
    {
        //$this->resetUI();
        $this->emit('modal-hide', 'show modal!');
        $this->emit('show-modal-contrato', 'show modal!');
    }

    // Cierra el modal y abre el modal de Registro de empleados
    public function cancelar()
    {
        $this->resetPage(); // regresa la pagina
        $this->emit('modal-show', 'show modal!');
    }

    // modal de Detalle de empleados
    public function DetalleEmpleado($idEmpleado)
    {
        $this->ServicioDetalle($idEmpleado);
        $this->emit('show-modal-detalleE', 'open modal');
    }

    // detalle de empleados
    public function ServicioDetalle($idEmpleado)
    {
        $detalle = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->join('puesto_trabajos as pt', 'pt.id', 'employees.puesto_trabajo_id')
        ->join('contratos as ct', 'ct.id', 'employees.contrato_id')
        ->select('employees.id as idEmpleado',
            'employees.ci',
            'employees.name',
            'employees.lastname',
            'employees.genero',
            'employees.dateNac',
            'employees.address',
            'employees.phone',
            'employees.estadoCivil',
            'at.name as nombrearea',
            'pt.name as nombrepuesto',
            'employees.contrato_id',
            'employees.fechaInicio',
            'ct.fechaFin as fechafinal',
            'ct.salario',
            'employees.image',
            )
        ->where('employees.id', $idEmpleado)    // selecciona al empleado
        ->get()
        ->first();

        //dd($detalle->name);
        $this->idEmpleado = $detalle->idEmpleado;
        $this->ci = $detalle->ci;
        $this->name = $detalle->name;
        $this->lastname = $detalle->lastname;
        $this->genero = $detalle->genero;
        $this->dateNac = $detalle->dateNac;
        $this->address = $detalle->address;
        $this->phone = $detalle->phone;
        $this->estadoCivil = $detalle->estadoCivil;
        $this->areaid = $detalle->nombrearea;
        $this->puestoid = $detalle->nombrepuesto;
        $this->fechaInicio = $detalle->fechaInicio;
        $this->contratoid = $detalle->fechafinal;
        $this->salario = $detalle->salario;
        $this->image = $detalle->image;


        // tiempo transcurrido
        $this->yearEmployee = $this->year($idEmpleado);
        $this->mouthEmployee = $this->mouth($idEmpleado);
        $this->dayEmployee = $this->day($idEmpleado);

        // tiempo restante
        $this->anioRestante = $this->yearR($idEmpleado);
        $this->mesesRestante = $this->mouthR($idEmpleado);
        $this->diasRestante = $this->dayR($idEmpleado);

       // dd($this->anioRestante);
    }

    // Registro de nuevo Contrato
    public function RegNuevoContrato(){
        $rules = [
            //'fechaFin' => 'required',
            'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            //'fechaFin.required' => 'la fecha Final de contrato es requerido',
            'estado.required' => 'seleccione estado de contrato',
            'estado.not_in' => 'selecciona estado de contrato',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'salario'=>$this->salario,
            'estado'=>$this->estado
        ]);

        //$contrato->save();

        $this->emit('tcontrato-added','Area Registrada');
        $this->resetUI();
        $this->emit('modal-hide-contrato', 'show modal!');
        $this->emit('modal-show', 'show modal!');
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
            'phone' => 'required',
            'estadoCivil' => 'required|not_in:Seleccionar',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir',
            'contratoid' => 'required|not_in:Elegir',
            'fechaInicio' => 'required',
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
            'estadoCivil.required' => 'seleccione estado civil del empleado',
            'estadoCivil.not_in' => 'selecciona estado civil',
            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir',
            'contratoid.not_in' => 'seleccione un contrato',
            'fechaInicio.required' => 'la fecha de Inicio es requerido',
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
            'estadoCivil'=>$this->estadoCivil,
            'area_trabajo_id' => $this->areaid,
            'puesto_trabajo_id' => $this->puestoid,
            'contrato_id' => $this->contratoid,
            'fechaInicio'=>$this->fechaInicio,
        ]);
        
        //$customFileName;
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/employees', $customFileName);
            $employ->image = $customFileName;
            $employ->save();
        }

        /*$customFileName;
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $ruta = $this->image->storeAs('public/employees', $customFileName);

            Image::make($customFileName)
            ->resize(45, null, function($constraint){
                $constraint->aspectRatio();
            })
            ->save($ruta);
        }*/
        
        $this->resetUI();
        $this->emit('employee-added', 'Empleado Registrado');
        $this->emit('modal-hide-contrato', 'show modal!');
        $this->emit('modal-show', 'show modal!');
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
        $this->estadoCivil = $employee->estadoCivil;
        $this->areaid = $employee->area_trabajo_id;
        $this->puestoid = $employee->puesto_trabajo_id;
        $this->contratoid = $employee->contrato_id;
        $this->fechaInicio = $employee->fechaInicio;
        $this->image = $employee->null;
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
            'dateNac' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'estadoCivil' => 'required|not_in:Seleccionar',
            'areaid' => 'required|not_in:Elegir',
            'puestoid' => 'required|not_in:Elegir',
            'contratoid' => 'required|not_in:Elegir',
            'fechaInicio' => 'required',
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

            'estadoCivil.required' => 'seleccione estado civil del empleado',
            'estadoCivil.not_in' => 'selecciona estado civil',

            'areaid.not_in' => 'elije un nombre de area diferente de elegir',

            'puestoid.not_in' => 'elije un nombre del puesto diferente de elegir',
            'contratoid.not_in' => 'elije contrato de elegir',
            'fechaInicio.required' => 'la fecha de Inicio es requerido',

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
            'estadoCivil'=>$this->estadoCivil,
            'area_trabajo_id' => $this->areaid,
            'puesto_trabajo_id' => $this->puestoid,
            'contrato_id' => $this->contratoid,
            'fechaInicio' => $this->fechaInicio,
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
        $this->estadoCivil = 'Seleccionar';
        $this->areaid = 'Elegir';
        $this->puestoid = 'Elegir';
        $this->contratoid = 'Elegir';
        $this->fechaInicio = '';
        $this->image=null;
        $this->search = '';
        $this->selected_id = 0;

        // Datos de contrato
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
        $this->salario='';
        $this->estado = 'Elegir';
        $this->select_contrato_id = 0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
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
}
