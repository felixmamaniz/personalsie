<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ServCotizacionController extends Component
{
    public function render()
    {
        $data = "asd";

        return view('livewire.servicio.cotizacion', [
            'data' => $data,

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }




    public function crearpdf()
    {
        $this->emit('crear-cotizacion');
    }

}
