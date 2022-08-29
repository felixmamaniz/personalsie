<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FunctionArea;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\AreaTrabajo;

class FunctionAreaController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $description, $areaid, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Funciones';

        $this->areaid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = FunctionArea::join('area_trabajos as c', 'c.id', 'function_areas.area_trabajo_id') // se uno amabas tablas
            ->select('function_areas.*','c.name as area')
            ->where('function_areas.name', 'like', '%' . $this->search . '%')    // busquedas employees
            ->orWhere('function_areas.ci', 'like', '%' . $this->search . '%')    // busquedas
            ->orWhere('c.name', 'like', '%' . $this->search . '%')          // busqueda nombre de categoria
            ->orderBy('function_areas.name', 'asc')
            ->paginate($this->pagination);
        else
            $data = FunctionArea::join('area_trabajos as c', 'c.id', 'function_areas.area_trabajo_id')
            ->select('function_areas.*','c.name as area')
            ->orderBy('function_areas.name', 'asc')
            ->paginate($this->pagination);


            return view('livewire.functionArea.component', [
                'functionarea' => $data,        // se envia functionarea
                'area_trabajos' => AreaTrabajo::orderBy('name', 'asc')->get()
                ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'name' => 'required|unique:function_areas|min:3',
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $functionarea = FunctionArea::create([
            'name'=>$this->name,
            'description'=>$this->description,
            'area_trabajo_id' => $this->areaid
        ]);

        $this->resetUI();
        $this->emit('area-added', 'Categoria Registrada');
    }

    // editar datos
    public function Edit(FunctionArea $functionarea){
        $this->selected_id = $functionarea->id;
        $this->name = $functionarea->name;
        $this->description = $functionarea->description;
        $this->areaid = $functionarea->area_trabajo_id;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:function_areas,name,{$this->selected_id}",
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];
        $this->validate($rules,$messages);

        $functionarea = FunctionArea::find($this->selected_id);
        $functionarea -> update([
            'name' => $this->name,
            'description' => $this->description,
            'area_trabajo_id' => $this->areaid
        ]);

        $this->resetUI();
        $this->emit('area-updated','Categoria Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->name='';
        $this->description='';
        $this->areaid = 'Elegir';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(FunctionArea $functionarea){
        $functionarea->delete();
        $this->resetUI();
        $this->emit('area-deleted','Producto Eliminada');
    }
}
