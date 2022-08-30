<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;          // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;          //para definir los titulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;       //para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell;     //para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;               //para colocar el nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;              //para dar formato a las celdas
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;              //para que funcionen los eventos enviados
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;    // el ancho de celdas
use Illuminate\Contracts\View\View;


class AttendancesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithDefaultStyles, WithEvents, WithColumnWidths
{
    protected $userId, $dateFrom, $dateTo, $reportType;
    
    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
    }
    public function collection()
    {
        $data = [];
        //validar el tipo de reporte
        if($this->reportType == 1)
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        } else {
             //fecha de ahora 
             $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
             $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        //validar si seleccionamos algun usuario
        if($this-> userId == 0){
            //consulta
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->get();
        } else {
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->get();
        }
        //dd($data);
        //retornar datos para el exel
        return $data;
    }

    //CABECERAS DEL REPORTE
    public function headings(): array
    {
        return ["FECHA", "NOMBRE", "ENTRADA", "SALIDA", "HORARIO NORMAL", "HORAS TRABAJADAS"];
    }
    //el ancho de una cell
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,          
        ];
    }
    //Definiendo en que cel se imprimira el reporte
    public function startCell(): string
    {
        return 'A2';
    }

    //Estilos para el excel
    public function styles(Worksheet $sheet)
    {
        return [
            /*'A2' => ['font' => ['bold' => true, 'size' => 15,'color' => array('rgb' => 'blue')],
            /*'background' => [
                'color'=>  array('rgb' => 'red')
            ]
            ],*/
            'A2' => ['background' => ['rgb' => Color::COLOR_YELLOW]]
            
        ];
        
    }

    //Titulo del Excel
    public function title(): string
    {
        return 'Reporte de Asistencia';
    }
    

    public function defaultStyles(Style $defaultStyle)
    {
        
    
        
    }
    //PINTAR CELDAS AL COLOR QUE QUERAMOS
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('E2')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('red');
                $event->sheet->getDelegate()->getStyle('F2')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('blue');
  
            },
        ];
    }
}
