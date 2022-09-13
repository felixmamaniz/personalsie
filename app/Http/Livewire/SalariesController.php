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
    public $shiftName, $search, $selected_id, $pageTitle, $componentName, $horaentrada, $horasalida, $minuto, $horario, $detallempleado;
    private $pagination = 10;
    //vista detalles de pago del empleado
    public $sueldo, $Dtranscurridos,$pagarD, $Mtranscurridos, $pagarM;  
    //unimos las horas en un string
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->detallempleado = [];
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
        //agregar el proximo pago del mes
        foreach ($salaries as $salario) {
            $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
            $mergeAM=$mergeAM.substr($salario['fechaInicio'],7,3);
            //dd($mergeAM);
            $salario->fechaFin=$mergeAM;
        }
       
        //dd($salaries);
        //$diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
        /*$mes=Salarie::select('fechaInicio','fechaFin', DB::raw("'DATEDIFF(fechaInicio, fechaFin) AS DateDiff' as Total"))
        ->get();
        dd($mes);*/
        /*$algo=User::whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get(['name','created_at']);
        dd($algo);*/

        //crear total de salarios x mes y x año
        $pagototalmes=Salarie::select('salaries.*')->orderBy('id', 'asc')->sum('salarioMes');
        //dd($pagototalmes);
        $pagototalaño;
        //crear detalle de vista para mostrar cuando se le debe pagar pos los dias del mes trabajado y por todo el mes
        
        return view('livewire.salaries.component',[
            'data' => $salaries,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //vista del detalle de dias, meses pagados
    public function Detailspago(Salarie $emplo)
    {
        
        
        //calcular el salario por dias, por mes, por años

        //calcular por dias donde se actualice cada mes la fecha de inicio
        //agarrar la fecha de hoy y juntarla con el dia de inicio
        $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
        $mergeAM=$mergeAM.substr($emplo['fechaInicio'],7,3);
        $fechasD=carbon::parse($mergeAM);
        $fechasM=carbon::parse($emplo['fechaInicio']);
        $fechaf=carbon::parse(Carbon::now());
        //calculamos la diferencia de dias
        $diasDiferencia = $fechaf->diffInDays($fechasD);
        //calcular por mes
        $mesDiferencia = $fechaf->diffInMonths($fechasM);
        //calcular por año
        $añoDiferencia = $fechaf->diffInYears($fechasM);
        //dd($diasDiferencia.' '.$mesDiferencia.' '.$añoDiferencia);
        //sueldo a pagar x los dias transcurridos
        $pagoDias=($emplo['salarioMes']/24) * $diasDiferencia;
        //sueldo parago x los meses transcurridos
        $pagoMes=($emplo['salarioMes'] * $mesDiferencia);

        //dd($pagoMes);
        //mandar datos
        $this->sueldo=$emplo->salarioMes;
        $this->Dtranscurridos=$diasDiferencia;
        $this->pagarD=$pagoDias;
        $this->Mtranscurridos=$mesDiferencia;
        if($mesDiferencia < 1)
        $this->pagarM=0;
        else
        $this->pagarM=$pagoMes;

        //dd($this->detallempleado);
        $this->emit('detalles', 'show modal!');
    }
}
