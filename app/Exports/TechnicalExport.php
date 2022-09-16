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
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;              //para que funcionen los eventos enviados
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;    // el ancho de celdas
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\View\View;

class TechnicalExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithDefaultStyles, WithEvents, WithColumnWidths, WithHeadingRow
{
    protected $userId, $dateFrom, $dateTo, $reportType;
    public $cell;
    
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
        
        
           

            return [
                'A3'=> ["SOLUCIONES INFORMATICAS EMANUEL"],
                'A4'=> ["PLANILLA DE SUELDOS Y SALARIOS PERSONAL TECNICO"],
                'A5' => ["MES DE AGOSTO"], //AGREGAR MES DE EMEISION
                'A8'=>["N", "NOMBRE", "CARGO", "HORAS TRABAJADAS", "TOTAL GANADO", "DIAS TRABAJADOS", "TOTAL GANADO", "COMISIONES", "ADELANTOS", "DESCUENTO POR FALTAS Y LICENCIAS", "DESCUENTOS VARIOS", "TOTAL PAGADO"]
            ];
        

        
    }
    //el ancho de una cell
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 10,
            'D' => 10,
            'E' => 12,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 10,          
        ];
    }
    
    //alto de columnas
    public function WithHeadingRow(): array
    {
        return [
            6 => 50         
        ];
    }
    //Definiendo en que cel se imprimira el reporte
    public function startCell(): string
    {
        return 'A3';
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
        return 'Reporte de Salarios Tecnico';
    }
    

    public function defaultStyles(Style $defaultStyle)
    {
        
    
        
    }
    //PINTAR CELDAS AL COLOR QUE QUERAMOS
    public function registerEvents(): array
    {


        //validar si es de un empleado o de todos
        
            
            //dd($Allemployee);
            //estilos para el excel para todos
            $Allemployee = 17;
            $i=6;
            $this->cell='A'.$i.':L'.($Allemployee+2);
            $this->B='B6:B'.($Allemployee+2);
            $this->C='C6:C'.($Allemployee+2);
            $this->D='D6:D'.($Allemployee+2);
            $this->E='E6:E'.($Allemployee+2);
            $this->F='F6:F'.($Allemployee+2);
            //dd($this->B);
            //dd($cell);
            return [ 
                AfterSheet::class    => function(AfterSheet $event) {
                    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                        $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    });
                    //alto de las columnas
                    /*$event->sheet->setHeight(array(
                        1     =>  50
                    ));*/
                     //centrear A3 hasta l3
                     $event->sheet->mergeCells('A3:l3');
                     $event->sheet->getDelegate()->getStyle('A3:l3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A4:l4');
                     $event->sheet->getDelegate()->getStyle('A4:l4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A5:l5');
                     $event->sheet->getDelegate()->getStyle('A5:l5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    //para el color de fondo de una celda o varias ejm:('A:C')
                    //PARA LAS FILAS PRINCIPALES DEL ENCABEZADO
                    
                  
                            
                            $event->sheet->styleCells(
                                $this->cell,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->B,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->D,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->F,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                'A6:l6',
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                
                            $event->sheet->styleCells(
                                'A6:l6',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  8,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            
    
                                
                    
                },
    
            ];
        
        
        

       
            
        
       
    }
}
