<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use App\Models\FunctionArea;

use Carbon\Carbon;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $fechaInicio, $fechaFin, $descripcion, $nota, $funcionid, $salario, $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Contrato';
        
        $this->estado = 'Elegir';
        $this->funcionid = 'Elegir';
        //$this->fechaFin=Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Contrato::join('function_areas as fun', 'fun.id', 'contratos.funcion_area_id') // se uno amabas tablas
            ->select('contratos.*', 'contratos.id as idContrato', 
                //'fun.name as funcion', 
                //'contratos.funcion_area_id as funcion_area_id',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('contratos.descripcion', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idContrato);
            }
        }
        else
        {
  
 
   /* Seleccionar los datos de la base de datos y paginarlos. */
            $data = Contrato::join('function_areas as fun', 'fun.id', 'contratos.funcion_area_id') // se uno amabas tablas
            ->select('contratos.*', 'contratos.id as idContrato', 
            //'fun.name as funcion', 
            //'contratos.funcion_area_id as funcion_area_id',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idContrato
                $os->verificar = $this->verificar($os->idContrato);
            }
        }

        return view('livewire.contrato.component', [
            'contratos' => $data,
            'funciones' => FunctionArea::orderBy('name', 'asc')->get()
            ]) // se envia contratos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idContrato)
    {
        $consulta = Contrato::join('employees as e', 'e.contrato_id', 'contratos.id')
        ->select('contratos.*')
        ->where('contratos.id', $idContrato)
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
        $record = Contrato::find($id, ['id','fechaInicio', 'fechaFin', 'descripcion', 'nota','funcion_area_id', 'salario','estado']);
        //dd(\Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d'));
        $this->fechaInicio = \Carbon\Carbon::parse($record->fechaInicio)->format('Y-m-d');
        $this->fechaFin = \Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d');
        //Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->descripcion = $record->descripcion;
        $this->nota = $record->nota;
        $this->funcionid = $record->funcion_area_id;
        $this->salario = $record->salario;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'salario' => 'required',
            //'estado' => 'required|not_in:Elegir',
            'funcionid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'salario.required' => 'El salario es requerido',
            //'estado.required' => 'seleccione estado de contrato',
            //'estado.not_in' => 'selecciona estado de contrato',
            'funcionid.not_in' => 'elije un nombre de funcion diferente de elegir',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'funcion_area_id' => $this->funcionid,
            'salario'=>$this->salario,
            'estado'=>'Activo'
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'salario' => 'required',
            //'estado' => 'required|not_in:Elegir',
            'funcionid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'salario.required' => 'El salario es requerido',
            //'estado.required' => 'seleccione estado de contrato',
            //'estado.not_in' => 'selecciona estado de contrato',
            'funcionid.not_in' => 'elije un nombre de funcion diferente de elegir',
        ];
        $this->validate($rules,$messages);

        $contrato = Contrato::find($this->selected_id);
        $contrato -> update([
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'funcion_area_id' => $this->funcionid,
            'salario'=>$this->salario,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Contrato Actualizada');
    }

    public function resetUI(){
        $this->fechaFin='';
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
        $this->funcionid='Elegir';
        $this->salario='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
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
