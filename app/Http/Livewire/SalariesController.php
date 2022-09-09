<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Salarie;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SalariesController extends Component
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
        $this->componentName = 'Salarios';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $salaries = Salarie::where('id', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $salaries = Salarie::select('salaries.*')->orderBy('id', 'asc')->paginate($this->pagination);
        }

        //calcular el salario por dias, por mes, por años
        //calcular por dias donde se actua  lice cada mes la fecha de inicio
       /* $fecha=Salarie::where('id',1)
        ->first();
        //$formatted_dt1=Carbon::parse($a->date);
        $fechas1=carbon::parse($fecha['fechaInicio']);
        $fechaf=carbon::parse(Carbon::now());
        
        //calculamos la diferencia de dias
        $diasDiferencia = $fechaf->diffInDays($fechas1);
        
        //calcular por mes
        $mesDiferencia = $fechaf->diffInMonths($fechas1);
        //calcular por año
        $añoDiferencia = $fechaf->diffInYears($fechas1);

        dd($diasDiferencia.' '.$mesDiferencia.' '.$añoDiferencia);
        */
        //dd($salaries);
        //$diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
        /*$mes=Salarie::select('fechaInicio','fechaFin', DB::raw("'DATEDIFF(fechaInicio, fechaFin) AS DateDiff' as Total"))
        ->get();
        dd($mes);*/
        /*$algo=User::whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get(['name','created_at']);
        dd($algo);*/

        return view('livewire.salaries.component',[
            'data' => $salaries,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
