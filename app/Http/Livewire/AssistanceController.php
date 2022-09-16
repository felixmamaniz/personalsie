<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Assistance;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AssistanceController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $empleadoid, $fecha, $estado, $selected_id;

    public $componentName, $pageTitle, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Lista de';
        $this->componentName = 'Asistencias';
        $this->estado = 'Elegir';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = Assistance::join('employees as e', 'e.id', 'assistances.empleado_id')
            ->select('assistances.*','e.name as employ')
            ->where('assistances.estado','like','%' . $this->search . '%')
            ->orWhere('e.name', 'like', '%' . $this->search . '%')
            ->orderBy('e.name','asc')
            ->paginate($this->pagination);
        else
            $data = Assistance::join('employees as e', 'e.id', 'assistances.empleado_id')
            ->select('assistances.*','e.name as employ')
            ->orderBy('e.name','asc')
            ->paginate($this->pagination);

        return view('livewire.assistances.component',[
            'asistencias' => $data,  // se envia asistencias
            'employees' => Employee::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // vaciar formulario
    public function resetUI()
    {
        $this->empleadoid='Elegir';
        $this->fecha='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
        $this->resetPage(); // regresa la pagina
    }

    // editar datos
    public function Edit(Assistance $assistance){
        $this->selected_id = $assistance->id;
        $this->empleadoid = $assistance->empleado_id;
        $this->fecha = $assistance->fecha;
        $this->estado = $assistance->estado;

        $this->emit('show-modal', 'show modal!');
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function Store()
    {
        $rules =[
            'empleadoid' => 'required|not_in:Elegir',
            'fecha' => 'required',
            'estado' => 'required|not_in:Elegir'
        ];

        $messages = [
            'empleadoid.required' => 'Seleccione Nombre de Empleado',
            'empleadoid.not_in' => 'elije un nombre de Empleado diferente de elegir',
            'fecha.required' => 'Seleccione una fecha',
            'estado.not_in' => 'Selcciona el status',
            'estado.required' => 'Seleccione un estado de asistencia',
        ];

        $this->validate($rules, $messages);

        $user = Assistance::create([
            'empleado_id' => $this->empleadoid,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        if($this->image){
            $customFileName = uniqid() . ' _.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added','Usuario Registrado');
    }

}
