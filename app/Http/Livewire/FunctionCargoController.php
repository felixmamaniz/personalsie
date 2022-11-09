<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FunctionCargo;
//use Livewire\WithFileUploads;
use Livewire\WithPagination;

//use App\Models\AreaTrabajo;
use Illuminate\Support\Facades\DB;

class FunctionCargoController extends Component
{
    //use WithFileUploads;
    use WithPagination;

    // Datos de Funciones
    public $name, $selected_id;
    public $pageTitle, $componentName, $search;
    //private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Funciones';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = FunctionCargo::select('function_cargo.*', 'function_cargo.id as idFuncion', DB::raw('0 as verificar'))
            ->where('function_cargo.name', 'like', '%' . $this->search . '%')        
            ->orderBy('function_cargo.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idFuncion);
            }
        }
        else
            $data = FunctionCargo::select('function_cargo.*', 'function_cargo.id as idFuncion', DB::raw('0 as verificar'))
            ->orderBy('function_cargo.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idFuncion);
            }


        return view('livewire.cargo.VistaFunciones', [
            'funciones' => $data,        // se envia functionarea
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idFuncion)
    {
        $consulta = FunctionCargo::where('function_cargo.id', $idFuncion);
        
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // Registrar nueva funcion
    public function Store(){
        $rules = [
            'name' => 'required|unique:function_areas|min:3',
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $functioncargo = FunctionCargo::create([
            'name'=>$this->name,
        ]);
        $this->resetUIFuncion();
        $this->emit('fun-added', 'Funcion Registrada');
    }


    // editar datos
    public function Edit(FunctionCargo $functioncargo){
        $this->selected_Funcion_id = $functioncargo->id;
        $this->name = $functioncargo->name;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:function_areas,name,{$this->selected_id}",
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
        ];
        $this->validate($rules,$messages);

        $functionarea = FunctionCargo::find($this->selected_id);
        $functionarea -> update([
            'name' => $this->name,
        ]);

        $this->resetUI();
        $this->emit('fun-updated','Categoria Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->name='';
        $this->search='';
        $this->selected_id=0;
         $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(FunctionCargo $functionarea){
        $functionarea->delete();
        $this->resetUI();
        $this->emit('fun-deleted','Producto Eliminada');
    }
}
