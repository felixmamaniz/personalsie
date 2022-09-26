<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Anticipo;
use App\Models\Employee;
use App\Models\Contrato;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class AnticipoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $nuevoSalario, $anticipo, $fechaSolicitud, $motivo, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public $sueldo;

    public function mount(){
        $this -> pageTitle = 'Lista';
        $this -> componentName = 'Adelantos de Sueldo';

        $this->empleadoid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $sueldo = '1000';
        if(strlen($this->search) > 0)
        {
            $data = Anticipo::join('employees as at', 'at.id', 'anticipos.empleado_id') // se uno amabas tablas
            ->select('anticipos.*','at.name as empleado', 'anticipos.id as idAnticipo',
                DB::raw('0 as verificar'))
            ->where('at.name', 'like', '%' . $this->search . '%')   
            //->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('anticipos.fechaSolicitud', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAnticipo);
            }
        }
        else
            $data = Anticipo::join('employees as at', 'at.id', 'anticipos.empleado_id')
            ->select('anticipos.*','at.name as empleado', 'anticipos.id as idAnticipo',
                DB::raw('0 as verificar'))
            ->orderBy('anticipos.fechaSolicitud', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAnticipo);
            }

        return view('livewire.anticipos.component', [
            'anticipos' => $data,        // se envia anticipos
            'empleados' => Employee::orderBy('name', 'asc')->get(),
            'sueldoActual' => $sueldo
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idAnticipo)
    {
        $consulta = Anticipo::where('anticipos.id', $idAnticipo);
        
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    public function ServicioDetalle($idAnticipo)
    {
        //$this->ServicioDetalle($idEmpleado);
        $detalle = Anticipo::join('employees as at', 'at.id', 'anticipos.empleado_id')
        ->select('employees.id as idEmpleado',
            'employees.name',
            'ct.salario',
        )
        ->where('employees.id', $idAnticipo)    // selecciona al empleado
        ->get()
        ->first();

        //dd($detalle->name);
        $this->idEmpleado = $detalle->idEmpleado;
        $this->salario = $detalle->salario;
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'nuevoSalario' => 'required',
            'anticipo' => 'required',
            'fechaSolicitud' => 'required',
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'nuevoSalario.required' => 'Este espacio es requerida',
            'anticipo.required' => 'Este espacio es requerida',
            'fechaSolicitud.required' => 'La fecha es requerida',
        ];

        $this->validate($rules, $messages);

        $anticipo = Anticipo::create([
            'empleado_id' => $this->empleadoid,
            'nuevoSalario'=>$this->nuevoSalario,
            'anticipo'=>$this->anticipo,
            'fechaSolicitud'=>$this->fechaSolicitud,
            'motivo'=>$this->motivo,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Adelanto Registrado');
    }

    // editar datos
    public function Edit(Anticipo $anticipo){
        $this->selected_id = $anticipo->id;
        $this->empleadoid = $anticipo->empleado_id;
        $this->nuevoSalario = $anticipo->nuevoSalario;
        $this->anticipo = $anticipo->anticipo;
        $this->fechaSolicitud = $anticipo->fechaSolicitud;
        $this->motivo = $anticipo->motivo;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'nuevoSalario' => 'required',
            'anticipo' => 'required',
            'fechaSolicitud' => 'required',
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'nuevoSalario.required' => 'Este espacio es requerida',
            'anticipo.required' => 'Este espacio es requerida',
            'fechaSolicitud.required' => 'La fecha es requerida',
        ];
        $this->validate($rules,$messages);

        $assistance = Anticipo::find($this->selected_id);
        $assistance -> update([
            'empleado_id' => $this->empleadoid,
            'nuevoSalario'=>$this->nuevoSalario,
            'anticipo'=>$this->anticipo,
            'fechaSolicitud'=>$this->fechaSolicitud,
            'motivo'=>$this->motivo,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->nuevoSalario='';
        $this->anticipo='';
        $this->fechaSolicitud='';
        $this->motivo='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(Anticipo $anticipo){
        $anticipo->delete();
        $this->resetUI();
        $this->emit('asist-deleted','Producto Eliminada');
    }
}
