<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaTrabajo;
use App\Models\Cargo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class AreaTrabajoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $nameArea, $descriptionArea, $selected_id; // $cargoid, 
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Areas de Trabajo';

        $this->cargoid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            //$data = Area::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
            /*join('cargos as car', 'car.id','area_trabajos.cargo_id')  ,'car.name as cargo'
            ->*/
            $data = AreaTrabajo::select('area_trabajos.id as idarea','area_trabajos.nameArea as name','area_trabajos.descriptionArea as description',
                DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('area_trabajos.nameArea', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idarea);
            }
        }
        else
        {
            // $data = Area::orderBy('id','desc')->paginate($this->pagination);
            // join('cargos as car', 'car.id','area_trabajos.cargo_id')-> ,'car.name as cargo'
            $data = AreaTrabajo::select('area_trabajos.id as idarea','area_trabajos.nameArea as name','area_trabajos.descriptionArea as description',
                DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idarea);
            }
        }

        return view('livewire.areatrabajo.component', [
            'areas' => $data,   // se envia areas
            //'cargos' => Cargo::orderBy('name', 'asc')->get(),
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idarea)
    {
        $consulta1 = AreaTrabajo::join('employees as e', 'e.area_trabajo_id', 'area_trabajos.id')
        ->select('area_trabajos.*')
        ->where('area_trabajos.id', $idarea)
        ->get();
        // $consulta2 = AreaTrabajo::join('function_areas as fa', 'fa.area_trabajo_id', 'area_trabajos.id')
        // ->select('area_trabajos.*')
        // ->where('area_trabajos.id', $idarea)
        // ->get();

        if($consulta1->count() > 0 /*|| $consulta2->count() > 0*/)
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
        $record = AreaTrabajo::find($id, ['id', 'nameArea', 'descriptionArea']); // ,'cargo_id'
        //$this->cargoid = $record->cargo_id;
        $this->nameArea = $record->nameArea;
        $this->descriptionArea = $record->descriptionArea;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            //'cargoid' => 'required|not_in:Elegir',
            'nameArea' => 'required|unique:area_trabajos|min:3',
        ];
        $messages =  [
            //'cargoid.required' => 'Elija un Cargo',
            //'cargoid.not_in' => 'Elije un nombre de Cargo diferente de elegir',

            'nameArea.required' => 'Nombre del area es requerida',
            'nameArea.unique' => 'ya existe el nombre del area',
            'nameArea.min' => 'el nombre del area debe tener al menos 3 caracteres',
        ];

        $this->validate($rules, $messages);
       
        $area = AreaTrabajo::create([
            //'cargo_id' => $this->cargoid,
            'nameArea'=>$this->nameArea, 
            'descriptionArea'=>$this->descriptionArea
        ]);

        $this->resetUI();
        $this->emit('area-added', 'Area Registrada');
    }

    // actualizar
    public function Update(){
        $rules = [
            //'cargoid' => 'required|not_in:Elegir',
            'nameArea' => "required|min:3|unique:area_trabajos,nameArea,{$this->selected_id}",
        ];

        $messages = [
            //'cargoid.required' => 'Elija un Cargo',
            //'cargoid.not_in' => 'Elije un nombre de Cargo diferente de elegir',

            'nameArea.required' => 'nombre de la categoria requerida',
            'nameArea.min' => 'el nombre de la categoria debe tener al menos 3 caracteres',
            'nameArea.unique' =>  'el nombre de la categoria ya existe',
        ];
        $this->validate($rules,$messages);

        $area = AreaTrabajo::find($this->selected_id);
        $area -> update([
            //'cargo_id' => $this->cargoid,
            'nameArea' => $this->nameArea,
            'descriptionArea' => $this->descriptionArea,
        ]);

        $this->resetUI();
        $this->emit('area-updated','Area Actualizada');
    }

    public function resetUI(){
        //$this->cargoid = 'Elegir';
        $this->nameArea='';
        $this->descriptionArea='';
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