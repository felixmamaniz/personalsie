<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;

class ReporteRepuestosEntregados extends Component
{
    public $dataProceso,$dataTerminados,$dataEntregados,$fecha,$collectRep,$estadoServicios;

    public function mount(){
        $data=collect();
    }

    public function render()
    {
            $this->dataProceso= Service::join('mov_services','mov_services.service_id','services.id')
            ->join('movimientos','movimientos.id','mov_services.movimiento_id')
            ->join('service_rep_detalle_solicituds','services.id','service_rep_detalle_solicituds.service_id')
            ->join('service_rep_estado_solicituds','service_rep_estado_solicituds.detalle_solicitud_id','service_rep_detalle_solicituds.id')
            ->join('salida_servicios','salida_servicios.service_id','services.id')
            ->join('salida_productos','salida_productos.id','salida_servicios.salida_id')
            ->join('detalle_salida_productos','detalle_salida_productos.id_salida','salida_productos.id')
            ->join('salida_lotes','salida_lotes.salida_detalle_id','detalle_salida_productos.id')
            ->join('lotes','salida_lotes.lote_id','lotes.id')
            ->join('products','products.id','lotes.product_id')
            ->join('users','users.id','movimientos.user_id')
            ->where('movimientos.type','PROCESO')
            ->where('movimientos.status','ACTIVO')
            ->where('service_rep_estado_solicituds.status','ACTIVO')
            ->where(function($query){
                $query->where('service_rep_estado_solicituds.estado','ACEPTADO')
                      ->orWhere('service_rep_estado_solicituds.estado','COMPRADO');
                    })
            ->get();
          //dd($dataProceso);

        return view('livewire.reporterepuestos.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
