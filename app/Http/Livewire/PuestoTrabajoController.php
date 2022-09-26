<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PuestoTrabajo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Employee;

use Illuminate\Support\Facades\DB;

class PuestoTrabajoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $nrovacantes, $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Puestos de Trabajo';

        $this->estado = 'Elegir';
        $this->idEmpleado = 0;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = PuestoTrabajo::select('puesto_trabajos.id as idpuesto',
            'puesto_trabajos.name as name',
            'puesto_trabajos.nrovacantes as nrovacantes',
            'puesto_trabajos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('puesto_trabajos.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idpuesto);
            }
        }
        else
        {
            $data = PuestoTrabajo::select('puesto_trabajos.id as idpuesto',
            'puesto_trabajos.name as name',
            'puesto_trabajos.nrovacantes as nrovacantes',
            'puesto_trabajos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idpuesto);
            }
        }

        return view('livewire.puestoTrabajo.component', ['puestos' => $data ]) // se envia puestos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idpuesto)
    {
        $consulta = PuestoTrabajo::join('employees as e', 'e.puesto_trabajo_id', 'puesto_trabajos.id')
        ->select('puesto_trabajos.*')
        ->where('puesto_trabajos.id', $idpuesto)
        ->get();
       
        if($consulta->count() > 0)
        {
            return "no";
        }
        else
        {
            return "si";
        }
    }

    // modal de Detalle de empleados
    public function DetallePuesto($idpuesto)
    {
        $this->ServicioDetalle($idpuesto);
        $this->emit('show-modal-detalle', 'open modal');
    }

    // detalle de empleados
    public function ServicioDetalle($idpuesto)
    {
        $detalle = PuestoTrabajo::select('puesto_trabajos.id as idpuesto',
            'puesto_trabajos.id as idpuesto',
            'puesto_trabajos.name',
            'puesto_trabajos.estado',
        )
        ->where('puesto_trabajos.id', $idpuesto)    // selecciona al empleado
        ->get()
        ->first();

        //dd($detalle->name);
        $this->idpuesto = $detalle->idpuesto;
        $this->name = $detalle->name;
        $this->estado = $detalle->estado;
    }

    // editar 
    public function Edit($id){
        $record = PuestoTrabajo::find($id, ['id', 'name', 'nrovacantes', 'estado']);
        $this->name = $record->name;
        $this->nrovacantes = $record->nrovacantes;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:puesto_trabajos|min:5',
            'nrovacantes.required' => 'Nombre del area es requerida',
            'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            'name.required' => 'Nombre de puesto de trabajo es requerida',
            'name.unique' => 'ya existe el nombre del puesto de trabajo',
            'name.min' => 'el nombre de puesto de trabajo debe tener al menos 5 caracteres',

            'nrovacantes.required' => 'Ingrese nro de vacantes que dispone el puesto',

            'estado.required' => 'seleccione estado de contrato',
            'estado.not_in' => 'selecciona estado de contrato',
        ];

        $this->validate($rules, $messages);
       
        $puesto = PuestoTrabajo::create([
            'name'=>$this->name,
            'nrovacantes'=>$this->nrovacantes,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('puesto-added', 'Puesto de Trabajo Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'name' => "required|min:5|unique:puesto_trabajos,name,{$this->selected_id}",
            'nrovacantes.required' => 'Nombre del area es requerida',
            'estado' => 'required|not_in:Elegir',
        ];

        $messages = [
            'name.required' => 'Nombre de puesto de trabajo es requerida',
            'name.unique' => 'ya existe el nombre del puesto de trabajo',
            'name.min' => 'el nombre de puesto de trabajo debe tener al menos 5 caracteres',

            'nrovacantes.required' => 'Ingrese nro de vacantes que dispone el puesto',

            'estado.required' => 'seleccione estado de contrato',
            'estado.not_in' => 'selecciona estado de contrato',
        ];
        $this->validate($rules,$messages);

        $puesto = PuestoTrabajo::find($this->selected_id);
        $puesto -> update([
            'name' => $this->name,
            'nrovacantes'=>$this->nrovacantes,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('puesto-updated','Puesto de Trabajo Actualizada');
    }

    public function resetUI(){
        $this->name='';
        $this->nrovacantes='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy($id)
    {
        $area = PuestoTrabajo::find($id);
        $area->delete();
        $this->resetUI();
        $this->emit('puesto-deleted','Puesto de Trabajo Eliminada');
    }
}
