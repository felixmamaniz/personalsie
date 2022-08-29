<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaTrabajo;
use App\Models\Employee;
use App\Models\FunctionArea;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class AreaTrabajoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $description, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Areas de Trabajo';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0){
            //$data = Area::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
            $data = AreaTrabajo::select('area_trabajos.id as idarea','area_trabajos.name as name','area_trabajos.description as description',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('area_trabajos.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idarea);
            }
        }
        else
           // $data = Area::orderBy('id','desc')->paginate($this->pagination);
           $data = AreaTrabajo::select('area_trabajos.id as idarea','area_trabajos.name as name','area_trabajos.description as description',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idarea);
            }

            //dd($data);

        return view('livewire.areatrabajo.component', ['areas' => $data ]) // se envia areas
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idarea)
    {
        $consulta = Employee::join('area_trabajos as c', 'c.id', 'employees.area_id')
        ->join('function_areas as fa', 'fa.area_id', 'employees.area_id')
        ->select('employees.id as id')
        ->where('c.id', $idarea)
        ->get();

        if($consulta->count() > 0)
        {
            return "no";
        }
        else
        {
            return "si";
        }

        // $consulta = FunctionArea::join('area_trabajos as c', 'c.id', 'function_areas.area_id')
        // ->select('function_areas.id as id')
        // ->where('c.id', $idarea)
        // ->get();

        // if($consulta->count() > 0)
        // {
        //     return "no";
        // }
        // else
        // {
        //     return "si";
        // }
    }

    // editar 
    public function Edit($id){
        $record = AreaTrabajo::find($id, ['id', 'name', 'description']);
        $this->name = $record->name;
        $this->description = $record->description;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:area_trabajos|min:3',
        ];
        $messages =  [
            'name.required' => 'Nombre del area es requerida',
            'name.unique' => 'ya existe el nombre del area',
            'name.min' => 'el nombre del area debe tener al menos 3 caracteres',
        ];

        $this->validate($rules, $messages);
       
        $area = AreaTrabajo::create([
            'name'=>$this->name, 
            'description'=>$this->description
        ]);

        $this->resetUI();
        $this->emit('area-added', 'Area Registrada');
    }

    // actualizar
    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:area_trabajos,name,{$this->selected_id}",
        ];

        $messages = [
            'name.required' => 'nombre de la categoria requerida',
            'name.min' => 'el nombre de la categoria debe tener al menos 3 caracteres',
            'name.unique' =>  'el nombre de la categoria ya existe',
        ];
        $this->validate($rules,$messages);

        $area = AreaTrabajo::find($this->selected_id);
        $area -> update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetUI();
        $this->emit('area-updated','Area Actualizada');
    }

    public function resetUI(){
        $this->name='';
        $this->description='';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy($id)
    {
        $area = AreaTrabajo::find($id);
        $area->delete();
        $this->resetUI();
        $this->emit('area-deleted','Area Eliminada');
    }
}