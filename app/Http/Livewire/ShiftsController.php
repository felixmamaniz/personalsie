<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\Shift;

class ShiftsController extends Component
{
    use WithPagination;
    public $shiftName, $search, $selected_id, $pageTitle, $componentName, $horaentrada, $horasalida, $minuto, $horario;
    private $pagination = 10;
    //horarios de lunes hasta el domingo
    public $horalunes, $horamartes, $horamiercoles, $horaviernes, $horajueves, $horasabado, $horadomingo;
    //horario salida de lunes a domingo
    public $shoralunes, $shoramartes, $shoramiercoles, $shorajueves, $shoraviernes, $shorasabado, $shoradomingo, $empleadoid;
    //horas y minutos para los dias de la semana
    public $horas=[] ,$minutos;
    public function cargaroption()
    {
        $c = 0;
        for ($i=0; $i <= 20; $i++) { 
            if($c<10)
            {
                $this->horas[$i]='0'.$c;
            }
            else
            {
                $this->horas[$i]=$c;
            }
            $c++;
        }
        $c = 0;
        for ($i=0; $i <= 60; $i++) { 
            if($c<10)
            {
                $this->minutos[$i]='0'.$c;
            }
            else
            {
                $this->minutos[$i]=$c;
            }
            $c++;
        }
       // dd($this->horas);
    }
    //unimos las horas en un string
    

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Turnos';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $shifts = Shift::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $shifts = Shift::select('Shifts.*')->orderBy('name', 'asc')->paginate($this->pagination);
        }

        

        return view('livewire.shifts.component', [
            'data' => $shifts,
            'employees' => Employee::orderBy('name','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    public function CreateRole()
    {
        $rules = ['empleadoid' => "required|not_in:Elegir|unique:shifts,ci,{$this->selected_id}"];

        $messages = [
            'empleadoid.required' => 'El nombre del Turno es requerido',
            'empleadoid.unique' => 'El Nombre ya existe'
        ];

        $this->validate($rules, $messages);
    $this->horario = $this->horaentrada.' a '.$this->horasalida;
        Shift::create([
            'ci' => $this->empleadoid,
            'monday' => $this->horalunes,
            'tuesday' => $this->horamartes,
            'wednesday' => $this->horamiercoles,
            'thursday' => $this->horajueves,
            'friday' => $this->horaviernes,
            'saturday' => $this->horasabado,
            'sunday' => $this->horadomingo
        ]);

        $this->emit('item-added', 'Se registró el Turno con éxito');
        $this->resetUI();
    }

    public function Edit(Shift $shift)
    {
        $this->selected_id = $shift->id;
        $this->empleadoid = $shift->ci;
        //horas
        //dd($shift);
        $this->horalunes = substr($shift->monday,0,5);
        $this->horamartes = substr($shift->tuesday,0,5);
        $this->horamiercoles = substr($shift->wednesday,0,5);
        //dd($this->horamiercoles);
        $this->horajueves = substr($shift->thursday,0,5);
        $this->horaviernes = substr($shift->friday,0,5);
        $this->horasabado = substr($shift->saturday,0,5);
        $this->horadomingo = substr($shift->Sunday,0,5);
        //minutos
        $this->shoralunes = substr($shift->monday,0,5);
        $this->shoramartes = substr($shift->tuesday,0,5);
        $this->shoramiercoles = substr($shift->wednesday,0,5);
        //dd($this->shoramiercoles);
        $this->shorajueves = substr($shift->thursday,0,5);
        $this->shoraviernes = substr($shift->friday,0,5);
        $this->shorasabado = substr($shift->saturday,0,5);
        $this->shoradomingo = substr($shift->sunday,0,5);

        $this->emit('show-modal', 'Show modal ');
    }

    public function UpdateRole()
    {
        $rules = ['empleadoid' => "required|not_in:Elegir|unique:shifts,ci,{$this->selected_id}"];

        $messages = [
            'empleadoid.required' => 'El nombre del Turno es requerido',
            'empleadoid.unique' => 'El Nombre ya existe'
        ];

        $this->validate($rules, $messages);
        $this->horario = $this->horaentrada.' a '.$this->horasalida;

        $shift = Shift::find($this->selected_id);
        $shift->name = $this->shiftName;
        $shift->horario = $this->horario;
        $shift->save();

        $this->emit('item-update', 'Se actualizó el Turno con éxito');
        $this->resetUI();
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id)
    {
       /* $employeesCount = Shift::find($id)->employees->count();
        if ($employeesCount > 0) {
            $this->emit('role-deleted', 'No se puede eliminar el Turno por que tiene permisos asociados');
            return;
        }*/

        Shift::find($id)->delete();
        $this->emit('role-deleted', 'Se elimino el Turno con exito');
    }

    public function resetUI()
    {
        $this->shiftName = '';
        $this->horaentrada = '';
        $this->horasalida = '';
        $this->horario = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
