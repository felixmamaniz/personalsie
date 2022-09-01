<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PuestoTrabajo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class PuestoTrabajoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Puestos de Trabajo';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = PuestoTrabajo::select('puesto_trabajos.id as idpuesto','puesto_trabajos.name as name',
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
            $data = PuestoTrabajo::select('puesto_trabajos.id as idpuesto','puesto_trabajos.name as name',
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

    // editar 
    public function Edit($id){
        $record = PuestoTrabajo::find($id, ['id', 'name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:puesto_trabajos|min:5',
        ];
        $messages =  [
            'name.required' => 'Nombre de puesto de trabajo es requerida',
            'name.unique' => 'ya existe el nombre del puesto de trabajo',
            'name.min' => 'el nombre de puesto de trabajo debe tener al menos 5 caracteres',
        ];

        $this->validate($rules, $messages);
       
        $puesto = PuestoTrabajo::create([
            'name'=>$this->name
        ]);

        $this->resetUI();
        $this->emit('puesto-added', 'Puesto de Trabajo Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'name' => "required|min:5|unique:puesto_trabajos,name,{$this->selected_id}",
        ];

        $messages = [
            'name.required' => 'Nombre de puesto de trabajo es requerida',
            'name.unique' => 'ya existe el nombre del puesto de trabajo',
            'name.min' => 'el nombre de puesto de trabajo debe tener al menos 5 caracteres',
        ];
        $this->validate($rules,$messages);

        $puesto = PuestoTrabajo::find($this->selected_id);
        $puesto -> update([
            'name' => $this->name,
        ]);

        $this->resetUI();
        $this->emit('puesto-updated','Puesto de Trabajo Actualizada');
    }

    public function resetUI(){
        $this->name='';
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
