<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FunctionArea;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FunctionAreaController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $description, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 2;

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
            $data = FunctionArea::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = FunctionArea::orderBy('id','desc')->paginate($this->pagination);


        return view('livewire.functionArea.component', ['functionarea' => $data]) // se envia functionarea
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // crear y guardar
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

        $functionarea = FunctionArea::create([
            'name'=>$this->name,
            'description'=>$this->description,
        ]);

        $this->resetUI();
        $this->emit('area-added', 'Categoria Registrada');
    }

    // editar datos
    public function Edit(FunctionArea $functionarea){
        $this->selected_id = $functionarea->id;
        $this->name = $functionarea->name;
        $this->description = $functionarea->description;

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

        $functionarea = FunctionArea::find($this->selected_id);
        $functionarea -> update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetUI();
        $this->emit('area-updated','Categoria Actualizar');
    }

    // vaciar formulario
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
    public function Destroy(FunctionArea $functionarea){
        $functionarea->delete();
        $this->resetUI();
        $this->emit('area-deleted','Producto Eliminada');
    }
}
