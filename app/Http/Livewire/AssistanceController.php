<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Assistance;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class AssistanceController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $empleadoid, $fecha, $estado, $selected_id;

    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Lista';
        $this->componentName = 'Asistencia';
        $this->estado = 'Elegir';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Assistance::join('employees as e', 'e.id', 'assistances.empleado_id')
            ->select('assistances.*', 'assistances.id as idAsist', DB::raw('0 as verificar'))
            ->orderBy('assistances.id','desc')
            ->where('assistances.estado', 'like', '%' . $this->search . '%')  
            ->orWhere('e.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAsist);
            }
        }
        else
        {
            $data = Assistance::join('employees as e', 'e.id', 'assistances.empleado_id')
            ->select('assistances.*', 'assistances.id as idAsist', DB::raw('0 as verificar'))
            ->orderBy('assistances.id','desc')
            ->paginate($this->pagination);
    
            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idAsist);
            }
        }

        return view('livewire.assistances.component',[
            'asistencias' => $data,  // se envia asistencias
            'empleados' => Employee::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idAsist)
    {
        $consulta = Assistance::where('assistances.id', $idAsist);

        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // editar 
    public function Edit($id){
        $record = Assistance::find($id, ['id', 'empleado_id', 'fecha', 'estado']);
        $this->empleadoid = $record->empleado_id;
        $this->fecha = $record->fecha;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    // registrar nuevos datos
    public function Store(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'fecha' => 'required',
            'estado' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'empleadoid.required' => 'Seleccione Nombre de Empleado',
            'empleadoid.not_in' => 'elije un nombre de Empleado diferente de elegir',
            'fecha.required' => 'Seleccione una fecha',
            'estado.not_in' => 'Selcciona el status',
            'estado.required' => 'Seleccione un estado de asistencia',
        ];

        $this->validate($rules, $messages);
       
        $assistance = Assistance::create([
            'empleado_id' => $this->empleadoid,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Datos Registrados');
    }

    // actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => "required|not_in:Elegir,empleadoid,{$this->selected_id}",
            'fecha' => 'required',
            'estado' => 'required|not_in:Elegir'
        ];

        $messages = [
            'empleadoid.required' => 'Seleccione Nombre de Empleado',
            'empleadoid.not_in' => 'elije un nombre de Empleado diferente de elegir',
            'fecha.required' => 'Seleccione una fecha',
            'estado.not_in' => 'Selcciona el status',
            'estado.required' => 'Seleccione un estado de asistencia',
        ];
        $this->validate($rules,$messages);

        $assistance = Assistance::find($this->selected_id);
        $assistance -> update([
            'empleado_id' => $this->empleadoid,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Datos Actualizados');
    }

    public function resetUI()
    {
        $this->empleadoid='Elegir';
        $this->fecha='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
        $this->resetPage(); // regresa la pagina
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar Datos
    public function Destroy($id)
    {
        $assistance = Assistance::find($id);
        $assistance->delete();
        $this->resetUI();
        $this->emit('asist-deleted','Datos Eliminados');
    }
}
