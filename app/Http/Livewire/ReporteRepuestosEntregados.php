<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReporteRepuestosEntregados extends Component
{
    public $data,$fecha,$collectRep;

    public function mount(){
        $data=collect();
    }

    public function render()
    {

        


        return view('livewire.reporterepuestos.component')
        ->extends('layouts.theme.app')
            ->section('content');
    }
}
