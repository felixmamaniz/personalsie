<?php

namespace App\Http\Livewire;

use App\Models\Comision;
use App\Models\CommissionsEmployees;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Component;

use App\Models\UserEmployee;
use App\Models\Sale;

class ComissionsEmployeesController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $multiplicado, $comisionn, $motivo, $selected_id, $descuentoc, $fecha, $timefrom, $timeto, $venta_comision, $MesVenta;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount()
    {
        $this->componentName="Comisiones Empleado";
        $this->pageTitle = "Lista";
        $this->empleadoid = "Elegir";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = CommissionsEmployees::join('employees as e', 'e.id', 'commissions_employees.user_id') // se uno amabas tablas
            ->select('commissions_employees.*','e.name as empleado')
            ->where('e.name', 'like', '%' . $this->search . '%')   
            //->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('commissions_employees.mes', 'desc')
            ->paginate($this->pagination);

            
        }
        else
            $data = CommissionsEmployees::join('employees as e', 'e.id', 'commissions_employees.user_id')
            ->select('commissions_employees.*','e.name as empleado')
            ->orderBy('commissions_employees.mes', 'desc')
            ->paginate($this->pagination);

           $comissiones=UserEmployee::join('users as u', 'u.id', 'user_employees.user_id')
        ->join('employees as e', 'e.id', 'user_employees.employee_id')
        ->join('sales as s', 's.user_id', 'u.id')
        ->select('s.total', 'u.name', 's.created_at')
        ->get();

       foreach ($data as $d) {
        $fecmes='2022-'.$d->mes.'-01';
        $date = Carbon::parse($fecmes)->format('F');
        $d->mes = $this->Mes($date);
       }

       //dd($data);
        $ventas=Sale::select('sales.*')
        ->whereBetween('created_at',['2022-08-01','2022-08-31'])
        ->where('user_id',31)
        ->orWhere('user_id',37)
        ->get();
        $sum=0;
        foreach ($ventas as $v) {
           $sum= $sum+ $v->total;
        }
       // dd($sum);
        $comision=0.10;
        $algo=5730.50*$comision;
       // dd($algo);
    
        return view('livewire.commissions_employees.component', [
            'comision' => $data,        // se envia anticipos
            'empleados' => Employee::orderBy('name', 'asc')->get(),
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    // crear y guardar
    public function Store(){

        //buscar si se tiene repetido una fecha de la comision
        $fechap=CommissionsEmployees::select('commissions_employees.*')
       ->where('commissions_employees.mes', $this->MesVenta)
       ->where('user_id',$this->empleadoid )
       ->first();
       //validar para el msg de error si no si tiene esa fecha
       
        if($fechap==null){
            $this->prueba=1;
        }
        else{
            $this->prueba=null;
        }
        $rules = [
            'empleadoid' => "required|not_in:Elegir",
            'multiplicado' => 'required',
            'comisionn' => 'required',
            'prueba' => "required_if:prueba,null",
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'multiplicado.required' => 'Este espacio es requerida',
            'comisionn.required' => 'Este espacio es requerida',
            'prueba.required_if' => 'Elija una fecha no asignada',
        ];
        $this->validate($rules, $messages);
        $this->fecha = Carbon::parse(Carbon::now())->format('Y-m-d');
       // dd($this->venta_comision);
        $anticipo = CommissionsEmployees::create([
            'user_id' => $this->empleadoid,
            'multiplicado'=>$this->multiplicado,
            'comision'=>$this->comisionn,
            'venta_comision' => $this->venta_comision,
            'mes' => $this->MesVenta,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Adelanto Registrado');
    }

    // editar datos
    public function Edit(CommissionsEmployees $com){
        $this->selected_id = $com->id;
        $this->empleadoid = $com->user_id;
        $this->multiplicado = $com->multiplicado;
        $this->comisionn = $com->comision;
        $this->venta_comision = $com->venta_comision;
        if($com->mes < 10)
        $this->MesVenta = '0'.$com->mes;
        else
        $this->MesVenta = $com->mes;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){

        $fechap=CommissionsEmployees::select('commissions_employees.*')
       ->where('commissions_employees.mes', $this->MesVenta)
       ->where('user_id',$this->empleadoid )
       ->first();
       //validar para el msg de error
       //dd($fechap);
       
        if($fechap==null){
            $this->prueba=null;
        }
        else{
            $this->prueba=1;    
        }

        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'multiplicado' => 'required',
            'comisionn' => 'required',
            'prueba' => "required_if:prueba,null",

        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'multiplicado.required' => 'Este espacio es requerida',
            'comisionn.required' => 'Este espacio es requerida',
            'prueba.required_if' => 'no se puede cambiar la fecha',
        ];
        $this->validate($rules,$messages);

        $assistance = CommissionsEmployees::find($this->selected_id);
        $assistance -> update([
            'user_id' => $this->empleadoid,
            'multiplicado'=>$this->multiplicado,
            'comision'=>$this->comisionn,
            'venta_comision' => $this->venta_comision,
            'mes' => $this->MesVenta,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

     // vaciar formulario
    public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->multiplicado='';
        $this->comisionn='';
        $this->venta_comision='';
        $this->MesVenta='';
        $this->fechaSolicitud='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

     //escuchar evento de eliminar para js
     protected $listeners = [
        'deleteRow' => 'Destroy'
    ];
    //metodo eliminar categoria con funcion nueva
    public function Destroy(CommissionsEmployees $category)
    {
        //eliminar de la tabla
        $category->delete();

        $this->resetUI();
        $this->emit('category-delete', 'Categoria Eliminada');

    }   

    public function Mes($m)
    {
       
        switch ($m) {
            case 'January':
                return 'ENERO';
                break;
            case 'February':
                return 'FEBRERO';
                break;
            case 'March':
                return 'MARZO';
                break;
            case 'April':
                return 'ABRIL';
                break;
            case 'May':
                return 'MAYO';
                break;
            case 'June':
                return 'JUNIO';
                break;
            case 'July':
                return 'JULIO';
                break;
            case 'August':
                return 'AGOSTO';
                break;
            case 'September':
                return 'SEPTIEMBRE';
                break;
            case 'October':
                return 'OCTUBRE';
                break;
            case 'November':
                return 'NOVIEMBRE';
                break;
            case 'December':
                return 'DICIEMBRE';
                break;
            default:
                return "no se encontro resultado";
        }
    }
}
