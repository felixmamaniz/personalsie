<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoContrato;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class TipoContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Tipo de Contrato';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = TipoContrato::select('tipo_contratos.id as idTipoContrato','tipo_contratos.name as name',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('tipo_contratos.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idTipoContrato);
            }
        }
        else
        {
            $data = TipoContrato::select('tipo_contratos.id as idTipoContrato','tipo_contratos.name as name',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idTipoContrato);
            }
        }

        return view('livewire.tipoContrato.component', ['contrato' => $data ]) // se envia contrato
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idTipoContrato)
    {
        $consulta = TipoContrato::join('contratos as c', 'c.tipo_contrato_id', 'tipo_contratos.id')
        ->select('tipo_contratos.*')
        ->where('tipo_contratos.id', $idTipoContrato)
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
        $record = TipoContrato::find($id, ['id', 'name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:tipo_contratos|min:5',
        ];
        $messages =  [
            'name.required' => 'Nombre de tipo de contrato es requerida',
            'name.unique' => 'ya existe el tipo de contrato',
            'name.min' => 'el nombre del tipo de contrato debe tener al menos 5 caracteres',
        ];

        $this->validate($rules, $messages);
       
        $tipocontrato = TipoContrato::create([
            'name'=>$this->name
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Tipo de contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'name' => "required|min:5|unique:tipo_contratos,name,{$this->selected_id}",
        ];

        $messages = [
            'name.required' => 'Nombre de tipo de contrato es requerida',
            'name.unique' => 'ya existe el tipo de contrato',
            'name.min' => 'el nombre del tipo de contrato debe tener al menos 5 caracteres',
        ];
        $this->validate($rules,$messages);

        $tipocontrato = TipoContrato::find($this->selected_id);
        $tipocontrato -> update([
            'name' => $this->name,
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Tipo de contrato Actualizada');
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
        $tipocontrato = TipoContrato::find($id);
        $tipocontrato->delete();
        $this->resetUI();
        $this->emit('tcontrato-deleted','Tipo de contrato Eliminada');
    }
}
