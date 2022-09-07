<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $fechaFin, $descripcion, $nota, $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Contrato';
        $this->estado = 'Elegir';
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

        return view('livewire.contrato.component', ['contratos' => $data]) // se envia contratos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // editar 
    public function Edit($id){
        $record = Contrato::find($id, ['id', 'fechaFin', 'descripcion', 'nota','estado']);
        $this->fechaFin = $record->fechaFin;
        $this->descripcion = $record->descripcion;
        $this->nota = $record->nota;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            //'fechaFin' => 'required',
            'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            //'fechaFin.required' => 'la fecha Final de contrato es requerido',
            'estado.required' => 'seleccione estado de contrato',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            //'fechaFin' => 'required',
            'estado' => 'required|not_in:Elegir',
        ];

        $messages = [
            //'fechaFin.required' => 'la fecha Final de contrato es requerido',
            'estado.required' => 'seleccione estado de contrato',
        ];
        $this->validate($rules,$messages);

        $contrato = Contrato::find($this->selected_id);
        $contrato -> update([
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Contrato Actualizada');
    }

    public function resetUI(){
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
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
        $contrato = Contrato::find($id);
        $contrato->delete();
        $this->resetUI();
        $this->emit('tcontrato-deleted','Contrato Eliminada');
    }
}
