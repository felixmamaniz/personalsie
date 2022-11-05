<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use App\Models\Employee;
use App\Models\FunctionArea;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $employeeid, $fechaInicio, $fechaFin, $descripcion, $salario, $funcionid, $estado, $selected_id;  /*$nota,*/
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Contrato';
        $this->employeeid = 'Elegir';
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
            $data = Contrato::join('employees as at', 'at.id', 'contratos.Employee_id')
            ->join('function_areas as fun', 'fun.id', 'contratos.funcion_id')
            ->select('contratos.*','at.name as name','fun.name as funcion','contratos.id as idContrato', DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('at.name', 'like', '%' . $this->search . '%')
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
            $data = Contrato::join('employees as at', 'at.id', 'contratos.employee_id')
            ->join('function_areas as fun', 'fun.id', 'contratos.funcion_id')
            ->select('contratos.*','at.name as name','fun.name as funcion','contratos.id as idContrato',DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idContrato
                $os->verificar = $this->verificar($os->idContrato);
            }
        }

        return view('livewire.contrato.component', [
                'contratos' => $data, // se envia contratos
                'empleados' => Employee::orderBy('name', 'asc')->get(),
                'funciones' => FunctionArea::orderBy('name', 'asc')->get(),
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idContrato)
    {
        $consulta = Contrato::where('contratos.id', $idContrato);
       
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // editar 
    public function Edit($id){
        $record = Contrato::find($id, ['id', 'employee_id', 'fechaInicio', 'fechaFin', 'descripcion', /*'nota',*/ 'salario', 'funcion_id','estado']);
        //dd(\Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d'));
        $this->employeeid = $record->employee_id;
        $this->fechaInicio = \Carbon\Carbon::parse($record->fechaInicio)->format('Y-m-d');
        $this->fechaFin = \Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d');
        //Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->descripcion = $record->descripcion;
        //$this->nota = $record->nota;
        $this->salario = $record->salario;
        $this->funcionid = $record->funcion_id;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'employeeid' => 'required|not_in:Elegir',
            'salario' => 'required',
            'funcionid' => 'required|not_in:Elegir',
            //'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            'employeeid.required' => 'Elija un Empleado',
            'employeeid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'salario.required' => 'El salario es requerido',
            'funcionid.required' => 'Elija una Funcion',
            'funcionid.not_in' => 'Elije una funcion diferente de elegir',
            //'estado.required' => 'seleccione estado de contrato',
            //'estado.not_in' => 'selecciona estado de contrato',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'employee_id'=>$this->employeeid,
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            //'nota'=>$this->nota,
            'salario'=>$this->salario,
            'funcion_id'=>$this->funcionid,
            'estado'=>'Activo'
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'employeeid' => 'required|not_in:Elegir',
            'salario' => 'required',
            'funcionid' => 'required|not_in:Elegir',
            //'estado' => 'required|not_in:Elegir',
        ];

        $messages = [
            'employeeid.required' => 'Elija un Empleado',
            'employeeid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'salario.required' => 'El salario es requerido',
            'funcionid.required' => 'Elija una Funcion',
            'funcionid.not_in' => 'Elije una funcion diferente de elegir',
            //'estado.required' => 'seleccione estado de contrato',
            //'estado.not_in' => 'selecciona estado de contrato',
        ];
        $this->validate($rules,$messages);

        $contrato = Contrato::find($this->selected_id);
        $contrato -> update([
            'employee_id'=>$this->employeeid,
            'fechaInicio'=>$this->fechaInicio,
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            //'nota'=>$this->nota,
            'salario'=>$this->salario,
            'funcion_id'=>$this->funcionid,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Contrato Actualizada');
    }

    public function resetUI(){
        $this->employeeid='Elegir';
        $this->fechaInicio='';
        $this->fechaFin='';
        $this->descripcion='';
        //$this->nota='';
        $this->salario='';
        $this->funcionid='Elegir';
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
