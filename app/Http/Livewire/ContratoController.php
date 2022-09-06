<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $fechaInicio, $fechaFin, $descripcion, $nota, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Contrato';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Contrato::where('descripcion','like','%' . $this->search . '%')->paginate($this->pagination);
        }
        else
        {
            $data = Contrato::orderBy('id','desc')->paginate($this->pagination);
        }

        return view('livewire.contrato.component', ['contratos' => $data ]) // se envia contratos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // editar 
    public function Edit($id){
        $record = Contrato::find($id, ['id', 'fechaInicio', 'fechaFin', 'descripcion', 'nota']);
        $this->fechaInicio = $record->fechaInicio;
        $this->fechaFin = $record->fechaFin;
        $this->descripcion = $record->descripcion;
        $this->nota = $record->nota;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'fechaInicio' => 'required',
            'fechaFin' => 'required',
        ];
        $messages =  [
            'fechaInicio.required' => 'la fecha de Inicio es requerido',
            'fechaFin.required' => 'la fecha Final de contrato es requerido',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'fechaInicio' => 'required',
            'fechaFin' => 'required',
        ];

        $messages = [
            'fechaInicio.required' => 'la fecha de Inicio es requerido',
            'fechaFin.required' => 'la fecha Final de contrato es requerido',
        ];
        $this->validate($rules,$messages);

        $contrato = Contrato::find($this->selected_id);
        $contrato -> update([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Contrato Actualizada');
    }

    public function resetUI(){
        $this->fechaInicio='';
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy($id)
    {
        $contrato = Contrato::find($id);
        $contrato->delete();
        $this->resetUI();
        $this->emit('tcontrato-deleted','Contrato Eliminada');
    }
}
