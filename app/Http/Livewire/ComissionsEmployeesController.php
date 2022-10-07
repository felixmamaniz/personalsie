<?php

namespace App\Http\Livewire;
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

    public $empleadoid, $multiplicado, $comisionn, $motivo, $selected_id, $descuentoc, $fecha, $timefrom, $timeto;
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
            ->orderBy('commissions_employees.created_at', 'asc')
            ->paginate($this->pagination);

            
        }
        else
            $data = CommissionsEmployees::join('employees as e', 'e.id', 'commissions_employees.user_id')
            ->select('commissions_employees.*','e.name as empleado')
            ->orderBy('commissions_employees.created_at', 'asc')
            ->paginate($this->pagination);

           $comissiones=UserEmployee::join('users as u', 'u.id', 'user_employees.user_id')
        ->join('employees as e', 'e.id', 'user_employees.employee_id')
        ->join('sales as s', 's.user_id', 'u.id')
        ->select('s.total', 'u.name', 's.created_at')
        ->get();

       


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
        $rules = [
            'empleadoid' => "required|not_in:Elegir|unique:commissions_employees,user_id,{$this->selected_id}",
            'multiplicado' => 'required',
            'comisionn' => 'required'
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'empleadoid.unique' => 'El empleado ya existe',
            'multiplicado.required' => 'Este espacio es requerida',
            'comisionn.required' => 'Este espacio es requerida'
        ];
        //dd($this->descuentoc);
        $this->validate($rules, $messages);
        $this->fecha = Carbon::parse(Carbon::now())->format('Y-m-d');
        $anticipo = CommissionsEmployees::create([
            'user_id' => $this->empleadoid,
            'multiplicado'=>$this->multiplicado,
            'comision'=>$this->comisionn,
            'fromtime' => $this->timefrom,
            'totime' => $this->timeto,
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
        $this->timefrom = $com->fromtime;
        $this->timeto = $com->totime;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'multiplicado' => 'required',
            'comisionn' => 'required'

        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'multiplicado.required' => 'Este espacio es requerida',
            'comisionn.required' => 'Este espacio es requerida'
        ];
        $this->validate($rules,$messages);

        $assistance = CommissionsEmployees::find($this->selected_id);
        $assistance -> update([
            'user_id' => $this->empleadoid,
            'multiplicado'=>$this->multiplicado,
            'comision'=>$this->comisionn,
            'fromtime' => $this->timefrom,
            'totime' => $this->timeto,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

     // vaciar formulario
    public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->multiplicado='';
        $this->comisionn='';
        $this->timefrom='';
        $this->timeto='';
        $this->fechaSolicitud='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }
}
