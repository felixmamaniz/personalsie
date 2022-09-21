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
    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $fecha, $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Asistencias';

        $this->empleadoid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Assistance::join('employees as at', 'at.id', 'assistances.empleado_id') // se uno amabas tablas
            ->select('assistances.*','at.name as empleado', 'assistances.id as idAsistencia', DB::raw('0 as verificar'))
            ->where('assistances.estado', 'like', '%' . $this->search . '%')   
            ->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('assistances.fecha', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAsistencia);
            }
        }
        else
            $data = Assistance::join('employees as at', 'at.id', 'assistances.empleado_id')
            ->select('assistances.*','at.name as empleado', 'assistances.id as idAsistencia', DB::raw('0 as verificar'))
            ->orderBy('assistances.fecha', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAsistencia);
            }

        return view('livewire.assistances.component', [
            'asistencias' => $data,        // se envia asistencias
            'empleados' => Employee::orderBy('name', 'asc')->get()
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idAsistencia)
    {
        $consulta = Assistance::where('assistances.id', $idAsistencia);
        
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'fecha' => 'required',
            'empleadoid' => 'required|not_in:Elegir',
            'estado' => 'required',
        ];
        $messages =  [
            'fecha.required' => 'La fecha es requerida',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'estado.required' => 'El estado de la sistencia es requerida',
        ];

        $this->validate($rules, $messages);

        $assistance = Assistance::create([
            'fecha'=>$this->fecha,
            'estado'=>$this->estado,
            'empleado_id' => $this->empleadoid
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Categoria Registrada');
    }

    // editar datos
    public function Edit(Assistance $assistance){
        $this->selected_id = $assistance->id;
        $this->fecha = $assistance->fecha;
        $this->estado = $assistance->estado;
        $this->empleadoid = $assistance->empleado_id;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'fecha' => "required,fecha,{$this->selected_id}",
            'empleadoid' => 'required|not_in:Elegir',
            'estado' => 'required',
        ];
        $messages =  [
            'fecha.required' => 'La fecha es requerida',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'estado.required' => 'El estado de la sistencia es requerida',
        ];
        $this->validate($rules,$messages);

        $assistance = Assistance::find($this->selected_id);
        $assistance -> update([
            'fecha'=>$this->fecha,
            'estado'=>$this->estado,
            'empleado_id' => $this->empleadoid
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->fecha='';
        $this->estado='';
        $this->empleadoid = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(Assistance $assistance){
        $assistance->delete();
        $this->resetUI();
        $this->emit('asist-deleted','Producto Eliminada');
    }
}
