<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AttendancesController extends Component
{
    use WithPagination;
    public $data, $reportType, $userId, $dateFrom, $dateTo, $horaentrada,$horaconformada;
    public $pagination;
   
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    //propiedades de las vistas
    public function mount(){
        $this->pagination = 10;
        $this->data = [];
        $this->reportType = 0;
        $this->userId = 0;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function render()
    {
        $this->SalesByDate();
        return view('livewire.attendances.component',[
            'employees' => Employee::orderBy('name','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //metodo retornar reporte de la fecha
    public function SalesByDate()
    {
        
        //obtener las entradas del dia
        if($this->reportType == 0)// entradas del dia
        {
            //obtener fecha de hoy
            $from = Carbon::parse(Carbon::now())->format('Y-m-d');
            $to = Carbon::parse(Carbon::now())->format('Y-m-d');
        } else {
            //obtener fechas especificadas por el usuario
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d');
            $to = Carbon::parse($this->dateTo)->format('Y-m-d');
            
        }   
        //validar si el usuario esta usando un tipo de reporte
        // if($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
        //     dd("Hola");
        //     return;
        // }
        //validar si seleccionamos algun usuario
        if($this->userId == 0){
            $emplo=Employee::orderBy('name','asc')->get();
            //dd($emplo);
            //consulta
            $xd=Attendance::select('attendances.*')->get();
            //dd($xd);
            $this->data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.*','e.name as employee', DB::raw('0 as retraso'), DB::raw('0 as hcumplida') )
            ->whereBetween('attendances.fecha', [$from,$to])
            //->groupBy("e.id")
            ->orderBy('attendances.fecha','desc')
            //->paginate($this->pagination);
            ->get();

            //dd($this->data);
            //agregar el tiempo de retrasa del empleado
            foreach ($this->data as $os)
                                {   
                                    //validar el horario conformado y enviarlo a unfuncion para calcular
                                    //if($os->turno=='medio turno TARDE' || $os->permiso =='tarde')
                                    if($os->entrada>'14:00:00') {
                                        
                                    $timestamp = $this->strtotime($os->entrada,"14:00:00");
                                    //dd($timestamp);
                                    $os->retraso = $timestamp;
                                    }
                                    //if($os->turno=='medio turno mañana' || $os->permiso =='mañana')
                                        elseif($os->entrada>'08:00:00')
                                        {
                                            $timestamp = $this->strtotime($os->entrada,"08:00:00");
                                            //dd($timestamp);
                                            $os->retraso = $timestamp;
                                        }   else{
                                                $os->retraso = 'NO TRABAJO';
                                            }
                                    
                                }
            //agregar las horas cumplidas del usuario
            foreach ($this->data as $os)
            {
                $timeacumleted= $this->horascumplidas($os->entrada, $os->salida);
                if($os->employee=='Carlos')
                {
                    //dd($timeacumleted);
                }
                if($timeacumleted>'04:40:00')
                {
                    
                    $os->hcumplida='Cumplio';
                    
                }
                else{
                    $os->hcumplida='No Cumplio';
                }

            }
                                
            
        } else {

            $this->data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.*','e.name as employee',DB::raw('0 as retraso'))
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->get();
            //agregar el tiempo de retrasa del empleado
            foreach ($this->data as $os)
                                {   
                                     //validar el horario conformado y enviarlo a unfuncion para calcular
                                    if($os->entrada>'14:00:00') {
                                        
                                    $timestamp = $this->strtotime($os->entrada,"14:00:00");
                                    //dd($timestamp);
                                    $os->retraso = $timestamp;
                                    }
                                    
                                    else
                                    $os->retraso = 'NO TRABAJO';
                                }
        }
    }
    //calcular el horario cumplido del empleado
    public function horascumplidas($horaentrada, $horasalida)
    {
        $timeacumleted='';
        //hora que entro el empleado
        $horaE=(int)  substr($horaentrada,0,2);
        $minutoE=(int)  substr($horaentrada,3,2);
        $segundoE=(int)  substr($horaentrada,6,2);
        //hora que salio el empleado
        $horaS=(int)  substr($horasalida,0,2);
        $minutoS=(int)  substr($horasalida,3,2);
        $segundoS=(int)  substr($horasalida,6,2);
        
        $horaretraso=abs($horaS-$horaE);
        $minutoretraso=abs($minutoS-$minutoE);
        $segundosretraso=abs($segundoS-$segundoE);

        if($minutoE > $minutoS)
        {
            $horaretraso= abs($horaretraso-1);
        }
        
        //validar el time para que retorne valor ordenado
        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso<10){
            $timeacumleted='0'.$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }
        //para ver si funciona a o no
        /*if($horaentrada=='14:25:17')
        {
            dd($minutoretraso);
            dd($horataconformada.':'.$minutoconformada.':'.$segundoconformada);
        }*/
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso>9){
            $timeacumleted=$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso>9){
            $timeacumleted=$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso>9 && $horaretraso<10){
            $timeacumleted='0'.$horaretraso.':'.$minutoretraso.':0'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso<10 && $horaretraso<10)
        {
            $timeacumleted='0'.$horaretraso.':0'.$minutoretraso.':'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso<10)
        {
            $timeacumleted='0'.$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }
        
        //dd($retraso);
        return $timeacumleted;
    }
    //calcular el tiempo del retraso del empleado
    public function strtotime($horaentrada,$horaconformada)
    {
      
        $timestamp='';
        //hora que entro el empleado
        $hora=(int)  substr($horaentrada,0,2);
        $minuto=(int)  substr($horaentrada,3,2);
        $segundo=(int)  substr($horaentrada,6,2);
        //horaconfomada asginada para entrar
        $horataconformada=(int)  substr($horaconformada,0,2);
        $minutoconformada=(int)  substr($horaconformada,3,2);
        $segundoconformada=(int)  substr($horaconformada,6,2);
        //calculamos el retrasa
        $horaretraso=$hora-$horataconformada;
        $minutoretraso=$minuto-$minutoconformada;
        $segundosretraso=$segundo-$segundoconformada;
        //validar el time para que retorne valor ordenado
        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso<10){
            $timestamp='0'.$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }
        //para ver si funciona a o no
        /*if($horaentrada=='14:25:17')
        {
            dd($minutoretraso);
            dd($horataconformada.':'.$minutoconformada.':'.$segundoconformada);
        }*/
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso>9){
            $timestamp=$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso>9){
            $timestamp=$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso>9 && $horaretraso<10){
            $timestamp='0'.$horaretraso.':'.$minutoretraso.':0'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso<10 && $horaretraso<10)
        {
            $timestamp='0'.$horaretraso.':0'.$minutoretraso.':'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso<10)
        {
            $timestamp='0'.$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }
        
        //dd($retraso);
        return $timestamp;
        
    }
}