<?php

namespace App\Http\Livewire;

use Livewire\Component;
//use App\Models\AsignationFunction;
use App\Models\Area;            // areas
use App\Models\FunctionArea;    // funciones
use Livewire\withPagination;
use Illuminate\Support\Facades\DB;

class AsignarFuncionController extends Component
{
    use WithPagination;
    public $area, $componentName, $permisosSelected = [], $old_permissions = [];
    private $pagination = 10;
    
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->area = 'Elegir';
        $this->componentName = 'Asignar Funciones';
    }

    public function render()
    {
        $funciones = FunctionArea::select('name','id', DB::raw("0 as checked"))
        ->orderBy('name','asc')
        ->paginate($this->pagination);
       
        if($this->area != 'Elegir'){
            $list = FunctionArea::join('asignation_functions as rp','rp.function_id','function_areas.id')
            ->where('area_id', $this->area)->pluck('function_areas.id')->toArray();

            $this->old_permissions = $list;
        }

        if($this->area != 'Elegir'){
            foreach ($funciones as $funcion){
                $area = Area::find($this->area);
                $tienePermiso = $area->hasPermissionTo($funcion->name); // revisar
                if($tienePermiso){
                    $funcion->checked = 1;
                }
            }
        }

        return view('livewire.asignarFuncion.component',[
            'areas' => Area::orderBy('name','asc')->get(),
            'funciones' => $funciones
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public $listeners = ['revokeall' => 'removeAll'];

    // Revocar Funciones
    public function removeAll()
    {
        if($this->area == 'Elegir'){
            $this->emit('sync-error','seleccione un area valido');
            return;
        }
        $area = Area::find($this->area);
        $area->syncFunctionArea([0]); // revisar
        $this->emit('removeall',"se revocaron todos los Funcion del Area $area->name");
    }

    // sicronizacionde  funciones con areas
    public function SyncALL()
    {
        if($this->area == 'Elegir'){
            $this->emit('sync-error','seleccione un area valido');
            return;
        }
        $area = Area::find($this->area);
        $funciones = FunctionArea::pluck('id')->toArray();
        $area->syncFunctionArea($funciones); // revisar
        
        $this->emit('syncall',"se sincronizaron todos los funciones al area $area->name");
    }

    // Asignacion y revocacion de funciones
    public function syncPermiso($state, $funcionName)
    {
        if($this->area != 'Elegir'){
            $areaName = Area::find($this->area);
            if($state){
                $areaName->givePermissionTo($funcionName); // revisar
                $this->emit('permi',"funciones asignado correctamente");
            }else{
                $areaName->revokePermissionTo($funcionName); // revisar
                $this->emit('permi',"funciones eliminado correctamente");
            }
        } else{
            $this->emit('permi',"Elige un area valido");
        }
    }

}
