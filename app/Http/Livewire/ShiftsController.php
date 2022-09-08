<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Shift;

class ShiftsController extends Component
{
    use WithPagination;
    public $shiftName, $search, $selected_id, $pageTitle, $componentName, $horaentrada, $horasalida, $minuto, $horario;
    private $pagination = 10;
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
        $rules = ['shiftName' => 'required|min:2|unique:shifts,name'];

        $messages = [
            'shiftName.required' => 'El nombre del Turno es requerido',
            'shiftName.unique' => 'El Turno ya existe',
            'shiftName.min' => 'El nombre del Turno debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);
    $this->horario = $this->horaentrada.' a '.$this->horasalida;
        Shift::create([
            'name' => $this->shiftName,
            'horario' => $this->horario
        ]);

        $this->emit('item-added', 'Se registró el Turno con éxito');
        $this->resetUI();
    }

    public function Edit(Shift $shift)
    {
        $this->selected_id = $shift->id;
        $this->shiftName = $shift->name;

        $this->emit('show-modal', 'Show modal ');
    }

    public function UpdateRole()
    {
        $rules = ['shiftName' => "required|min:2|unique:shifts,name, {$this->selected_id}"];

        $messages = [
            'shiftName.required' => 'El nombre del Turno es requerido',
            'shiftName.unique' => 'El Turno ya existe',
            'shiftName.min' => 'El nombre del Turno debe tener al menos 2 caracteres'
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
        $this->emit('role-deleted', 'Se eliminó el Turno con exito');
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
