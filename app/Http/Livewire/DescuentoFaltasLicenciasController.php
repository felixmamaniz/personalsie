<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DescuentoFaltasLicencias;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;

class DescuentoFaltasLicenciasController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $selected_id,  $descripcion, $precio, $fecha;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount()
    {
        $this->componentName="Descuentos de Faltas y Licencias";
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
            $data = DescuentoFaltasLicencias::select('descuento_faltas_licencias.*')
            ->where('id', 'like', '%' . $this->search . '%')   
            //->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('id', 'asc')
            ->paginate($this->pagination);

            
        }
        else
            $data = DescuentoFaltasLicencias::select('descuento_faltas_licencias.*')
            ->orderBy('id', 'asc')
            ->paginate($this->pagination);

        foreach ($data as $d) {
            if($d->name == 1)
                $d->name = 'Falta';
            elseif($d->name == 2)
                $d->name = 'Licencia';
        }
        return view('livewire.desc_faltas_licencias.component', [
            'desc' => $data
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'empleadoid' => "required|not_in:Elegir|unique:descuento_faltas_licencias,name,{$this->empleadoid}",
            'precio' => 'required'
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'precio.required' => 'Este espacio es requerida',
            'empleadoid.unique' => 'El nombre del desucento ya existe'
        ];
        //dd($this->descuentoc);
        $this->validate($rules, $messages);
        $this->fecha = Carbon::parse(Carbon::now())->format('Y-m-d');
        $anticipo = DescuentoFaltasLicencias::create([
            'name' => $this->empleadoid,
            'precio'=>$this->precio,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Adelanto Registrado');
    }

    // editar datos
    public function Edit(DescuentoFaltasLicencias $descontar){
        $this->selected_id = $descontar->id;
        $this->empleadoid = $descontar->name;
        $this->precio = $descontar->precio;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'precio' => 'required',

        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'precio.required' => 'Este espacio es requerida'
        ];
        $this->validate($rules,$messages);

        $assistance = DescuentoFaltasLicencias::find($this->selected_id);
        $assistance -> update([
            'name' => $this->empleadoid,
            'precio'=>$this->precio
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

     // vaciar formulario
     public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->descripcion='';
        $this->precio='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];
    public function Destroy(DescuentoFaltasLicencias $desct)
    {
      
        $desct->delete();
       
        $this->resetUI();
        $this->emit('category-delete', 'Categoria Eliminada');

    } 

}
