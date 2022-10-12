<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\CalendarioLabarol;
use Carbon\Carbon;
use Livewire\Component;

class CalendarioLaboralController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $selected_id, $fecha, $descripcion;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount()
    {
        $this->componentName="Calendario Laboral";
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
            $data = CalendarioLabarol::select('calendario_laboral.*')
            ->where('id', 'like', '%' . $this->search . '%')   
            //->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('fecha', 'asc')
            ->paginate($this->pagination);

            
        }
        else
            $data = CalendarioLabarol::select('calendario_laboral.*')
            ->orderBy('fecha', 'asc')
            ->paginate($this->pagination);

        return view('livewire.calendario_laboral.component', [
            'calendario' => $data,        // se envia los datos para calendario
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

     // crear y guardar
     public function Store(){

        $fechap=CalendarioLabarol::select('calendario_laboral.*')
       ->where('fecha', $this->fecha)
       ->first();
       //validar para el msg de error
       //dd($fechap);
       
        if($fechap==null){
            $this->prueba=1;
        }
        else{
            $this->prueba=null;
        }
        $rules = [
            'descripcion' => 'required',
            'prueba' => "required_if:prueba,null",
        ];
        $messages =  [
            'descripcion.required' => 'Elija un Empleado',
            'prueba.required_if' => 'Elija una fecha no asignada',
        ];
        $this->validate($rules, $messages);
        $this->fecha = Carbon::parse(Carbon::now())->format('Y-m-d');
       // dd($this->venta_comision);
        $calendario = CalendarioLabarol::create([
            'fecha'=>$this->fecha,
            'descripcion'=>$this->descripcion
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Adelanto Registrado');
    }

    // editar datos
    public function Edit(CalendarioLabarol $com){
        $this->selected_id = $com->id;
        $this->descripcion = $com->descripcion;
        $this->fecha = $com->fecha;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){

        $fechap=CalendarioLabarol::select('calendario_laboral.*')
       ->where('fecha', $this->fecha)
       ->first();
       //validar para el msg de error
       //dd($fechap);
       
        if($fechap==null){
            $this->prueba=1;
        }
        else{
            $this->prueba=null;
        }

        $rules = [
            'descripcion' => 'required',
            'prueba' => "required_if:prueba,null",
        ];
        $messages =  [
            'descripcion.required' => 'Elija un Empleado',
            'prueba.required_if' => 'Elija una fecha no asignada',
        ];
        $this->validate($rules,$messages);

        $assistance = CalendarioLabarol::find($this->selected_id);
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
        $this->fecha='';
        $this->dns_check_record='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

     //escuchar evento de eliminar para js
     protected $listeners = [
        'deleteRow' => 'Destroy'
    ];
    //metodo eliminar categoria con funcion nueva
    public function Destroy(CalendarioLabarol $category)
    {
        //eliminar de la tabla
        $category->delete();

        $this->resetUI();
        $this->emit('category-delete', 'Categoria Eliminada');

    }  
}
